<?= $this->extend('layout/dashboard_layout') ?>
<?= $this->section('content') ?>

<div class="page-heading">
    <h1><i class="fas fa-sign-in-alt"></i> Konfirmasi Pendaftaran Turnamen</h1>
</div>

<div style="max-width:600px;margin:0 auto">
    <div class="card">
        <div class="card-header">
            <h4>Detail Turnamen</h4>
        </div>
        <form action="<?= base_url('daftar/proses-ikut') ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="id_turnamen" value="<?= $turnamen['id_turnamen'] ?>">
            <div class="card-body-inner">
                <div class="alert-info-form">
                    <i class="fas fa-info-circle"></i> Anda akan mendaftarkan tim Anda ke turnamen berikut:
                </div>
                <table class="detail-table">
                    <tr>
                        <th>Nama Turnamen</th>
                        <td>: <strong><?= esc($turnamen['nama_turnamen']) ?></strong></td>
                    </tr>
                    <tr>
                        <th>Game</th>
                        <td>: <?= esc($turnamen['game']) ?></td>
                    </tr>
                    <tr>
                        <th>Tanggal Mulai</th>
                        <td>: <?= date('d M Y', strtotime($turnamen['tanggal_mulai'])) ?></td>
                    </tr>
                    <tr>
                        <th>Biaya Pendaftaran</th>
                        <td>: <strong style="color:#FF4B2B">Rp <?= number_format($turnamen['biaya_pendaftaran'], 0, ',', '.') ?></strong></td>
                    </tr>
                </table>
                <div class="alert-warning-form" style="margin-top:16px">
                    <i class="fas fa-exclamation-triangle"></i>
                    Dengan mengklik Konfirmasi &amp; Daftar, Anda menyetujui seluruh syarat dan ketentuan turnamen. Pembayaran disimulasikan sebagai lunas secara otomatis.
                </div>
            </div>
            <div class="card-footer-inner" style="display:flex;gap:10px">
                <button type="submit" class="btn btn-primary"><i class="fas fa-check-circle"></i> Konfirmasi &amp; Daftar</button>
                <a href="<?= base_url('turnamen/peserta') ?>" class="btn btn-secondary"><i class="fas fa-times"></i> Batal</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
