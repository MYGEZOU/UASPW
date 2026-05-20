<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBannerToTurnamen extends Migration
{
    public function up()
    {
        $this->forge->addColumn('turnamen', [
            'banner' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'default'    => 'default_banner.jpg',
            ],
        ]);
        
        $db = \Config\Database::connect();
        $db->query("UPDATE turnamen SET banner = 'default_banner.jpg' WHERE banner IS NULL");
    }

    public function down()
    {
        $this->forge->dropColumn('turnamen', 'banner');
    }
}
