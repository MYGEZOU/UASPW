<?= $this->extend('layout/dashboard_layout') ?>
<?= $this->section('content') ?>

<div class="page-heading">
    <h1><i class="fas fa-gamepad"></i> Dashboard Admin Game</h1>
    <p>Selamat datang, <?= esc(session('nama_lengkap')) ?></p>
</div>

<div class="row">
    <div class="col-6">
        <div class="stat-card">
            <div class="stat-icon orange"><i class="fas fa-trophy"></i></div>
            <div>
                <div class="stat-label">Turnamen Aktif</div>
                <div class="stat-value"><?= $turnamen_aktif ?></div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-calendar-day"></i></div>
            <div>
                <div class="stat-label">Pertandingan Hari Ini</div>
                <div class="stat-value"><?= $pertandingan_hari_ini ?></div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4>Jadwal Pertandingan Terbaru</h4>
        <a href="<?= base_url('jadwal/tambah') ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Jadwal</a>
    </div>
    <div class="card-body-inner" style="padding:0">
        <table class="tbl">
            <thead>
                <tr><th>Turnamen</th><th>Tim 1</th><th>Tim 2</th><th>Waktu</th><th>Babak</th></tr>
            </thead>
            <tbody>
                <?php if (empty($jadwal_terbaru)): ?>
                <tr><td colspan="5" class="empty-state"><i class="fas fa-calendar"></i><br>Belum ada jadwal</td></tr>
                <?php else: ?>
                    <?php foreach ($jadwal_terbaru as $j): ?>
                    <tr>
                        <td><?= esc($j['nama_turnamen']) ?></td>
                        <td><?= esc($j['nama_tim_1']) ?></td>
                        <td><?= esc($j['nama_tim_2']) ?></td>
                        <td><?= date('d M H:i', strtotime($j['jadwal_tanding'])) ?></td>
                        <td><span class="badge badge-info"><?= esc($j['babak']) ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>