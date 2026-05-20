<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class GameController extends BaseController
{
    protected $gameModel;

    public function __construct()
    {
        $this->gameModel = new \App\Models\GameModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Master Game',
            'games' => $this->gameModel->findAll()
        ];
        return view('game/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Game'
        ];
        return view('game/form', $data);
    }

    public function store()
    {
        $rules = [
            'nama_game' => 'required|min_length[3]|is_unique[game.nama_game]',
            'logo'      => 'max_size[logo,2048]|is_image[logo]|mime_in[logo,image/jpg,image/jpeg,image/png,image/webp]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $logoFile = $this->request->getFile('logo');
        $logoName = null;

        if ($logoFile && $logoFile->isValid() && !$logoFile->hasMoved()) {
            $logoName = 'game_' . time() . '_' . rand(1000, 9999) . '.' . $logoFile->getExtension();
            $logoFile->move(FCPATH . 'uploads/game', $logoName);
        }

        $this->gameModel->save([
            'nama_game' => $this->request->getVar('nama_game'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'logo'      => $logoName
        ]);

        return redirect()->to('game')->with('success', 'Game berhasil ditambahkan.');
    }

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

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $logoFile = $this->request->getFile('logo');
        $logoName = $game['logo'];

        if ($logoFile && $logoFile->isValid() && !$logoFile->hasMoved()) {
            $logoName = 'game_' . time() . '_' . rand(1000, 9999) . '.' . $logoFile->getExtension();
            $logoFile->move(FCPATH . 'uploads/game', $logoName);

            // Hapus logo lama
            if ($game['logo'] && file_exists(FCPATH . 'uploads/game/' . $game['logo'])) {
                unlink(FCPATH . 'uploads/game/' . $game['logo']);
            }
        }

        $this->gameModel->save([
            'id_game'   => $id,
            'nama_game' => $this->request->getVar('nama_game'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'logo'      => $logoName
        ]);

        return redirect()->to('game')->with('success', 'Game berhasil diupdate.');
    }

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
