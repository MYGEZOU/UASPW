<?= $this->extend('layout/dashboard_layout') ?>
<?= $this->section('content') ?>

<?php $peran = session('peran'); ?>

<div class="page-heading">
    <h1><i class="fas fa-trophy"></i> <?= $peran === 'Admin' ? 'Manajemen Turnamen' : 'Daftar Turnamen' ?></h1>
</div>

<div class="card">
    <div class="card-header">
        <h4>Data Turnamen</h4>
        <?php if ($peran === 'Admin'): ?>
        <a href="<?= base_url('turnamen/tambah') ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Turnamen</a>
        <?php endif; ?>
    </div>
    <div class="card-body-inner" style="padding:0">
        <table class="tbl">
            <thead>
                <tr>
                    <th>Nama Turnamen</th>
                    <th>Game</th>
                    <th>Tgl Mulai</th>
                    <th>Biaya</th>
                    <th>Status</th>
                    <?php if ($peran === 'Admin'): ?>
                    <th style="text-align:center">Aksi</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($turnamen as $t): ?>
                <tr>
                    <td><strong><?= esc($t['nama_turnamen']) ?></strong></td>
                    <td><?= esc($t['game']) ?></td>
                    <td><?= date('d M Y', strtotime($t['tanggal_mulai'])) ?></td>
                    <td>Rp <?= number_format($t['biaya_pendaftaran'], 0, ',', '.') ?></td>
                    <td>
                        <span class="badge <?= $t['status']=='Pendaftaran' ? 'badge-warning' : ($t['status']=='Berlangsung' ? 'badge-info' : 'badge-success') ?>">
                            <?= esc($t['status']) ?>
                        </span>
                    </td>
                    <?php if ($peran === 'Admin'): ?>
                    <td style="text-align:center">
                        <a href="<?= base_url('turnamen/edit/'.$t['id_turnamen']) ?>" class="btn btn-info btn-sm" aria-label="Edit"><i class="fas fa-edit"></i></a>
                        <a href="<?= base_url('turnamen/hapus/'.$t['id_turnamen']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus turnamen ini?')" aria-label="Hapus"><i class="fas fa-trash"></i></a>
                    </td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($turnamen)): ?>
                <tr>
                    <td colspan="<?= $peran === 'Admin' ? '6' : '5' ?>">
                        <div class="empty-state"><i class="fas fa-trophy"></i><p>Belum ada data turnamen</p></div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>