<?php

namespace App\Models;

use CodeIgniter\Model;

class GameModel extends Model
{
    protected $table            = 'game';
    protected $primaryKey       = 'id_game';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_game', 'slug', 'logo', 'deskripsi', 'created_at', 'updated_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'nama_game' => 'required|min_length[3]|is_unique[game.nama_game,id_game,{id_game}]',
    ];
    protected $validationMessages   = [
        'nama_game' => [
            'required'    => 'Nama game harus diisi.',
            'min_length'  => 'Nama game minimal 3 karakter.',
            'is_unique'   => 'Nama game sudah terdaftar.',
        ]
    ];
    protected $skipValidation       = false;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['generateSlug'];
    protected $beforeUpdate   = ['generateSlug'];

    protected function generateSlug(array $data)
    {
        if (isset($data['data']['nama_game'])) {
            helper('text');
            // If they mean a custom helper 'slugify', this function fallback handles it.
            // But usually url_title is standard in CI4.
            if (function_exists('slugify')) {
                $data['data']['slug'] = slugify($data['data']['nama_game']);
            } else {
                $data['data']['slug'] = url_title($data['data']['nama_game'], '-', true);
            }
        }
        return $data;
    }

    // Relasi ke turnamen
    public function getTurnamen($id_game)
    {
        $db = \Config\Database::connect();
        return $db->table('turnamen')->where('id_game', $id_game)->get()->getResultArray();
    }
}
