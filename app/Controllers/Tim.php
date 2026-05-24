<?php

namespace App\Controllers;

use App\Models\TimModel;
use App\Models\AnggotaModel;

class Tim extends BaseController
{
    public function index()
    {
        $model = new TimModel();
        
        $peran = session()->get('peran');
        if ($peran == 'Admin' || $peran == 'AdminGame') {
            $data['tim'] = $model->getTimWithAkun();
            $data['title'] = 'Manajemen Tim';
            return view('tim/index', $data);
        } else {
            return redirect()->to('dashboard')->with('error', 'Akses ditolak.');
        }
    }

    public function detail($id)
    {
        $peran = session()->get('peran');
        if (!in_array($peran, ['Admin', 'AdminGame'])) {
            return redirect()->to('dashboard')->with('error', 'Akses ditolak.');
        }

        $model = new TimModel();
        $anggotaModel = new AnggotaModel();
        
        $data['tim'] = $model->find($id);
        if (!$data['tim']) {
            return redirect()->to('tim')->with('error', 'Tim tidak ditemukan.');
        }
        
        $data['anggota'] = $anggotaModel->getAnggotaByTim($id);
        $data['title'] = 'Detail Tim: ' . $data['tim']['nama_tim'];
        return view('tim/detail', $data);
    }

    public function profil()
    {
        // Peserta melihat profil tim sendiri
        $model        = new TimModel();
        $anggotaModel = new AnggotaModel();
        $id_akun      = session()->get('id_akun');
        
        // Cek 1: Apakah user ini pemilik/kapten tim?
        $tim = $model->getTimByAkun($id_akun);
        
        // Cek 2: Jika tidak, apakah user ini anggota dari tim lain?
        if (!$tim) {
            $id_tim_anggota = $anggotaModel->getTimByAnggotaAkun($id_akun);
            if ($id_tim_anggota) {
                $tim = $model->find($id_tim_anggota);
                // Sinkronkan session id_tim jika belum tersimpan
                if ($tim) {
                    session()->set('id_tim', $tim['id_tim']);
                }
            }
        }
        
        $data['title']   = 'Profil Tim';
        $data['tim']     = $tim;
        $data['is_kapten'] = $tim ? ($tim['id_akun'] == $id_akun) : false;
        
        if ($tim) {
            // Ambil anggota beserta email akun yang terhubung
            $rawAnggota = $anggotaModel->getAnggotaByTim($tim['id_tim']);
            $akunModel  = new \App\Models\AkunModel();
            $data['anggota'] = array_map(function($a) use ($akunModel) {
                if ($a['id_akun']) {
                    $akun = $akunModel->find($a['id_akun']);
                    $a['email_akun'] = $akun['email'] ?? null;
                } else {
                    $a['email_akun'] = null;
                }
                return $a;
            }, $rawAnggota);
            
            // Daftar peserta yang belum terhubung ke anggota manapun
            if ($data['is_kapten']) {
                $semuaPeserta = $akunModel->where('peran', 'Peserta')->findAll();
                $terhubung    = array_filter(array_column($rawAnggota, 'id_akun'));
                
                // Ambil semua id_akun yang sudah menjadi kapten di tim manapun
                $semuaKapten = array_filter(array_column($model->findAll(), 'id_akun'));
                
                $data['peserta_tersedia'] = array_values(array_filter($semuaPeserta, function($p) use ($terhubung, $semuaKapten) {
                    // Kecualikan yang sudah terhubung atau yang sudah menjadi kapten
                    return !in_array($p['id_akun'], $terhubung) && !in_array($p['id_akun'], $semuaKapten);
                }));
            } else {
                $data['peserta_tersedia'] = [];
            }
        } else {
            $data['anggota'] = [];
            $data['peserta_tersedia'] = [];
        }
        return view('tim/profil', $data);
    }

    public function tambah()
    {
        $data['title'] = 'Buat Tim Baru';
        $peran = session()->get('peran');
        
        // Peserta yang sudah punya tim (kapten atau anggota) tidak bisa buat tim baru
        if ($peran === 'Peserta') {
            $id_akun = session()->get('id_akun');
            $model = new TimModel();
            $timAda = $model->where('id_akun', $id_akun)->first();
            if (!$timAda) {
                $anggotaModel = new AnggotaModel();
                $idTimAnggota = $anggotaModel->getTimByAnggotaAkun($id_akun);
                if ($idTimAnggota) {
                    return redirect()->to('tim/profil')->with('error', 'Anda sudah menjadi anggota tim. Tidak bisa membuat tim baru.');
                }
            } elseif ($timAda) {
                return redirect()->to('tim/profil')->with('info', 'Anda sudah memiliki tim.');
            }
        }
        
        if ($peran === 'Admin') {
            $akunModel = new \App\Models\AkunModel();
            $data['akun_peserta'] = $akunModel->where('peran', 'Peserta')->findAll();
        }
        return view('tim/form', $data);
    }

    public function simpan()
    {
        $model = new TimModel();

        // id_akun: dari hidden input (Peserta) atau dari dropdown (Admin)
        $id_akun = $this->request->getVar('id_akun') ?? session()->get('id_akun');

        $data = [
            'id_akun'       => $id_akun,
            'nama_tim'      => $this->request->getVar('nama_tim'),
            'asal_kota'     => $this->request->getVar('asal_kota'),
            'kontak_kapten' => $this->request->getVar('kontak_kapten'),
        ];
        
        $model->insert($data);
        
        // Update session id_tim jika yang mendaftar adalah Peserta itu sendiri
        if (session()->get('peran') === 'Peserta') {
            $id_tim = $model->insertID();
            session()->set('id_tim', $id_tim);
            return redirect()->to('tim/profil')->with('success', 'Tim berhasil dibuat.');
        }
        
        return redirect()->to('tim')->with('success', 'Tim berhasil dibuat.');
    }

    public function edit($id)
    {
        $model = new TimModel();
        $data['tim'] = $model->find($id);
        
        if ($data['tim']['id_akun'] != session()->get('id_akun') && session()->get('peran') != 'Admin') {
            return redirect()->to('dashboard')->with('error', 'Akses ditolak.');
        }

        $data['title'] = 'Edit Tim';
        if (session()->get('peran') === 'Admin') {
            $akunModel = new \App\Models\AkunModel();
            $data['akun_peserta'] = $akunModel->where('peran', 'Peserta')->findAll();
        }
        return view('tim/form', $data);
    }

    public function update($id)
    {
        $model = new TimModel();
        $data = [
            'nama_tim'      => $this->request->getVar('nama_tim'),
            'asal_kota'     => $this->request->getVar('asal_kota'),
            'kontak_kapten' => $this->request->getVar('kontak_kapten'),
        ];
        
        $model->update($id, $data);
        
        if (session()->get('peran') === 'Peserta') {
            return redirect()->to('tim/profil')->with('success', 'Tim berhasil diupdate.');
        }
        return redirect()->to('tim')->with('success', 'Tim berhasil diupdate.');
    }

    public function hapus($id)
    {
        $model = new TimModel();
        $model->delete($id);
        
        if (session()->get('peran') == 'Peserta') {
            session()->remove('id_tim');
            return redirect()->to('dashboard')->with('success', 'Tim berhasil dihapus.');
        }
        return redirect()->to('tim')->with('success', 'Tim berhasil dihapus.');
    }
}