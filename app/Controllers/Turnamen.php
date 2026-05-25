<?php

namespace App\Controllers;

use App\Models\TurnamenModel;
use App\Models\DaftarModel;
use App\Models\TimModel;

/**
 * Controller Turnamen
 * 
 * Mengelola data Turnamen E-Sports, dari proses pembuatan, pengeditan, hapus,
 * hingga menampilkan turnamen tersedia untuk didaftar oleh peserta.
 */
class Turnamen extends BaseController
{
    /**
     * Menampilkan semua daftar turnamen (Admin/AdminGame)
     */
    public function index()
    {
        $peran = session()->get('peran');
        if (!in_array($peran, ['Admin', 'AdminGame'])) {
            return redirect()->to('dashboard')->with('error', 'Akses ditolak.');
        }
        
        $model = new TurnamenModel();
        // Join game table to get nama_game
        $data['turnamen'] = $model->select('turnamen.*, game.nama_game as game')
                                  ->join('game', 'game.id_game = turnamen.id_game', 'left')
                                  ->findAll();
        $data['title'] = 'Kelola Turnamen';
        return view('turnamen/index', $data);
    }
    
    /**
     * Menampilkan daftar turnamen untuk dashboard Peserta
     * 
     * Menampilkan status pendaftaran tim peserta ke berbagai turnamen.
     */
    public function peserta()
    {

        $model = new TurnamenModel();
        $daftarModel = new DaftarModel();
        $id_tim = session()->get('id_tim');
        
        $data['turnamen'] = $model->select('turnamen.*, game.nama_game as game')
                                  ->join('game', 'game.id_game = turnamen.id_game', 'left')
                                  ->where('status !=', 'Selesai')
                                  ->findAll();
        $data['title'] = 'Turnamen Tersedia';
        $data['pendaftaran_saya'] = [];
        if ($id_tim) {
            $pendaftaran = $daftarModel->where('id_tim', $id_tim)->findAll();
            foreach ($pendaftaran as $p) {
                $data['pendaftaran_saya'][] = $p['id_turnamen'];
            }
        }
        return view('turnamen/peserta', $data);
    }

    /**
     * Menampilkan form pembuatan turnamen baru (Admin/AdminGame)
     */
    public function tambah()
    {

        $gameModel = new \App\Models\GameModel();
        $data['games'] = $gameModel->findAll();
        $data['title'] = 'Tambah Turnamen';
        return view('turnamen/form', $data);
    }

    /**
     * Menyimpan data turnamen baru berserta banner
     * 
     * Menangani proses upload banner dan memasukkan data turnamen ke database.
     */
    public function simpan()
    {

        $bannerName = $this->handleUpload($this->request->getFile('banner'), 'turnamen', null, 'default_banner.jpg');
        
        $model = new TurnamenModel();
        $data = [
            'nama_turnamen'     => $this->request->getVar('nama_turnamen'),
            'id_game'           => $this->request->getVar('id_game'),
            'tanggal_mulai'     => $this->request->getVar('tanggal_mulai'),
            'biaya_pendaftaran' => $this->request->getVar('biaya_pendaftaran'),
            'status'            => $this->request->getVar('status'),
            'banner'            => $bannerName
        ];
        
        $model->insert($data);
        return redirect()->to('turnamen')->with('success', 'Turnamen berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit turnamen (Admin/AdminGame)
     * 
     * @param int $id ID turnamen
     */
    public function edit($id)
    {

        $model = new TurnamenModel();
        $gameModel = new \App\Models\GameModel();
        $data['turnamen'] = $model->find($id);
        $data['games'] = $gameModel->findAll();
        $data['title'] = 'Edit Turnamen';
        return view('turnamen/form', $data);
    }

    /**
     * Memperbarui data turnamen
     * 
     * Menangani perubahan data termasuk jika ada upload banner baru.
     * 
     * @param int $id ID turnamen
     */
    public function update($id)
    {

        $model = new TurnamenModel();
        $turnamen = $model->find($id);
        
        $data = [
            'nama_turnamen'     => $this->request->getVar('nama_turnamen'),
            'id_game'           => $this->request->getVar('id_game'),
            'tanggal_mulai'     => $this->request->getVar('tanggal_mulai'),
            'biaya_pendaftaran' => $this->request->getVar('biaya_pendaftaran'),
            'status'            => $this->request->getVar('status'),
        ];
        
        $data['banner'] = $this->handleUpload($this->request->getFile('banner'), 'turnamen', $turnamen['banner'], 'default_banner.jpg');
        
        $model->update($id, $data);
        return redirect()->to('turnamen')->with('success', 'Turnamen berhasil diupdate.');
    }

    /**
     * Menghapus data turnamen
     * 
     * @param int $id ID turnamen
     */
    public function hapus($id)
    {

        $model = new TurnamenModel();
        $model->delete($id);
        return redirect()->to('turnamen')->with('success', 'Turnamen berhasil dihapus.');
    }

    /**
     * Menampilkan daftar turnamen yang masih berstatus 'Pendaftaran' untuk publik/peserta
     * 
     * Melakukan pengecekan status kapten tim dan riwayat pendaftaran.
     */
    public function daftarTersedia()
    {

        $model       = new TurnamenModel();
        $daftarModel = new DaftarModel();
        $timModel    = new TimModel();
        $id_akun     = session()->get('id_akun');
        $id_tim      = session()->get('id_tim');
        
        // Tentukan apakah user ini kapten tim
        $is_kapten = false;
        if ($id_tim) {
            $tim = $timModel->find($id_tim);
            $is_kapten = $tim && ($tim['id_akun'] == $id_akun);
        }

        // Semua peserta (kapten maupun anggota) bisa melihat daftar
        $data['turnamen'] = $model->select('turnamen.*, game.nama_game as game')
                                  ->join('game', 'game.id_game = turnamen.id_game', 'left')
                                  ->where('status', 'Pendaftaran')
                                  ->findAll();
        
        $data['title']     = 'Daftar Turnamen Tersedia';
        $data['is_kapten'] = $is_kapten;
        
        // Ambil status pendaftaran tim (hanya relevan untuk kapten)
        $data['pendaftaran_saya'] = [];
        if ($id_tim) {
            $pendaftaran = $daftarModel->where('id_tim', $id_tim)->findAll();
            foreach ($pendaftaran as $p) {
                $data['pendaftaran_saya'][$p['id_turnamen']] = $p;
            }
        }
        
        return view('turnamen/daftar_tersedia', $data);
    }

    /**
     * Memproses pendaftaran tim yang dilakukan oleh kapten ke sebuah turnamen
     * 
     * Mengecek validitas turnamen, memastikan tim belum terdaftar, lalu
     * menyimpan pendaftaran dan mengarahkan ke form pembayaran.
     * 
     * @param int $id_turnamen ID turnamen yang dipilih
     */
    public function daftarTurnamen($id_turnamen)
    {

        $id_akun  = session()->get('id_akun');
        $id_tim   = session()->get('id_tim');
        $timModel = new TimModel();
        
        if (!$id_tim) {
            return redirect()->to('tim/profil')->with('error', 'Anda harus memiliki tim untuk mendaftar turnamen.');
        }
        
        // Hanya kapten yang boleh mendaftarkan tim
        $tim = $timModel->find($id_tim);
        if (!$tim || $tim['id_akun'] != $id_akun) {
            return redirect()->to('turnamen/daftar-tersedia')
                             ->with('error', 'Hanya kapten tim yang dapat mendaftarkan tim ke turnamen. Hubungi kapten Anda.');
        }

        $model = new DaftarModel();

        // Cek apakah turnamen valid dan statusnya masih 'Pendaftaran'
        $turnamenModel = new TurnamenModel();
        $turnamen = $turnamenModel->find($id_turnamen);
        if (!$turnamen || $turnamen['status'] !== 'Pendaftaran') {
            return redirect()->to('turnamen/daftar-tersedia')->with('error', 'Turnamen tidak tersedia untuk didaftar.');
        }

        // Cek apakah sudah mendaftar
        $existing = $model->where(['id_turnamen' => $id_turnamen, 'id_tim' => $id_tim])->first();
        if ($existing) {
            return redirect()->to('turnamen/daftar-tersedia')->with('error', 'Tim Anda sudah mendaftar di turnamen ini.');
        }

        $data = [
            'id_turnamen'       => $id_turnamen,
            'id_tim'            => $id_tim,
            'tanggal_daftar'    => date('Y-m-d H:i:s'),
            'status_pembayaran' => 'Menunggu',
        ];
        
        if ($model->insert($data)) {
            $id_daftar = $model->getInsertID();
            return redirect()->to("pembayaran/upload/{$id_daftar}")->with('success', 'Berhasil mendaftar! Silakan upload bukti pembayaran.');
        }
        
        return redirect()->to('turnamen/daftar-tersedia')->with('error', 'Gagal mendaftar turnamen.');
    }
}