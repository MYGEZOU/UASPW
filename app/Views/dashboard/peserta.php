<?= $this->extend('layout/dashboard_layout') ?>
<?= $this->section('content') ?>

<div class="page-heading">
    <h1><i class="fas fa-home"></i> Dashboard Peserta</h1>
    <p>Selamat datang, <?= esc(session('nama_lengkap')) ?>!</p>
</div>

<div class="card">
    <div class="card-header">
        <h4><i class="fas fa-users"></i> Tim Anda</h4>
        <?php if (!$tim_peserta && !session('id_tim')): ?>
            <a href="<?= base_url('tim/tambah') ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Buat Tim</a>
        <?php endif; ?>
    </div>
    <div class="card-body-inner">
        <?php if ($tim_peserta): ?>
            <div style="display:flex;align-items:center;gap:20px;flex-wrap:wrap;">
                <div class="stat-icon orange" style="width:54px;height:54px;border-radius:12px;font-size:22px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div style="flex:1">
                    <div style="font-size:18px;font-weight:800;color:#fff"><?= esc($tim_peserta['nama_tim']) ?></div>
                    <div style="font-size:12px;color:rgba(255,255,255,.5);margin-top:4px">
                        <i class="fas fa-map-marker-alt"></i> <?= esc($tim_peserta['asal_kota']) ?>
                        &nbsp;&nbsp;<i class="fas fa-phone"></i> <?= esc($tim_peserta['kontak_kapten']) ?>
                        <?php if ($tim_peserta['id_akun'] != session('id_akun')): ?>
                            &nbsp;&nbsp;<span class="badge badge-info" style="font-size:9px;">Anggota</span>
                        <?php else: ?>
                            &nbsp;&nbsp;<span class="badge badge-warning" style="font-size:9px;">Kapten</span>
                        <?php endif; ?>
                    </div>
                </div>
                <a href="<?= base_url('tim/profil') ?>" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Detail Tim</a>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-users"></i>
                <p>Anda belum memiliki tim. <a href="<?= base_url('tim/tambah') ?>" style="color:#FF4B2B">Buat tim sekarang</a></p>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-header"><h4>Turnamen Diikuti</h4></div>
            <div class="card-body-inner" style="padding:0">
                <table class="tbl">
                    <thead><tr><th>Turnamen</th><th>Status</th><th>Pembayaran</th></tr></thead>
                    <tbody>
                        <?php if (empty($turnamen_diikuti)): ?>
                        <tr><td colspan="3" style="text-align:center;padding:20px;color:rgba(255,255,255,.3)">Belum ada turnamen</td></tr>
                        <?php else: ?>
                            <?php foreach ($turnamen_diikuti as $t): ?>
                            <tr>
                                <td><?= esc($t['nama_turnamen']) ?></td>
                                <td><span class="badge badge-primary"><?= esc($t['status']) ?></span></td>
                                <td><span class="badge <?= $t['status_pembayaran'] == 'Lunas' ? 'badge-success' : 'badge-warning' ?>"><?= esc($t['status_pembayaran']) ?></span></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-header"><h4>Jadwal Pertandingan</h4></div>
            <div class="card-body-inner" style="padding:0">
                <table class="tbl">
                    <thead><tr><th>Tanggal</th><th>Turnamen</th><th>Babak</th></tr></thead>
                    <tbody>
                        <?php if (empty($jadwal_tim)): ?>
                        <tr><td colspan="3" style="text-align:center;padding:20px;color:rgba(255,255,255,.3)">Belum ada jadwal</td></tr>
                        <?php else: ?>
                            <?php foreach ($jadwal_tim as $j): ?>
                            <tr>
                                <td><?= date('d M H:i', strtotime($j['jadwal_tanding'])) ?></td>
                                <td><?= esc($j['nama_turnamen']) ?></td>
                                <td><span class="badge badge-info"><?= esc($j['babak']) ?></span></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>