<?= $this->extend('layout/dashboard_layout') ?>
<?= $this->section('content') ?>

<div class="page-heading">
    <h1><i class="fas fa-clock"></i> <?= esc($title) ?></h1>
</div>

<div class="card">
    <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
        <h4>Daftar Pendaftaran Menunggu Konfirmasi</h4>
        <div>
            <a href="<?= base_url('pembayaran/riwayat') ?>" class="btn btn-secondary btn-sm"><i class="fas fa-history"></i> Riwayat Lunas</a>
        </div>
    </div>
    <div class="card-body-inner" style="padding:0">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success" style="margin: 15px;"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger" style="margin: 15px;"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <table class="tbl">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tim (Asal)</th>
                    <th>Turnamen</th>
                    <th>Biaya</th>
                    <th>Tanggal Daftar</th>
                    <th>Bukti</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($menunggu)): ?>
                    <tr><td colspan="7"><div class="empty-state"><i class="fas fa-check-circle"></i><p>Tidak ada pendaftaran yang menunggu konfirmasi</p></div></td></tr>
                <?php else: ?>
                    <?php foreach ($menunggu as $i => $m): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><strong><?= esc($m['nama_tim']) ?></strong></td>
                        <td><?= esc($m['nama_turnamen']) ?></td>
                        <td>Rp <?= number_format($m['biaya_pendaftaran'], 0, ',', '.') ?></td>
                        <td><?= date('d M Y H:i', strtotime($m['tanggal_daftar'])) ?></td>
                        <td>
                            <?php if (!empty($m['bukti_pembayaran'])): ?>
                                <?php $ext = strtolower(pathinfo($m['bukti_pembayaran'], PATHINFO_EXTENSION)); ?>
                                <?php if(in_array($ext, ['jpg','jpeg','png'])): ?>
                                    <button type="button" class="btn btn-sm btn-info" onclick="lihatBukti('<?= base_url('uploads/bukti_pembayaran/' . $m['bukti_pembayaran']) ?>')">
                                        <i class="fas fa-image"></i> Cek Bukti
                                    </button>
                                <?php else: ?>
                                    <a href="<?= base_url('uploads/bukti_pembayaran/' . $m['bukti_pembayaran']) ?>" target="_blank" class="btn btn-sm btn-info"><i class="fas fa-file-pdf"></i> Cek Bukti (PDF)</a>
                                <?php endif; ?>
                            <?php else: ?>
                                <span class="badge badge-secondary">Belum Upload</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <form action="<?= base_url('pembayaran/konfirmasi/' . $m['id_daftar']) ?>" method="post" onsubmit="return confirm('Apakah Anda yakin pembayaran ini valid dan Lunas?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-sm btn-success" <?= empty($m['bukti_pembayaran']) ? 'disabled' : '' ?>><i class="fas fa-check"></i> Konfirmasi</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>


<script>
function lihatBukti(url) {
    Swal.fire({
        title: 'Bukti Pembayaran',
        imageUrl: url,
        imageAlt: 'Bukti Transfer',
        imageWidth: '100%',
        width: 500,
        background: '#16213e',
        color: '#fff',
        confirmButtonColor: '#FF4B2B',
        confirmButtonText: 'Tutup',
        backdrop: `rgba(0,0,10,0.8)`
    });
}
</script>

<?= $this->endSection() ?>
