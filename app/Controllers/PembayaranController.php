<?php

namespace App\Controllers;

use App\Models\DaftarModel;
use App\Models\TurnamenModel;

/**
 * Controller PembayaranController
 * 
 * Mengelola proses pembayaran dan konfirmasi pendaftaran turnamen oleh tim/peserta
 * maupun Admin.
 */
class PembayaranController extends BaseController
{
    /**
     * Menampilkan riwayat pendaftaran dan pembayaran (Peserta)
     */
    public function indexPeserta()
    {

        $model = new DaftarModel();
        $id_tim = session()->get('id_tim');
        
        if (!$id_tim) {
            return redirect()->to('tim/profil')->with('error', 'Anda belum memiliki tim.');
        }

        $data['pendaftaran'] = $model->getPendaftaranByTim($id_tim);
        $data['title'] = 'Pendaftaran & Pembayaran';
        
        return view('daftar/peserta_index', $data);
    }

    /**
     * Menampilkan form untuk mengupload bukti pembayaran
     * 
     * @param int $id_daftar ID pendaftaran
     */
    public function formUpload($id_daftar)
    {

        $model = new DaftarModel();
        $id_tim = session()->get('id_tim');
        
        $daftar = $model->find($id_daftar);
        
        if (!$daftar || $daftar['id_tim'] != $id_tim) {
            return redirect()->to('pembayaran/saya')->with('error', 'Data pendaftaran tidak ditemukan atau tidak berhak mengakses.');
        }
        
        // Cek jika sudah lunas tidak perlu upload
        if ($daftar['status_pembayaran'] === 'Lunas') {
            return redirect()->to('pembayaran/saya')->with('info', 'Pendaftaran ini sudah lunas.');
        }

        $turnamenModel = new TurnamenModel();
        $data['turnamen'] = $turnamenModel->select('turnamen.*, game.nama_game')
                                          ->join('game', 'game.id_game = turnamen.id_game', 'left')
                                          ->find($daftar['id_turnamen']);
        $data['daftar'] = $daftar;
        $data['title'] = 'Upload Bukti Pembayaran';
        
        return view('daftar/upload_bukti', $data);
    }

    /**
     * Memproses upload file bukti pembayaran (Peserta)
     * 
     * Memvalidasi file gambar/pdf, menyimpannya di server, dan mengupdate field 
     * bukti_pembayaran di tabel pendaftaran.
     * 
     * @param int $id_daftar ID pendaftaran
     */
    public function uploadBukti($id_daftar)
    {

        $model = new DaftarModel();
        $id_tim = session()->get('id_tim');
        
        $daftar = $model->find($id_daftar);
        if (!$daftar || $daftar['id_tim'] != $id_tim) {
            return redirect()->to('pembayaran/saya')->with('error', 'Data pendaftaran tidak valid.');
        }

        $validationRule = [
            'bukti_pembayaran' => [
                'label' => 'Bukti Pembayaran',
                'rules' => 'uploaded[bukti_pembayaran]|is_image[bukti_pembayaran]|mime_in[bukti_pembayaran,image/jpg,image/jpeg,image/png,application/pdf]|max_size[bukti_pembayaran,2048]'
            ]
        ];

        if ($this->validateInput($validationRule)) {
            return redirect()->back()->withInput();
        }

        $newName = $this->handleUpload($this->request->getFile('bukti_pembayaran'), 'bukti_pembayaran');

        // Hapus bukti lama jika ada
        if (!empty($daftar['bukti_pembayaran']) && file_exists(FCPATH . 'uploads/bukti_pembayaran/' . $daftar['bukti_pembayaran'])) {
            unlink(FCPATH . 'uploads/bukti_pembayaran/' . $daftar['bukti_pembayaran']);
        }

        $model->update($id_daftar, [
            'bukti_pembayaran' => $newName
        ]);

        return redirect()->to('pembayaran/saya')->with('success', 'Bukti pembayaran berhasil diupload. Harap tunggu konfirmasi.');
    }

    /**
     * Menampilkan daftar pembayaran yang masih 'Menunggu' konfirmasi (Admin/AdminGame)
     */
    public function daftarMenunggu()
    {
        $peran = session()->get('peran');
        if (!in_array($peran, ['Admin', 'AdminGame'])) {
            return redirect()->to('dashboard')->with('error', 'Akses ditolak.');
        }
        
        $model = new DaftarModel();
        $all = $model->getPendaftaranWithDetail();
        $data['menunggu'] = array_filter($all, function($p) {
            return $p['status_pembayaran'] === 'Menunggu';
        });
        
        $data['title'] = 'Menunggu Konfirmasi Pembayaran';
        return view('daftar/admin_menunggu', $data);
    }

    /**
     * Mengonfirmasi pembayaran menjadi 'Lunas' (Admin/AdminGame)
     * 
     * Mengupdate status pembayaran serta mencatat tanggal dan siapa admin yang mengkonfirmasi.
     * 
     * @param int $id_daftar ID pendaftaran
     */
    public function konfirmasi($id_daftar)
    {
        $peran = session()->get('peran');
        if (!in_array($peran, ['Admin', 'AdminGame'])) {
            return redirect()->to('dashboard')->with('error', 'Akses ditolak.');
        }

        $model = new DaftarModel();
        $daftar = $model->find($id_daftar);
        
        if (!$daftar) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        $model->update($id_daftar, [
            'status_pembayaran' => 'Lunas',
            'tanggal_konfirmasi' => date('Y-m-d H:i:s'),
            'id_akun_konfirmasi' => session()->get('id_akun')
        ]);

        return redirect()->back()->with('success', 'Pembayaran berhasil dikonfirmasi (Lunas).');
    }

    /**
     * Menampilkan riwayat pendaftaran yang sudah 'Lunas' (Admin/AdminGame)
     */
    public function daftarRiwayat()
    {
        $peran = session()->get('peran');
        if (!in_array($peran, ['Admin', 'AdminGame'])) {
            return redirect()->to('dashboard')->with('error', 'Akses ditolak.');
        }
        
        $model = new DaftarModel();
        $all = $model->getPendaftaranWithDetail();
        $data['riwayat'] = array_filter($all, function($p) {
            return $p['status_pembayaran'] === 'Lunas';
        });
        
        $data['title'] = 'Riwayat Pendaftaran (Lunas)';
        return view('daftar/admin_riwayat', $data);
    }
}
