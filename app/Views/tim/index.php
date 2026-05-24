<?= $this->extend('layout/dashboard_layout') ?>
<?= $this->section('content') ?>

<?php $peran = session('peran'); ?>

<div class="page-heading">
    <h1><i class="fas fa-users"></i> Daftar Tim</h1>
</div>

<div class="card">
    <div class="card-header">
        <h4>Data Tim</h4>
        <?php if ($peran === 'Admin'): ?>
        <a href="<?= base_url('tim/tambah') ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Tim</a>
        <?php endif; ?>
    </div>
    <div class="card-body-inner" style="padding:0">
        <table class="tbl">
            <thead>
                <tr>
                    <th>Nama Tim</th>
                    <th>Asal Kota</th>
                    <th>Kapten</th>
                    <th>Kontak</th>
                    <th style="text-align:center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tim as $t): ?>
                <tr>
                    <td><strong><?= esc($t['nama_tim']) ?></strong></td>
                    <td><?= esc($t['asal_kota']) ?></td>
                    <td><?= esc($t['nama_lengkap']) ?></td>
                    <td><?= esc($t['kontak_kapten'] ?? '-') ?></td>
                    <td style="text-align:center">
                        <!-- Detail: semua role bisa lihat -->
                        <a href="<?= base_url('tim/detail/'.$t['id_tim']) ?>" class="btn btn-warning btn-sm" title="Detail Tim"><i class="fas fa-eye"></i></a>
                        <?php if ($peran === 'Admin'): ?>
                        <!-- Edit & Hapus: hanya Admin -->
                        <a href="<?= base_url('tim/edit/'.$t['id_tim']) ?>" class="btn btn-info btn-sm" aria-label="Edit"><i class="fas fa-edit"></i></a>
                        <a href="<?= base_url('tim/hapus/'.$t['id_tim']) ?>" class="btn btn-danger btn-sm" aria-label="Hapus" onclick="return confirm('Yakin hapus tim ini?')"><i class="fas fa-trash"></i></a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($tim)): ?>
                <tr>
                    <td colspan="5">
                        <div class="empty-state"><i class="fas fa-users"></i><p>Belum ada tim</p></div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>