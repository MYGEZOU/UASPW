<?php 
namespace App\Controllers;

use App\Models\AkunModel;
use App\Models\TimModel;
use App\Models\AnggotaModel;

/**
 * Controller Auth
 * 
 * Menangani proses otentikasi pengguna seperti login, registrasi, lupa password,
 * reset password, dan proses logout.
 */
class Auth extends BaseController
{
    /**
     * Menampilkan halaman login
     */
    public function login()
    {
        if (session()->get('id_akun')) {
            return redirect()->to(base_url('dashboard'));
        }
        return view('auth/login', ['title' => 'Login | E-Sports Tournament']);
    }

    /**
     * Menangani permintaan untuk menampilkan form registrasi.
     * 
     * Mengatur flash data untuk memunculkan panel registrasi di halaman yang sama,
     * lalu me-redirect kembali ke halaman login.
     */
    public function register()
    {
        if (session()->get('id_akun')) {
            return redirect()->to(base_url('dashboard'));
        }
        // Show the same unified page but flag to open register panel
        session()->setFlashdata('show_register', true);
        return redirect()->to(base_url('login'));
    }

    /**
     * Memproses percobaan login
     * 
     * Mengecek validitas username/email dan password, menginisialisasi sesi,
     * serta mengecek apakah user (Peserta) memiliki/tergabung dalam tim.
     */
    public function doLogin()
    {
        $model = new AkunModel();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $user = $model->groupStart()
                      ->where('username', $username)
                      ->orWhere('email', $username)
                      ->groupEnd()
                      ->first();

        // Cek user ada, lalu verifikasi password (dukung hash bcrypt dan md5)
        $isPasswordValid = false;
        if ($user) {
            if (password_verify($password, $user['password'])) {
                $isPasswordValid = true;
            } elseif (md5($password) === $user['password']) {
                $isPasswordValid = true;
                // Update ke bcrypt untuk keamanan ke depannya
                $model->update($user['id_akun'], ['password' => password_hash($password, PASSWORD_DEFAULT)]);
            }
        }

        if ($isPasswordValid) {
            $sessionData = [
                'id_akun'      => $user['id_akun'],
                'username'     => $user['username'],
                'nama_lengkap' => $user['nama_lengkap'] ?? $user['username'], 
                'peran'        => $user['peran'],
                'logged_in'    => true,
            ];

            // Cek apakah user adalah peserta dan sudah memiliki tim
            if ($user['peran'] == 'Peserta') {
                $timModel     = new TimModel();
                $anggotaModel = new AnggotaModel();
                
                // Cek 1: Apakah user ini kapten/pemilik tim?
                $tim = $timModel->getTimByAkun($user['id_akun']);
                if ($tim) {
                    $sessionData['id_tim'] = $tim['id_tim'];
                } else {
                    // Cek 2: Apakah user ini anggota dari tim lain?
                    $id_tim_anggota = $anggotaModel->getTimByAnggotaAkun($user['id_akun']);
                    $sessionData['id_tim'] = $id_tim_anggota; // null jika tidak ditemukan
                }
            } else {
                $sessionData['id_tim'] = null; // Bukan peserta
            }

            session()->set($sessionData);
            return redirect()->to(base_url('dashboard'));
        } else {
            session()->setFlashdata('error', 'Username/Email atau password salah!');
            return redirect()->to(base_url('login'));
        }
    }

    /**
     * Memproses registrasi akun baru (secara publik)
     * 
     * Validasi form, membuat username unik otomatis (dari nama depan + angka acak), 
     * melakukan hash pada password, dan menyimpan data akun dengan peran 'Peserta'.
     */
    public function doRegister()
    {
        $model = new AkunModel();
        $rules = [
            'nama_lengkap' => 'required|min_length[3]',
            'email'        => 'required|valid_email|is_unique[akun.email]',
            'password'     => 'required|min_length[6]',
            'konfirmasi_password' => 'matches[password]',
        ];
        if (!$this->validate($rules)) {
            session()->setFlashdata('error', implode('<br>', $this->validator->getErrors()));
            session()->setFlashdata('show_register', true);
            return redirect()->to(base_url('login'))->withInput();
        }

        $nama = $this->request->getVar('nama_lengkap');
        // Auto-generate username: first word of name + random suffix (ensures unique)
        $baseUsername = strtolower(preg_replace('/\s+/', '', explode(' ', trim($nama))[0]));
        $username = $baseUsername . rand(100, 9999);
        
        $data = [
            'username'      => $username,
            'email'         => $this->request->getVar('email'),
            'password'      => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'nama_lengkap'  => $nama,
            'peran'         => 'Peserta', // Selalu otomatis Peserta untuk pendaftaran publik
            'tanggal_dibuat'=> date('Y-m-d H:i:s'),
        ];
        $model->insert($data);
        session()->setFlashdata('success', 'Registrasi berhasil! Silakan login.');
        return redirect()->to(base_url('login'));
    }

    // ─────────────────────────────────────────────
    // LUPA PASSWORD
    // ─────────────────────────────────────────────

    /** Tampilkan form: masukkan email + username */
    public function forgotPassword()
    {
        if (session()->get('id_akun')) {
            return redirect()->to(base_url('dashboard'));
        }
        return view('auth/forgot_password');
    }

    /** Proses POST: cocokkan email + username */
    public function prosesForgotPassword()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'username' => 'required|min_length[3]',
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('error', implode(' ', $this->validator->getErrors()));
            return redirect()->to(base_url('lupa-password'));
        }

        $model    = new AkunModel();
        $email    = $this->request->getVar('email');
        $username = $this->request->getVar('username');

        $akun = $model->cekEmailDanUsername($email, $username);

        if (!$akun) {
            session()->setFlashdata('error', 'Email dan Username tidak sesuai. Silakan coba lagi.');
            return redirect()->to(base_url('lupa-password'));
        }

        // Simpan id_akun ke session sementara agar halaman reset terlindungi
        session()->set('reset_id_akun', $akun['id_akun']);
        session()->set('reset_allowed', true);

        session()->setFlashdata('success', 'Akun ditemukan! Silakan buat password baru.');
        return redirect()->to(base_url('reset-password'));
    }

    /** Tampilkan form reset password (hanya jika session reset_allowed aktif) */
    public function resetPassword()
    {
        if (!session()->get('reset_allowed')) {
            session()->setFlashdata('error', 'Akses tidak sah. Silakan mulai dari Lupa Password.');
            return redirect()->to(base_url('lupa-password'));
        }
        return view('auth/reset_password');
    }

    /** Proses POST: update password baru ke database */
    public function prosesResetPassword()
    {
        if (!session()->get('reset_allowed')) {
            return redirect()->to(base_url('lupa-password'));
        }

        $rules = [
            'password'         => 'required|min_length[6]',
            'konfirmasi_password' => 'matches[password]',
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('error', implode(' ', $this->validator->getErrors()));
            return redirect()->to(base_url('reset-password'));
        }

        $model   = new AkunModel();
        $id_akun = session()->get('reset_id_akun');

        $model->update($id_akun, [
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
        ]);

        // Hapus session sementara
        session()->remove('reset_allowed');
        session()->remove('reset_id_akun');

        session()->setFlashdata('success', 'Password berhasil diubah! Silakan login dengan password baru.');
        return redirect()->to(base_url('login'));
    }

    // ─────────────────────────────────────────────
    /**
     * Memproses logout
     * 
     * Menghancurkan seluruh data sesi dan mengarahkan kembali ke halaman login.
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}
