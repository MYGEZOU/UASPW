<?php

namespace App\Models;

use CodeIgniter\Model;

class SkorModel extends Model
{
    protected $table            = 'skor';
    protected $primaryKey       = 'id_skor';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_jadwal', 'skor_tim_1', 'skor_tim_2', 'id_tim_pemenang'];

    public function getSkorWithDetail()
    {
        return $this->select('skor.*, jadwal.jadwal_tanding, jadwal.babak, turnamen.nama_turnamen, tim1.nama_tim as nama_tim_1, tim2.nama_tim as nama_tim_2, tim_pemenang.nama_tim as pemenang')
                    ->join('jadwal', 'jadwal.id_jadwal = skor.id_jadwal')
                    ->join('turnamen', 'turnamen.id_turnamen = jadwal.id_turnamen')
                    ->join('tim as tim1', 'tim1.id_tim = jadwal.id_tim_1')
                    ->join('tim as tim2', 'tim2.id_tim = jadwal.id_tim_2')
                    ->join('tim as tim_pemenang', 'tim_pemenang.id_tim = skor.id_tim_pemenang', 'left')
                    ->findAll();
    }
    
    public function getSkorByJadwal($id_jadwal)
    {
        return $this->where('id_jadwal', $id_jadwal)->first();
    }
}
