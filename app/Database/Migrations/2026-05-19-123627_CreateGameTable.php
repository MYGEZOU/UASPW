<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGameTable extends Migration
{
    public function up()
    {
        // 1. Create table `game`
        $this->forge->addField([
            'id_game' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_game' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true,
            ],
            'slug' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true,
            ],
            'logo' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_game', true);
        $this->forge->createTable('game');

        // 2. Add id_game to turnamen
        $this->forge->addColumn('turnamen', [
            'id_game' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'nama_turnamen',
            ],
        ]);

        // Insert initial games here so we can map them, since we need to match data.
        // It's safer to just let the Seeder insert the games and map it, 
        // but since migration requires removing the old column, we should do mapping here or just wait.
        // The prompt says: "lalu pindahkan data dari kolom game (varchar) ke id_game dengan mencocokkan nama game yang sudah ada (buat mapping otomatis). Setelah itu hapus kolom game yang lama."
        
        // Insert standard games
        $db = \Config\Database::connect();
        $builder = $db->table('game');
        
        $games = [
            ['nama_game' => 'Mobile Legends', 'slug' => 'mobile-legends', 'created_at' => date('Y-m-d H:i:s')],
            ['nama_game' => 'PUBG Mobile', 'slug' => 'pubg-mobile', 'created_at' => date('Y-m-d H:i:s')],
            ['nama_game' => 'Free Fire', 'slug' => 'free-fire', 'created_at' => date('Y-m-d H:i:s')],
            ['nama_game' => 'Valorant', 'slug' => 'valorant', 'created_at' => date('Y-m-d H:i:s')]
        ];
        $builder->insertBatch($games);

        // Get all unique game names from turnamen
        $turnamenGames = $db->query("SELECT DISTINCT game FROM turnamen WHERE game IS NOT NULL AND game != ''")->getResultArray();
        foreach ($turnamenGames as $tg) {
            $gameName = $tg['game'];
            // check if exists
            $existing = $db->query("SELECT id_game FROM game WHERE nama_game = ?", [$gameName])->getRow();
            if ($existing) {
                $db->query("UPDATE turnamen SET id_game = ? WHERE game = ?", [$existing->id_game, $gameName]);
            } else {
                // Insert new game
                $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $gameName)));
                $db->query("INSERT INTO game (nama_game, slug, created_at) VALUES (?, ?, ?)", [$gameName, $slug, date('Y-m-d H:i:s')]);
                $newId = $db->insertID();
                $db->query("UPDATE turnamen SET id_game = ? WHERE game = ?", [$newId, $gameName]);
            }
        }

        // Add foreign key constraint
        $this->forge->addForeignKey('id_game', 'game', 'id_game', 'CASCADE', 'RESTRICT');
        $this->forge->processIndexes('turnamen'); // to apply foreign key if needed
        // Since addForeignKey is best done during createTable or needs a separate alter query in CI4.
        // CI4 Forge addForeignKey on existing table requires $this->forge->addForeignKey ... and then modify table or we can just run raw query.
        $db->query("ALTER TABLE turnamen ADD CONSTRAINT fk_turnamen_game FOREIGN KEY (id_game) REFERENCES game(id_game) ON DELETE RESTRICT ON UPDATE CASCADE");

        // Remove old 'game' column
        $this->forge->dropColumn('turnamen', 'game');
    }

    public function down()
    {
        $this->forge->addColumn('turnamen', [
            'game' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ]
        ]);
        
        $db = \Config\Database::connect();
        $db->query("UPDATE turnamen t JOIN game g ON t.id_game = g.id_game SET t.game = g.nama_game");
        
        $db->query("ALTER TABLE turnamen DROP FOREIGN KEY fk_turnamen_game");
        
        $this->forge->dropColumn('turnamen', 'id_game');
        $this->forge->dropTable('game');
    }
}
