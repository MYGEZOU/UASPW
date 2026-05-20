<?= $this->extend('layout/dashboard_layout') ?>
<?= $this->section('content') ?>

<div class="page-heading">
    <h1><i class="fas fa-shield-alt"></i> Detail Tim</h1>
</div>

<div class="row" style="align-items:flex-start">
    <div class="col-4">
        <div class="card">
            <div class="card-header"><h4>Informasi Tim</h4></div>
            <div class="card-body-inner">
                <div style="text-align:center;margin-bottom:20px">
                    <div class="stat-icon orange" style="width:64px;height:64px;border-radius:16px;font-size:28px;display:inline-flex;align-items:center;justify-content:center;margin-bottom:10px">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div style="font-size:18px;font-weight:800;color:#fff"><?= esc($tim['nama_tim']) ?></div>
                </div>
                <table class="detail-table">
                    <tr><th>Asal Kota</th><td>: <?= esc($tim['asal_kota']) ?></td></tr>
                    <tr><th>Kontak Kapten</th><td>: <?= esc($tim['kontak_kapten']) ?></td></tr>
                </table>
                <div style="display:flex;flex-direction:column;gap:8px;margin-top:16px">
                    <a href="<?= base_url('tim') ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-8">
        <div class="card">
            <div class="card-header">
                <h4>Daftar Anggota</h4>
            </div>
            <div class="card-body-inner" style="padding:0">
                <table class="tbl">
                    <thead>
                        <tr><th>#</th><th>Nickname</th><th>Peran / Posisi</th><th>Peringkat</th></tr>
                    </thead>
                    <tbody>
                        <?php if (empty($anggota)): ?>
                        <tr><td colspan="5"><div class="empty-state"><i class="fas fa-user-plus"></i><p>Belum ada anggota</p></div></td></tr>
                        <?php else: ?>
                            <?php foreach ($anggota as $i => $a): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= esc($a['nickname']) ?></td>
                                <td><?= esc($a['peran']) ?></td>
                                <td><span class="badge badge-info"><?= esc($a['peringkat_game']) ?></span></td>
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
