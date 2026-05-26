<?php

namespace App\Models;

use CodeIgniter\Model;

class TurnamenModel extends Model
{
    protected $table            = 'turnamen';
    protected $primaryKey       = 'id_turnamen';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['nama_turnamen', 'deskripsi', 'id_game', 'tanggal_mulai', 'biaya_pendaftaran', 'status', 'banner'];

    public function getTurnamenAktif()
    {
        return $this->where('status !=', 'Berlangsung')->findAll();
    }
}
