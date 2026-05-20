<?php

namespace App\Controllers;

use App\Models\TurnamenModel;
use App\Models\TimModel;
use App\Models\JadwalModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $turnamenModel = new TurnamenModel();
        $timModel = new TimModel();
        $jadwalModel = new JadwalModel();

        $data = [
            'title' => 'Dashboard',
            'total_turnamen' => count($turnamenModel->findAll()),
            'total_tim' => count($timModel->findAll()),
            'jadwal_hari_ini' => count($jadwalModel->getJadwalHariIni())
        ];

        $peran = session()->get('peran');

        if ($peran == 'Admin') {
            $akunModel = new \App\Models\AkunModel();
            $daftarModel = new \App\Models\DaftarModel();
            
            $data['total_turnamen_aktif'] = count($turnamenModel->getTurnamenAktif());
            $data['total_tim'] = count($timModel->findAll());
            $data['total_peserta'] = count($akunModel->where('peran', 'Peserta')->findAll());
            
            // Hitung pendapatan
            $pendaftaran = $daftarModel->getPendaftaranWithDetail();
            $pendapatan = 0;
            foreach($pendaftaran as $p) {
                if ($p['status_pembayaran'] == 'Lunas') {
                    // cari biaya turnamen
                    $turnamen = $turnamenModel->find($p['id_turnamen']);
                    $pendapatan += $turnamen['biaya_pendaftaran'];
                }
            }
            $data['total_pendapatan'] = $pendapatan;
            
            // Limit pendaftaran terbaru
            $data['pendaftaran_terbaru'] = array_slice($pendaftaran, 0, 5);
            
            return view('dashboard/admin', $data);
        } elseif ($peran == 'AdminGame') {
            $data['title'] = 'Dashboard Admin Game';
            $data['turnamen_aktif'] = count($turnamenModel->getTurnamenAktif());
            $data['pertandingan_hari_ini'] = count($jadwalModel->getJadwalHariIni());
            
            $jadwal = $jadwalModel->getJadwalWithDetail();
            $data['jadwal_terbaru'] = array_slice($jadwal, 0, 5);
            
            return view('dashboard/admin_game', $data);
        } elseif ($peran == 'Peserta') {
            $data['title'] = 'Dashboard Peserta';
            $data['tim_peserta'] = null;
            $data['turnamen_diikuti'] = [];
            $data['jadwal_tim'] = [];
            
            $id_akun = session()->get('id_akun');
            
            // Layer 1: cek apakah kapten tim
            $tim = $timModel->where('id_akun', $id_akun)->first();
            
            // Layer 2: cek apakah anggota tim orang lain
            if (!$tim) {
                $anggotaModel = new \App\Models\AnggotaModel();
                $id_tim_anggota = $anggotaModel->getTimByAnggotaAkun($id_akun);
                if ($id_tim_anggota) {
                    $tim = $timModel->find($id_tim_anggota);
                    // Sinkronkan session id_tim agar fitur lain berjalan
                    if ($tim && !session()->get('id_tim')) {
                        session()->set('id_tim', $tim['id_tim']);
                    }
                }
            }
            
            if ($tim) {
                $data['tim_peserta'] = $tim;
                $daftarModel = new \App\Models\DaftarModel();
                $data['turnamen_diikuti'] = $daftarModel->getPendaftaranByTim($tim['id_tim']);
                $data['jadwal_tim'] = $jadwalModel->getJadwalByTim($tim['id_tim']);
            }
            return view('dashboard/peserta', $data);
        } else {
            return redirect()->to('login');
        }
    }
}
