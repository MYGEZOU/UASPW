<?php

namespace App\Controllers;

use App\Models\AnggotaModel;
use App\Models\TimModel;

/**
 * Controller Anggota
 * 
 * Mengelola data anggota tim. Controller ini menangani proses untuk manajemen anggota 
 * baik oleh Admin maupun oleh Kapten Tim (Peserta).
 */
class Anggota extends BaseController
{
    /**
     * Menampilkan daftar semua anggota
     * 
     * Mengambil seluruh data anggota berserta tim mereka untuk ditampilkan (biasanya untuk Admin).
     */
    public function index()
    {

        $model = new AnggotaModel();
        $data['anggota'] = $model->getAnggotaWithTim();
        $data['title'] = 'Manajemen Anggota';
        return view('anggota/index', $data);
    }

    /**
     * Menampilkan form tambah anggota (Admin)
     */
    public function tambah()
    {

        $timModel = new TimModel();
        $data['tim_list'] = $timModel->findAll();
        $data['title'] = 'Tambah Anggota';
        return view('anggota/form', $data);
    }

    // -------------------------------------------------------
    // AKSES PESERTA: tambah anggota ke tim sendiri
    // -------------------------------------------------------
    /**
     * Menampilkan form untuk menambahkan anggota tim oleh Peserta (Kapten Tim)
     * 
     * Menyiapkan daftar akun peserta yang belum menjadi anggota di tim manapun
     * dan tidak menjadi kapten di tim lain.
     */
    public function tambahPeserta()
    {
        $id_tim = session()->get('id_tim');
        if (!$id_tim) {
            return redirect()->to('tim/tambah')->with('error', 'Buat tim terlebih dahulu sebelum menambah anggota.');
        }

        // Daftar akun Peserta yang belum menjadi anggota manapun (id_akun tidak ada di anggota)
        $akunModel    = new \App\Models\AkunModel();
        $anggotaModel = new AnggotaModel();
        $semuaPeserta = $akunModel->where('peran', 'Peserta')->findAll();
        
        // Kecualikan akun yang sudah jadi kapten tim ini
        $timModel  = new TimModel();
        $kaptenTim = $timModel->find($id_tim);
        
        // Kecualikan yang sudah terdaftar sebagai anggota
        $sudahAnggota = array_column($anggotaModel->where('id_tim', $id_tim)->findAll(), 'id_akun');
        
        $data['peserta_list'] = array_filter($semuaPeserta, function($p) use ($sudahAnggota, $kaptenTim) {
            return !in_array($p['id_akun'], $sudahAnggota)
                && $p['id_akun'] != ($kaptenTim['id_akun'] ?? 0);
        });

        $data['title']  = 'Tambah Anggota Tim';
        $data['id_tim'] = $id_tim;
        return view('anggota/form_peserta', $data);
    }

    /**
     * Menyimpan data anggota baru ke dalam tim (oleh Kapten Tim)
     * 
     * Memvalidasi input dan memasukkan anggota baru ke dalam tim milik user yang login.
     */
    public function simpanPeserta()
    {
        $id_tim = session()->get('id_tim');
        if (!$id_tim) {
            return redirect()->to('tim/tambah')->with('error', 'Buat tim terlebih dahulu.');
        }

        $rules = [
            'nickname' => 'required|is_unique[anggota.nickname]',
            'peran'    => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $model = new AnggotaModel();
        $id_akun_anggota = $this->request->getVar('id_akun_anggota') ?: null;
        $data = [
            'id_tim'         => $id_tim,
            'id_akun'        => $id_akun_anggota,
            'nickname'       => $this->request->getVar('nickname'),
            'peran'          => $this->request->getVar('peran'),
            'peringkat_game' => $this->request->getVar('peringkat_game'),
        ];

        $model->insert($data);
        return redirect()->to('tim/profil')->with('success', 'Anggota berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit anggota (oleh Kapten Tim)
     * 
     * @param int $id ID anggota yang akan diedit
     */
    public function editPeserta($id)
    {
        $id_tim = session()->get('id_tim');
        if (!$id_tim) {
            return redirect()->to('tim/profil')->with('error', 'Tim tidak ditemukan.');
        }

        $model = new AnggotaModel();
        $anggota = $model->find($id);

        if (!$anggota || $anggota['id_tim'] != $id_tim) {
            return redirect()->to('tim/profil')->with('error', 'Anggota tidak ditemukan atau tidak berhak mengedit.');
        }

        $data['title'] = 'Edit Anggota Tim';
        $data['anggota'] = $anggota;
        return view('anggota/form_peserta', $data);
    }

    /**
     * Memperbarui data anggota tim (oleh Kapten Tim)
     * 
     * @param int $id ID anggota yang akan diupdate
     */
    public function updatePeserta($id)
    {
        $id_tim = session()->get('id_tim');
        if (!$id_tim) {
            return redirect()->to('tim/profil')->with('error', 'Tim tidak ditemukan.');
        }

        $model = new AnggotaModel();
        $anggota = $model->find($id);

        if (!$anggota || $anggota['id_tim'] != $id_tim) {
            return redirect()->to('tim/profil')->with('error', 'Akses ditolak.');
        }

        $rules = [
            'nickname' => "required|is_unique[anggota.nickname,id_anggota,{$id}]",
            'peran'    => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $data = [
            'nickname'       => $this->request->getVar('nickname'),
            'peran'          => $this->request->getVar('peran'),
            'peringkat_game' => $this->request->getVar('peringkat_game'),
        ];

        $model->update($id, $data);
        return redirect()->to('tim/profil')->with('success', 'Anggota berhasil diupdate.');
    }

    /**
     * Menghapus anggota dari tim (oleh Kapten Tim)
     * 
     * @param int $id ID anggota yang akan dihapus
     */
    public function hapusPeserta($id)
    {
        $id_tim = session()->get('id_tim');
        if (!$id_tim) {
            return redirect()->to('tim/profil')->with('error', 'Tim tidak ditemukan.');
        }

        $model = new AnggotaModel();
        $anggota = $model->find($id);

        if (!$anggota || $anggota['id_tim'] != $id_tim) {
            return redirect()->to('tim/profil')->with('error', 'Akses ditolak.');
        }

        $model->delete($id);
        return redirect()->to('tim/profil')->with('success', 'Anggota berhasil dihapus.');
    }

    /**
     * Menghubungkan anggota (yang sebelumnya belum memiliki akun) dengan akun terdaftar
     * 
     * Memastikan akun yang dipilih valid dan belum tergabung di tim manapun.
     * 
     * @param int $id_anggota ID anggota yang ingin dihubungkan
     */
    public function linkAkun($id_anggota)
    {
        $id_tim = session()->get('id_tim');
        if (!$id_tim) {
            return redirect()->to('tim/profil')->with('error', 'Tim tidak ditemukan.');
        }

        $model   = new AnggotaModel();
        $anggota = $model->find($id_anggota);

        if (!$anggota || $anggota['id_tim'] != $id_tim) {
            return redirect()->to('tim/profil')->with('error', 'Akses ditolak.');
        }

        $id_akun = (int) $this->request->getVar('id_akun');
        if (!$id_akun) {
            return redirect()->to('tim/profil')->with('error', 'Pilih akun yang ingin dihubungkan.');
        }

        // Pastikan id_akun belum terhubung ke anggota lain
        $cek = $model->where('id_akun', $id_akun)->first();
        if ($cek) {
            return redirect()->to('tim/profil')->with('error', 'Akun ini sudah terhubung ke anggota lain.');
        }

        // Pastikan id_akun bukan kapten dari tim mana pun
        $timModel = new \App\Models\TimModel();
        if ($timModel->where('id_akun', $id_akun)->first()) {
            return redirect()->to('tim/profil')->with('error', 'Akun ini adalah kapten tim dan tidak bisa dijadikan anggota.');
        }

        $model->update($id_anggota, ['id_akun' => $id_akun]);
        
        // Verifikasi update
        $updated = $model->find($id_anggota);
        if ($updated['id_akun'] != $id_akun) {
            return redirect()->to('tim/profil')->with('error', 'Gagal menghubungkan akun. Terjadi kesalahan sistem.');
        }

        return redirect()->to('tim/profil')->with('success', 'Akun berhasil dihubungkan! Anggota kini dapat login dan melihat tim ini.');
    }

    /**
     * Menyimpan data anggota baru (Admin)
     */
    public function simpan()
    {

        $rules = [
            'id_tim'   => 'required',
            'nickname' => 'required|is_unique[anggota.nickname]',
            'peran'    => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $model = new AnggotaModel();
        $data = [
            'id_tim'         => $this->request->getVar('id_tim'),
            'nickname'       => $this->request->getVar('nickname'),
            'peran'          => $this->request->getVar('peran'),
            'peringkat_game' => $this->request->getVar('peringkat_game'),
        ];
        $model->insert($data);
        
        $redirectUrl = $this->request->getVar('redirect') ?? 'anggota';
        return redirect()->to($redirectUrl)->with('success', 'Anggota berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit anggota (Admin)
     * 
     * @param int $id ID anggota
     */
    public function edit($id)
    {

        $model = new AnggotaModel();
        $timModel = new TimModel();
        
        $data['anggota'] = $model->find($id);
        $data['tim_list'] = $timModel->findAll();
        $data['title'] = 'Edit Anggota';
        return view('anggota/form', $data);
    }

    /**
     * Memperbarui data anggota (Admin)
     * 
     * @param int $id ID anggota
     */
    public function update($id)
    {

        $rules = [
            'id_tim'   => 'required',
            'nickname' => "required|is_unique[anggota.nickname,id_anggota,{$id}]",
            'peran'    => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $model = new AnggotaModel();
        $data = [
            'id_tim'         => $this->request->getVar('id_tim'),
            'nickname'       => $this->request->getVar('nickname'),
            'peran'          => $this->request->getVar('peran'),
            'peringkat_game' => $this->request->getVar('peringkat_game'),
        ];
        
        $model->update($id, $data);
        
        $redirectUrl = $this->request->getVar('redirect') ?? 'anggota';
        return redirect()->to($redirectUrl)->with('success', 'Anggota berhasil diupdate.');
    }

    /**
     * Menghapus anggota (Admin)
     * 
     * @param int $id ID anggota
     */
    public function hapus($id)
    {

        $model = new AnggotaModel();
        $model->delete($id);
        
        $redirectUrl = $this->request->getVar('redirect') ?? 'anggota';
        return redirect()->to($redirectUrl)->with('success', 'Anggota berhasil dihapus.');
    }
}