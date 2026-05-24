<?php

namespace App\Controllers;

use App\Models\DaftarModel;
use App\Models\TurnamenModel;

class Daftar extends BaseController
{
    public function index()
    {
        $model = new DaftarModel();
        
        $peran = session()->get('peran');
        if ($peran == 'Admin' || $peran == 'AdminGame') {
            $allPendaftaran = $model->getPendaftaranWithDetail();
            $data['pending_list'] = [];
            $data['lunas_list'] = [];
            
            foreach ($allPendaftaran as $p) {
                if ($p['status_pembayaran'] == 'Menunggu') {
                    $data['pending_list'][] = $p;
                } else {
                    $data['lunas_list'][] = $p;
                }
            }
            
            $data['title'] = 'Manajemen Pendaftaran';
            return view('daftar/index', $data);
        } else {
            return redirect()->to('dashboard')->with('error', 'Akses ditolak.');
        }
    }

    public function ikut($id_turnamen)
    {

        if (!session()->get('id_tim')) {
            return redirect()->to('tim/profil')->with('error', 'Anda harus memiliki tim untuk mendaftar turnamen.');
        }

        $turnamenModel = new TurnamenModel();
        $data['turnamen'] = $turnamenModel->find($id_turnamen);
        $data['title'] = 'Daftar Turnamen';
        return view('daftar/ikut', $data);
    }

    public function prosesIkut()
    {

        $model = new DaftarModel();
        $id_turnamen = $this->request->getVar('id_turnamen');
        $id_tim = session()->get('id_tim');

        // Cek apakah sudah daftar
        $existing = $model->where(['id_turnamen' => $id_turnamen, 'id_tim' => $id_tim])->first();
        if ($existing) {
            return redirect()->to('turnamen/peserta')->with('error', 'Tim Anda sudah mendaftar di turnamen ini.');
        }

        $data = [
            'id_turnamen'       => $id_turnamen,
            'id_tim'            => $id_tim,
            'tanggal_daftar'    => date('Y-m-d H:i:s'),
            'status_pembayaran' => 'Menunggu', // Default harus menunggu untuk upload bukti
        ];
        
        $model->insert($data);
        return redirect()->to('turnamen/peserta')->with('success', 'Berhasil mendaftar turnamen.');
    }

    public function ubahStatus($id_daftar)
    {

        $model = new DaftarModel();
        $daftar = $model->find($id_daftar);
        
        $status_baru = ($daftar['status_pembayaran'] == 'Menunggu') ? 'Lunas' : 'Menunggu';
        
        $model->update($id_daftar, ['status_pembayaran' => $status_baru]);
        return redirect()->to('daftar')->with('success', 'Status pembayaran berhasil diubah.');
    }

    public function hapus($id_daftar)
    {

        $model = new DaftarModel();
        $model->delete($id_daftar);
        
        return redirect()->to('daftar')->with('success', 'Pendaftaran berhasil dihapus.');
    }
}