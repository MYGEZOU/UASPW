<?= $this->extend('layout/dashboard_layout') ?>
<?= $this->section('content') ?>

<div class="page-heading">
    <h1><i class="fas fa-home"></i> Dashboard Admin</h1>
    <p>Selamat datang kembali, <?= esc(session('nama_lengkap')) ?></p>
</div>

<div class="row">
    <div class="col-3">
        <div class="stat-card">
            <div class="stat-icon orange"><i class="fas fa-trophy"></i></div>
            <div>
                <div class="stat-label">Turnamen Aktif</div>
                <div class="stat-value"><?= $total_turnamen_aktif ?></div>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-users"></i></div>
            <div>
                <div class="stat-label">Total Tim</div>
                <div class="stat-value"><?= $total_tim ?></div>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-user"></i></div>
            <div>
                <div class="stat-label">Total Peserta</div>
                <div class="stat-value"><?= $total_peserta ?></div>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="stat-card">
            <div class="stat-icon purple"><i class="fas fa-money-bill"></i></div>
            <div>
                <div class="stat-label">Pendapatan</div>
                <div class="stat-value" style="font-size:18px">Rp <?= number_format($total_pendapatan, 0, ',', '.') ?></div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4>Pendaftaran Terbaru</h4>
    </div>
    <div class="card-body-inner" style="padding:0">
        <table class="tbl">
            <thead>
                <tr>
                    <th>Turnamen</th>
                    <th>Tim</th>
                    <th>Tanggal Daftar</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($pendaftaran_terbaru)): ?>
                <tr><td colspan="4" class="empty-state"><i class="fas fa-inbox"></i><br>Belum ada pendaftaran</td></tr>
                <?php else: ?>
                    <?php foreach ($pendaftaran_terbaru as $daftar): ?>
                    <tr>
                        <td><?= esc($daftar['nama_turnamen']) ?></td>
                        <td><?= esc($daftar['nama_tim']) ?></td>
                        <td><?= date('d M Y', strtotime($daftar['tanggal_daftar'])) ?></td>
                        <td><span class="badge <?= ($daftar['status_pembayaran'] == 'Lunas') ? 'badge-success' : 'badge-warning' ?>"><?= esc($daftar['status_pembayaran']) ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>