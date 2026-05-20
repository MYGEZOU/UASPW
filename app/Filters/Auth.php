<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Auth implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response so that any information
     * can be shown using its view.
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! session('id_akun')) {  // Direct helper OK in filter
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu!');
            return redirect()->to('/login');
        }
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow for the
     * response to be replaced with a new one.
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
