<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GameSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        
        $games = [
            ['nama_game' => 'Mobile Legends', 'slug' => 'mobile-legends', 'created_at' => date('Y-m-d H:i:s')],
            ['nama_game' => 'PUBG Mobile', 'slug' => 'pubg-mobile', 'created_at' => date('Y-m-d H:i:s')],
            ['nama_game' => 'Free Fire', 'slug' => 'free-fire', 'created_at' => date('Y-m-d H:i:s')],
            ['nama_game' => 'Valorant', 'slug' => 'valorant', 'created_at' => date('Y-m-d H:i:s')],
        ];

        foreach ($games as $game) {
            // Check if game exists
            $existing = $db->table('game')->where('nama_game', $game['nama_game'])->get()->getRow();
            if (!$existing) {
                $db->table('game')->insert($game);
            }
        }
    }
}
