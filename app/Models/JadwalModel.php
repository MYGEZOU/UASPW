<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalModel extends Model
{
    protected $table            = 'jadwal';
    protected $primaryKey       = 'id_jadwal';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_turnamen', 'id_tim_1', 'id_tim_2', 'jadwal_tanding', 'babak'];

    // Validation
    protected $validationRules      = [
        'id_turnamen'    => 'required|is_not_unique[turnamen.id_turnamen]',
        'id_tim_1'       => 'required|is_not_unique[tim.id_tim]',
        'id_tim_2'       => 'required|is_not_unique[tim.id_tim]|differs[id_tim_1]',
        'jadwal_tanding' => 'required|valid_date',
        'babak'          => 'required|max_length[20]',
    ];
    protected $validationMessages   = [
        'id_turnamen' => [
            'required' => 'Turnamen wajib dipilih.',
            'is_not_unique' => 'Turnamen tidak valid atau tidak terdaftar.'
        ],
        'id_tim_1' => [
            'required' => 'Tim 1 wajib dipilih.',
            'is_not_unique' => 'Tim 1 tidak terdaftar di sistem.'
        ],
        'id_tim_2' => [
            'required' => 'Tim 2 wajib dipilih.',
            'is_not_unique' => 'Tim 2 tidak terdaftar di sistem.',
            'differs' => 'Tim 2 tidak boleh sama dengan Tim 1.'
        ],
        'jadwal_tanding' => [
            'required' => 'Waktu pertandingan wajib diisi.',
            'valid_date' => 'Format waktu tidak valid.'
        ],
        'babak' => [
            'required' => 'Babak pertandingan wajib diisi.',
            'max_length' => 'Nama babak maksimal 20 karakter.'
        ]
    ];
    protected $skipValidation       = false;

    private function baseQuery(bool $withSkor = true)
    {
        $builder = $this->select('jadwal.*, turnamen.nama_turnamen, game.nama_game as game, tim1.nama_tim as nama_tim_1, tim2.nama_tim as nama_tim_2')
                        ->join('turnamen', 'turnamen.id_turnamen = jadwal.id_turnamen', 'left')
                        ->join('game', 'game.id_game = turnamen.id_game', 'left')
                        ->join('tim as tim1', 'tim1.id_tim = jadwal.id_tim_1', 'left')
                        ->join('tim as tim2', 'tim2.id_tim = jadwal.id_tim_2', 'left');
                        
        if ($withSkor) {
            $builder->select('skor.skor_tim_1, skor.skor_tim_2, skor.id_tim_pemenang')
                    ->join('skor', 'skor.id_jadwal = jadwal.id_jadwal', 'left');
        }
        
        return $builder;
    }

    public function getJadwalWithDetail()
    {
        return $this->baseQuery()->findAll();
    }

    public function getJadwalByTurnamen($id_turnamen)
    {
        return $this->baseQuery()->where('jadwal.id_turnamen', $id_turnamen)->findAll();
    }

    public function getJadwalHariIni()
    {
        $today = date('Y-m-d');
        return $this->baseQuery(false)->like('jadwal_tanding', $today)->findAll();
    }

    public function getJadwalByTim($id_tim)
    {
        return $this->baseQuery()
                    ->groupStart()
                        ->where('jadwal.id_tim_1', $id_tim)
                        ->orWhere('jadwal.id_tim_2', $id_tim)
                    ->groupEnd()
                    ->findAll();
    }
}
