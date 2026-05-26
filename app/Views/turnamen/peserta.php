<?= $this->extend('layout/dashboard_layout') ?>
<?= $this->section('content') ?>

<div class="page-heading">
    <h1><i class="fas fa-trophy"></i> Turnamen Tersedia</h1>
</div>

<div class="card">
    <div class="card-header">
        <h4>Daftar Turnamen</h4>
    </div>
    <div class="card-body-inner" style="padding:0">
        <table class="tbl">
            <thead>
                <tr><th>#</th><th>Nama Turnamen</th><th>Game</th><th>Tgl Mulai</th><th>Biaya</th><th>Status</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                <?php if (empty($turnamen)): ?>
                <tr><td colspan="7"><div class="empty-state"><i class="fas fa-trophy"></i><p>Belum ada turnamen yang tersedia saat ini.</p></div></td></tr>
                <?php else: ?>
                    <?php foreach ($turnamen as $i => $t): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><strong><?= esc($t['nama_turnamen']) ?></strong></td>
                        <td><?= esc($t['game']) ?></td>
                        <td><?= date('d M Y', strtotime($t['tanggal_mulai'])) ?></td>
                        <td>Rp <?= number_format($t['biaya_pendaftaran'], 0, ',', '.') ?></td>
                        <td>
                            <?php
                            $badge = match($t['status']) {
                                'Aktif'   => 'badge-success',
                                'Ditutup' => 'badge-secondary',
                                default   => 'badge-warning',
                            };
                            ?>
                            <span class="badge <?= $badge ?>"><?= esc($t['status']) ?></span>
                        </td>
                        <td>
                            <?php if (in_array($t['id_turnamen'], $pendaftaran_saya)): ?>
                                <span class="badge badge-info"><i class="fas fa-check"></i> Sudah Daftar</span>
                            <?php elseif ($t['status'] === 'Aktif'): ?>
                                <a href="<?= base_url('daftar/ikut/' . $t['id_turnamen']) ?>" class="btn btn-primary btn-sm"><i class="fas fa-sign-in-alt"></i> Daftar</a>
                            <?php else: ?>
                                <span style="color:rgba(255,255,255,.25)">–</span>
                            <?php endif; ?>
                            <a href="<?= base_url('turnamen/detail/' . $t['id_turnamen']) ?>" class="btn btn-secondary btn-sm" style="margin-left:5px" title="Detail"><i class="fas fa-eye"></i> Detail</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
