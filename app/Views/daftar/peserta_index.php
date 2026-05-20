<?= $this->extend('layout/dashboard_layout') ?>
<?= $this->section('content') ?>

<div class="page-heading">
    <h1><i class="fas fa-list-alt"></i> <?= esc($title) ?></h1>
</div>

<div class="card">
    <div class="card-header">
        <h4>Riwayat Pendaftaran Tim Saya</h4>
    </div>
    <div class="card-body-inner" style="padding:0">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success" style="margin: 15px;"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger" style="margin: 15px;"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('info')): ?>
            <div class="alert alert-info" style="margin: 15px;"><?= session()->getFlashdata('info') ?></div>
        <?php endif; ?>

        <table class="tbl">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Turnamen</th>
                    <th>Game</th>
                    <th>Biaya</th>
                    <th>Status Pembayaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($pendaftaran)): ?>
                    <tr><td colspan="6"><div class="empty-state"><i class="fas fa-folder-open"></i><p>Tim Anda belum mendaftar turnamen apapun</p></div></td></tr>
                <?php else: ?>
                    <?php foreach ($pendaftaran as $i => $p): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><strong><?= esc($p['nama_turnamen']) ?></strong></td>
                        <td><?= esc($p['nama_game'] ?? '-') ?></td>
                        <td>Rp <?= number_format($p['biaya_pendaftaran'], 0, ',', '.') ?></td>
                        <td>
                            <?php if ($p['status_pembayaran'] == 'Lunas'): ?>
                                <span class="badge badge-success"><i class="fas fa-check-circle"></i> Lunas</span>
                            <?php else: ?>
                                <span class="badge badge-warning"><i class="fas fa-clock"></i> Menunggu Konfirmasi</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($p['status_pembayaran'] == 'Menunggu'): ?>
                                <a href="<?= base_url('pembayaran/upload/' . $p['id_daftar']) ?>" class="btn btn-sm btn-info"><i class="fas fa-upload"></i> Upload Bukti</a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
