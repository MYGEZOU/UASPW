<?php

namespace App\Controllers;

use App\Models\JadwalModel;
use App\Models\TurnamenModel;
use App\Models\TimModel;

/**
 * Controller Jadwal
 * 
 * Mengelola jadwal pertandingan turnamen, termasuk pembuatan jadwal oleh 
 * Admin/AdminGame dan melihat jadwal oleh Peserta.
 */
class Jadwal extends BaseController
{
    /**
     * Menampilkan seluruh jadwal pertandingan (Admin/AdminGame)
     * 
     * Jika diakses oleh Peserta, akan diredirect ke jadwal spesifik mereka.
     */
    public function index()
    {
        $peran = session()->get('peran');
        if ($peran === 'Peserta') {
            return redirect()->to('jadwal/saya');
        }
        if (!in_array($peran, ['Admin', 'AdminGame'])) {
            return redirect()->to('dashboard')->with('error', 'Akses ditolak.');
        }

        $model = new JadwalModel();
        $data['jadwal'] = $model->getJadwalWithDetail();
        $data['title'] = 'Jadwal Pertandingan';
        return view('jadwal/index', $data);
    }
    
    /**
     * Menampilkan jadwal pertandingan spesifik untuk tim user (Peserta) yang login
     */
    public function mySchedule()
    {

        $model = new JadwalModel();
        $id_tim = session()->get('id_tim');
        
        if ($id_tim) {
            $data['jadwal'] = $model->getJadwalByTim($id_tim);
        } else {
            $data['jadwal'] = [];
        }
        
        $data['title'] = 'Jadwal Tim Saya';
        return view('jadwal/peserta', $data);
    }

    /**
     * Menampilkan form untuk membuat jadwal pertandingan baru (Admin/AdminGame)
     * 
     * Memuat daftar turnamen (yang sedang pendaftaran atau berlangsung) dan daftar tim.
     */
    public function create()
    {
        $peran = session()->get('peran');
        if ($peran === 'Peserta') {
            return redirect()->to('jadwal/saya');
        }
        if (!in_array($peran, ['Admin', 'AdminGame'])) {
            return redirect()->to('dashboard')->with('error', 'Akses ditolak.');
        }

        $turnamenModel = new TurnamenModel();
        $timModel = new TimModel();
        
        // Hanya status Pendaftaran atau Berlangsung, join dengan game untuk mendapat nama_game
        $data['turnamen'] = $turnamenModel->select('turnamen.*, game.nama_game as game_nama')
                                          ->join('game', 'game.id_game = turnamen.id_game', 'left')
                                          ->whereIn('status', ['Pendaftaran', 'Berlangsung'])
                                          ->findAll();
        $data['tim'] = $timModel->findAll();
        $data['title'] = 'Tambah Jadwal';
        return view('jadwal/form', $data);
    }

    /**
     * Menyimpan jadwal pertandingan baru
     * 
     * Menyimpan data dari form tambah jadwal (turnamen, tim 1, tim 2, tanggal, babak).
     */
    public function store()
    {
        $peran = session()->get('peran');
        if ($peran === 'Peserta') {
            return redirect()->to('jadwal/saya');
        }
        if (!in_array($peran, ['Admin', 'AdminGame'])) {
            return redirect()->to('dashboard')->with('error', 'Akses ditolak.');
        }

        $model = new JadwalModel();
        $data = [
            'id_turnamen'    => $this->request->getVar('id_turnamen'),
            'id_tim_1'       => $this->request->getVar('id_tim_1'),
            'id_tim_2'       => $this->request->getVar('id_tim_2'),
            'jadwal_tanding' => $this->request->getVar('jadwal_tanding'),
            'babak'          => $this->request->getVar('babak'),
        ];
        
        if (!$model->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }
        
        return redirect()->to('jadwal')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit jadwal
     * 
     * @param int $id ID jadwal
     */
    public function edit($id)
    {
        $peran = session()->get('peran');
        if ($peran === 'Peserta') {
            return redirect()->to('jadwal/saya');
        }
        if (!in_array($peran, ['Admin', 'AdminGame'])) {
            return redirect()->to('dashboard')->with('error', 'Akses ditolak.');
        }

        $model = new JadwalModel();
        $turnamenModel = new TurnamenModel();
        $timModel = new TimModel();
        
        $data['jadwal'] = $model->find($id);
        
        if (!$data['jadwal']) {
            return redirect()->to('jadwal')->with('error', 'Jadwal tidak ditemukan.');
        }

        // Tampilkan semua turnamen untuk form edit (termasuk yang selesai barangkali data lama)
        // tapi sebaiknya Pendaftaran & Berlangsung saja, atau yang sesuai id_turnamen lama
        $data['turnamen'] = $turnamenModel->select('turnamen.*, game.nama_game as game_nama')
                                          ->join('game', 'game.id_game = turnamen.id_game', 'left')
                                          ->groupStart()
                                              ->whereIn('status', ['Pendaftaran', 'Berlangsung'])
                                              ->orWhere('id_turnamen', $data['jadwal']['id_turnamen'])
                                          ->groupEnd()
                                          ->findAll();
        $data['tim'] = $timModel->findAll();
        $data['title'] = 'Edit Jadwal';
        return view('jadwal/form', $data);
    }

    /**
     * Menyimpan pembaruan data jadwal
     * 
     * @param int $id ID jadwal
     */
    public function update($id)
    {
        $peran = session()->get('peran');
        if ($peran === 'Peserta') {
            return redirect()->to('jadwal/saya');
        }
        if (!in_array($peran, ['Admin', 'AdminGame'])) {
            return redirect()->to('dashboard')->with('error', 'Akses ditolak.');
        }

        $model = new JadwalModel();
        
        $jadwal = $model->find($id);
        if (!$jadwal) {
            return redirect()->to('jadwal')->with('error', 'Jadwal tidak ditemukan.');
        }

        $data = [
            'id_turnamen'    => $this->request->getVar('id_turnamen'),
            'id_tim_1'       => $this->request->getVar('id_tim_1'),
            'id_tim_2'       => $this->request->getVar('id_tim_2'),
            'jadwal_tanding' => $this->request->getVar('jadwal_tanding'),
            'babak'          => $this->request->getVar('babak'),
        ];
        
        if (!$model->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }
        
        return redirect()->to('jadwal')->with('success', 'Jadwal berhasil diupdate.');
    }

    /**
     * Menghapus jadwal pertandingan
     * 
     * @param int $id ID jadwal
     */
    public function delete($id)
    {
        $peran = session()->get('peran');
        if ($peran === 'Peserta') {
            return redirect()->to('jadwal/saya');
        }
        if (!in_array($peran, ['Admin', 'AdminGame'])) {
            return redirect()->to('dashboard')->with('error', 'Akses ditolak.');
        }

        $model = new JadwalModel();
        $model->delete($id);
        return redirect()->to('jadwal')->with('success', 'Jadwal berhasil dihapus.');
    }
}