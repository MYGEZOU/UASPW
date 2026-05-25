<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Controller GameController
 * 
 * Mengelola master data Game (nama, deskripsi, logo) yang akan dipertandingkan
 * dalam turnamen-turnamen e-sports.
 */
class GameController extends BaseController
{
    protected $gameModel;

    public function __construct()
    {
        $this->gameModel = new \App\Models\GameModel();
    }

    public function __construct()
    {
        $this->gameModel = new \App\Models\GameModel();
    }

    /**
     * Menampilkan daftar semua game
     */
    public function index()
    {
        $data = [
            'title' => 'Master Game',
            'games' => $this->gameModel->findAll()
        ];
        return view('game/index', $data);
    }

    /**
     * Menampilkan form untuk menambah game baru
     */
    public function create()
    {
        $data = [
            'title' => 'Tambah Game'
        ];
        return view('game/form', $data);
    }

    /**
     * Menyimpan data game baru ke database
     * 
     * Memvalidasi input (nama unik, format logo), menangani upload file logo, 
     * dan menyimpannya.
     */
    public function store()
    {
        $rules = [
            'nama_game' => 'required|min_length[3]|is_unique[game.nama_game]',
            'logo'      => 'max_size[logo,2048]|is_image[logo]|mime_in[logo,image/jpg,image/jpeg,image/png,image/webp]'
        ];

        if ($this->validateInput($rules)) {
            return redirect()->back()->withInput();
        }

        $logoName = $this->handleUpload($this->request->getFile('logo'), 'game');

        $this->gameModel->save([
            'nama_game' => $this->request->getVar('nama_game'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'logo'      => $logoName
        ]);

        return redirect()->to('game')->with('success', 'Game berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit game
     * 
     * @param int $id ID game yang akan diedit
     */
    public function edit($id)
    {
        $data = [
            'title' => 'Edit Game',
            'game'  => $this->gameModel->find($id)
        ];

        if (!$data['game']) {
            return redirect()->to('game')->with('error', 'Game tidak ditemukan.');
        }

        return view('game/form', $data);
    }

    /**
     * Memperbarui data game
     * 
     * Memvalidasi input dan menangani proses upload logo baru (jika ada) untuk menimpa yang lama.
     * 
     * @param int $id ID game
     */
    public function update($id)
    {
        $game = $this->gameModel->find($id);
        if (!$game) {
            return redirect()->to('game')->with('error', 'Game tidak ditemukan.');
        }

        $rules = [
            'nama_game' => "required|min_length[3]|is_unique[game.nama_game,id_game,{$id}]",
            'logo'      => 'max_size[logo,2048]|is_image[logo]|mime_in[logo,image/jpg,image/jpeg,image/png,image/webp]'
        ];

        if ($this->validateInput($rules)) {
            return redirect()->back()->withInput();
        }

        $logoName = $this->handleUpload($this->request->getFile('logo'), 'game', $game['logo']);

        $this->gameModel->save([
            'id_game'   => $id,
            'nama_game' => $this->request->getVar('nama_game'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'logo'      => $logoName
        ]);

        return redirect()->to('game')->with('success', 'Game berhasil diupdate.');
    }

    /**
     * Menghapus game
     * 
     * Memeriksa apakah game sedang digunakan dalam turnamen sebelum menghapusnya.
     * Jika aman, file logo fisik juga dihapus.
     * 
     * @param int $id ID game
     */
    public function delete($id)
    {
        $game = $this->gameModel->find($id);
        if (!$game) {
            return redirect()->to('game')->with('error', 'Game tidak ditemukan.');
        }

        // Cek relasi dengan turnamen
        $turnamen = $this->gameModel->getTurnamen($id);
        if (!empty($turnamen)) {
            return redirect()->to('game')->with('error', 'Game tidak bisa dihapus karena sedang digunakan dalam turnamen.');
        }

        if ($game['logo'] && file_exists(FCPATH . 'uploads/game/' . $game['logo'])) {
            unlink(FCPATH . 'uploads/game/' . $game['logo']);
        }

        $this->gameModel->delete($id);

        return redirect()->to('game')->with('success', 'Game berhasil dihapus.');
    }
}
