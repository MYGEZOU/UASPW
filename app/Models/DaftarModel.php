<?php

namespace App\Models;

use CodeIgniter\Model;

class DaftarModel extends Model
{
    protected $table            = 'daftar';
    protected $primaryKey       = 'id_daftar';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_turnamen', 'id_tim', 'tanggal_daftar', 'status_pembayaran', 'bukti_pembayaran', 'tanggal_konfirmasi', 'id_akun_konfirmasi'];

    public function getPendaftaranWithDetail()
    {
        return $this->select('daftar.*, turnamen.nama_turnamen, turnamen.biaya_pendaftaran, tim.nama_tim')
                    ->join('turnamen', 'turnamen.id_turnamen = daftar.id_turnamen')
                    ->join('tim', 'tim.id_tim = daftar.id_tim')
                    ->findAll();
    }

    public function getPendaftaranByTim($id_tim)
    {
        return $this->select('daftar.*, turnamen.nama_turnamen, turnamen.tanggal_mulai, turnamen.status, turnamen.biaya_pendaftaran, game.nama_game')
                    ->join('turnamen', 'turnamen.id_turnamen = daftar.id_turnamen')
                    ->join('game', 'game.id_game = turnamen.id_game', 'left')
                    ->where('daftar.id_tim', $id_tim)
                    ->findAll();
    }
    
    public function getTimByTurnamen($id_turnamen)
    {
        return $this->select('daftar.*, tim.nama_tim, tim.asal_kota')
                    ->join('tim', 'tim.id_tim = daftar.id_tim')
                    ->where('daftar.id_turnamen', $id_turnamen)
                    ->findAll();
    }
}
