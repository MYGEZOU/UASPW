<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 * ```
 *     class Home extends BaseController
 * ```
 *
 * For security, be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */

    protected $session;

    /**
     * Inisialisasi awal controller
     * 
     * Memanggil helper yang dibutuhkan, memuat sesi, dan membagikan data
     * user yang sedang login ke seluruh tampilan (view) secara global.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do NOT edit the next line...
        parent::initController($request, $response, $logger);

        // Load helpers
        helper(['url', 'form', 'session']);

        // Preload any models, libraries, etc, here.
        $this->session = session();
        
        // Simpan data user login (jika ada) ke variabel global untuk view
        if ($this->session->get('id_akun')) {
            $userData = [
                'id_akun' => $this->session->get('id_akun'),
                'username' => $this->session->get('username'),
                'nama_lengkap' => $this->session->get('nama_lengkap'),
                'peran' => $this->session->get('peran'),
                'id_tim' => $this->session->get('id_tim')
            ];
            // Bagikan ke semua view
            \Config\Services::renderer()->setData(['userData' => $userData]);
        }
    }


    /**
     * Sentralisasi logika upload file untuk menghindari perulangan (DRY)
     */
    protected function handleUpload($file, string $folder, $oldFileName = null, $defaultFileName = null)
    {
        $fileName = $defaultFileName;
        
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/' . $folder, $fileName);
            
            // Hapus file lama jika ada dan bukan default
            if ($oldFileName && $oldFileName !== $defaultFileName && file_exists(FCPATH . 'uploads/' . $folder . '/' . $oldFileName)) {
                unlink(FCPATH . 'uploads/' . $folder . '/' . $oldFileName);
            }
        } else if ($oldFileName) {
            $fileName = $oldFileName; // Pertahankan yang lama jika tidak ada upload baru
        }
        
        return $fileName;
    }

    /**
     * Sentralisasi logika validasi form
     */
    protected function validateInput(array $rules)
    {
        if (!$this->validate($rules)) {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return true; // Return true jika validasi gagal
        }
        return false; // Validasi sukses
    }
}
