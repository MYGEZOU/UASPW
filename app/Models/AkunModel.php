<?php

namespace App\Models;

use CodeIgniter\Model;

class AkunModel extends Model
{
    protected $table            = 'akun';
    protected $primaryKey       = 'id_akun';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['username', 'email', 'password', 'nama_lengkap', 'peran', 'tanggal_dibuat'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'tanggal_dibuat';
    
    public function getAkun($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        }
        return $this->where(['id_akun' => $id])->first();
    }

    /**
     * Cek apakah kombinasi email + username ada di database.
     * Mengembalikan row akun jika cocok, null jika tidak.
     */
    public function cekEmailDanUsername(string $email, string $username): ?array
    {
        return $this->where('email', $email)
                    ->where('username', $username)
                    ->first();
    }
}
