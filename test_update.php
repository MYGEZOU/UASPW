<?php
require 'public/index.php';
$model = new \App\Models\TimModel();

// Ambil ID tim pertama
$tim = $model->first();
if ($tim) {
    echo "ID Tim awal: " . $tim['id_tim'] . "\n";
    echo "Nama lama: " . $tim['nama_tim'] . "\n";
    
    // Update
    $data = [
        'nama_tim' => $tim['nama_tim'] . ' Updated'
    ];
    $model->update($tim['id_tim'], $data);
    
    $timAfter = $model->find($tim['id_tim']);
    echo "Nama baru: " . $timAfter['nama_tim'] . "\n";
    
    $all = $model->findAll();
    echo "Jumlah total tim: " . count($all) . "\n";
} else {
    echo "Tidak ada data tim.\n";
}
