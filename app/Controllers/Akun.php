<?php namespace App\Controllers;

use App\Models\AkunModel;

/**
 * Controller Akun
 * 
 * Mengelola data akun pengguna, termasuk proses CRUD (Create, Read, Update, Delete)
 * untuk pengguna (Admin, AdminGame, Peserta) serta pengelolaan profil mandiri.
 */
class Akun extends BaseController
{
    /**
     * Menampilkan daftar semua akun
     * 
     * Mengambil data dari AkunModel dan menampilkannya di halaman manajemen akun.
     */
    public function index()
    {
        $model = new AkunModel();
        $data['title'] = 'Manajemen Akun';
        $data['akun_list'] = $model->findAll();
        return view('akun/index', $data);
    }

    /**
     * Menampilkan form untuk menambah akun baru
     */
    public function tambah()
    {
        return view('akun/form', ['title' => 'Tambah Akun']);
    }


    /**
     * Menyimpan data akun baru ke database
     * 
     * Memvalidasi input (username, email, password, dll), melakukan hashing pada password,
     * lalu menyimpan data melalui AkunModel.
     */
    public function simpan()
    {
        $rules = [
            'username'     => 'required|min_length[3]|is_unique[akun.username]',
            'email'        => 'required|valid_email|is_unique[akun.email]',
            'password'     => 'required|min_length[6]',
            'nama_lengkap' => 'required',
            'peran'        => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $model = new AkunModel();
        // ⬇️ Ganti name_lengkap → nama_lengkap
        $data = [
            'username'      => $this->request->getVar('username'),
            'email'         => $this->request->getVar('email'),
            'password'      => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'nama_lengkap'  => $this->request->getVar('nama_lengkap'),   // ⬅️ perbaikan
            'peran'         => $this->request->getVar('peran'),         // pastikan nilai 'Perserta' dari form
            'tanggal_dibuat'=> date('Y-m-d H:i:s'),
        ];
        $model->save($data);
        return redirect()->to('akun');
    }

    /**
     * Menampilkan form edit untuk akun tertentu
     * 
     * @param int $id ID dari akun yang akan diedit
     */
    public function edit($id)
    {
        $model = new AkunModel();
        $data['title'] = 'Edit Akun';
        $data['akun'] = $model->find($id);
        return view('akun/form', $data);
    }

    /**
     * Memperbarui data akun di database
     * 
     * Melakukan validasi input. Jika password diisi, maka password akan di-hash dan diupdate,
     * jika tidak, hanya data lain yang diupdate.
     * 
     * @param int $id ID dari akun yang akan diperbarui
     */
    public function update($id)
    {
        $rules = [
            'username'     => "required|min_length[3]|is_unique[akun.username,id_akun,{$id}]",
            'email'        => "required|valid_email|is_unique[akun.email,id_akun,{$id}]",
            'nama_lengkap' => 'required',
            'peran'        => 'required'
        ];

        if ($this->request->getVar('password')) {
            $rules['password'] = 'min_length[6]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $model = new AkunModel();
        $data = [
            'username'      => $this->request->getVar('username'),
            'email'         => $this->request->getVar('email'),
            'nama_lengkap'  => $this->request->getVar('nama_lengkap'),
            'peran'         => $this->request->getVar('peran'),
        ];
        if ($this->request->getVar('password')) {
            $data['password'] = password_hash($this->request->getVar('password'), PASSWORD_DEFAULT);
        }
        $model->update($id, $data);
        return redirect()->to('akun');
    }

    /**
     * Menghapus akun dari database
     * 
     * @param int $id ID dari akun yang akan dihapus
     */
    public function hapus($id)
    {
        (new AkunModel())->delete($id);
        return redirect()->to('akun');
    }

    /**
     * Menampilkan halaman profil untuk user yang sedang login
     * 
     * Memeriksa session, mengambil data akun user yang aktif, dan menampilkan form edit profil.
     */
    public function profil()
    {
        $id_akun = session()->get('id_akun');
        if (!$id_akun) return redirect()->to('login');
        
        $model = new AkunModel();
        $data['akun']  = $model->find($id_akun);
        $data['title'] = 'Edit Profil';
        return view('akun/profil', $data);
    }

    /**
     * Memperbarui data profil mandiri user yang sedang login
     * 
     * Memvalidasi perubahan data diri, termasuk konfirmasi jika mengubah password,
     * dan merefresh data session 'nama_lengkap' setelah berhasil diubah.
     */
    public function updateProfil()
    {
        $id_akun = session()->get('id_akun');
        if (!$id_akun) return redirect()->to('login');

        $model = new AkunModel();
        $id = $id_akun;

        $rules = [
            'nama_lengkap' => 'required',
            'username'     => "required|min_length[3]|is_unique[akun.username,id_akun,{$id}]",
            'email'        => "required|valid_email|is_unique[akun.email,id_akun,{$id}]",
        ];

        $pass  = $this->request->getVar('password');
        $conf  = $this->request->getVar('password_confirm');

        if ($pass) {
            if ($pass !== $conf) {
                return redirect()->back()->withInput()->with('error', 'Konfirmasi password tidak cocok!');
            }
            $rules['password'] = 'min_length[6]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $update = [
            'nama_lengkap' => $this->request->getVar('nama_lengkap'),
            'username'     => $this->request->getVar('username'),
            'email'        => $this->request->getVar('email'),
        ];
        if ($pass) {
            $update['password'] = password_hash($pass, PASSWORD_DEFAULT);
        }

        $model->update($id, $update);

        // Refresh session nama_lengkap
        session()->set('nama_lengkap', $update['nama_lengkap']);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}