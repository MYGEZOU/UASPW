<?= $this->extend('layout/dashboard_layout') ?>
<?= $this->section('content') ?>

<div class="page-heading">
    <h1><i class="fas fa-history"></i> <?= esc($title) ?></h1>
</div>

<div class="card">
    <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
        <h4>Riwayat Pembayaran Dikonfirmasi (Lunas)</h4>
        <div>
            <a href="<?= base_url('pembayaran/menunggu') ?>" class="btn btn-primary btn-sm"><i class="fas fa-clock"></i> Kembali ke Menunggu</a>
        </div>
    </div>
    <div class="card-body-inner" style="padding:0">
        <table class="tbl">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tim</th>
                    <th>Turnamen</th>
                    <th>Biaya</th>
                    <th>Tgl Daftar</th>
                    <th>Tgl Konfirmasi</th>
                    <th>Bukti</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($riwayat)): ?>
                    <tr><td colspan="7"><div class="empty-state"><i class="fas fa-inbox"></i><p>Belum ada riwayat pembayaran lunas</p></div></td></tr>
                <?php else: ?>
                    <?php foreach ($riwayat as $i => $r): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><strong><?= esc($r['nama_tim']) ?></strong></td>
                        <td><?= esc($r['nama_turnamen']) ?></td>
                        <td>Rp <?= number_format($r['biaya_pendaftaran'], 0, ',', '.') ?></td>
                        <td><?= date('d M Y', strtotime($r['tanggal_daftar'])) ?></td>
                        <td><?= $r['tanggal_konfirmasi'] ? date('d M Y H:i', strtotime($r['tanggal_konfirmasi'])) : '-' ?></td>
                        <td>
                            <?php if (!empty($r['bukti_pembayaran'])): ?>
                                <a href="<?= base_url('uploads/bukti_pembayaran/' . $r['bukti_pembayaran']) ?>" target="_blank" class="btn btn-sm btn-secondary"><i class="fas fa-image"></i></a>
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
