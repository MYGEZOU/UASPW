<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIdAkunToAnggota extends Migration
{
    public function up()
    {
        $this->forge->addColumn('anggota', [
            'id_akun' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'after'      => 'id_tim',
            ],
        ]);
        
        // Add index
        $db = \Config\Database::connect();
        $db->query('ALTER TABLE anggota ADD INDEX idx_anggota_akun (id_akun)');
    }

    public function down()
    {
        $this->forge->dropColumn('anggota', 'id_akun');
    }
}
