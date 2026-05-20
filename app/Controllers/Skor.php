<?php

namespace App\Controllers;

use App\Models\SkorModel;
use App\Models\JadwalModel;

class Skor extends BaseController
{
    public function index()
    {
        $peran = session()->get('peran');
        if (!in_array($peran, ['Admin', 'AdminGame'])) {
            return redirect()->to('dashboard')->with('error', 'Akses ditolak.');
        }

        $model = new SkorModel();
        $data['skor'] = $model->getSkorWithDetail();
        $data['title'] = 'Manajemen Skor';
        return view('skor/index', $data);
    }

    public function input($id_jadwal)
    {
        $peran = session()->get('peran');
        if (!in_array($peran, ['Admin', 'AdminGame'])) {
            return redirect()->to('dashboard')->with('error', 'Akses ditolak.');
        }

        $jadwalModel = new JadwalModel();
        $jadwalDetail = $jadwalModel->select('jadwal.*, tim1.nama_tim as nama_tim_1, tim2.nama_tim as nama_tim_2')
                                    ->join('tim as tim1', 'tim1.id_tim = jadwal.id_tim_1')
                                    ->join('tim as tim2', 'tim2.id_tim = jadwal.id_tim_2')
                                    ->where('jadwal.id_jadwal', $id_jadwal)
                                    ->first();

        $data['jadwal'] = $jadwalDetail;
        $data['skor_existing'] = $skorModel->where('id_jadwal', $id_jadwal)->first();
        $data['title'] = 'Input Skor Pertandingan';
        return view('skor/form', $data);
    }

    public function simpan()
    {
        $peran = session()->get('peran');
        if (!in_array($peran, ['Admin', 'AdminGame'])) {
            return redirect()->to('dashboard')->with('error', 'Akses ditolak.');
        }

        $model = new SkorModel();
        
        $id_jadwal = $this->request->getVar('id_jadwal');
        $skor_tim_1 = $this->request->getVar('skor_tim_1');
        $skor_tim_2 = $this->request->getVar('skor_tim_2');
        
        $jadwalModel = new JadwalModel();
        $jadwal = $jadwalModel->find($id_jadwal);
        
        $id_tim_pemenang = null;
        if ($skor_tim_1 > $skor_tim_2) {
            $id_tim_pemenang = $jadwal['id_tim_1'];
        } elseif ($skor_tim_2 > $skor_tim_1) {
            $id_tim_pemenang = $jadwal['id_tim_2'];
        }

        $data = [
            'id_jadwal'       => $id_jadwal,
            'skor_tim_1'      => $skor_tim_1,
            'skor_tim_2'      => $skor_tim_2,
            'id_tim_pemenang' => $id_tim_pemenang,
        ];
        
        // Cek apakah sudah ada
        $existing = $model->where('id_jadwal', $id_jadwal)->first();
        if ($existing) {
            $model->update($existing['id_skor'], $data);
        } else {
            $model->insert($data);
        }
        
        return redirect()->to('skor')->with('success', 'Skor berhasil disimpan.');
    }
}