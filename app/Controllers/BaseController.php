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
     * Periksa peran user. Jika tidak sesuai, langsung redirect dan stop eksekusi.
     * Catatan: Di CI4, return dari helper method tidak menghentikan controller.
     * Gunakan pola: if ($this->checkRole('Admin')) return;
     *
     * @return bool true jika akses ditolak (gunakan: if ($this->denyRole('Admin')) return;)
     */
    protected function checkRole($requiredRoles): bool
    {
        if (!session()->get('id_akun')) {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu.');
            header('Location: ' . base_url('login'));
            exit;
        }

        $roles = is_array($requiredRoles) ? $requiredRoles : explode(',', $requiredRoles);

        if (!in_array(session()->get('peran'), $roles)) {
            session()->setFlashdata('error', 'Akses ditolak.');
            header('Location: ' . base_url('dashboard'));
            exit;
        }

        return false;
    }
}
