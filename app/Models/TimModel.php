<?php

namespace App\Models;

use CodeIgniter\Model;

class TimModel extends Model
{
    protected $table            = 'tim';
    protected $primaryKey       = 'id_tim';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_akun', 'nama_tim', 'asal_kota', 'kontak_kapten'];

    public function getTimByAkun($id_akun)
    {
        return $this->where('id_akun', $id_akun)->first();
    }
    
    public function getTimWithAkun()
    {
        return $this->select('tim.*, akun.nama_lengkap, akun.username')
                    ->join('akun', 'akun.id_akun = tim.id_akun')
                    ->findAll();
    }
}
