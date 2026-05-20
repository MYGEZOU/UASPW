<?= $this->extend('layout/dashboard_layout') ?>
<?= $this->section('content') ?>

<div class="page-heading">
    <h1><i class="fas fa-shield-alt"></i> Profil Tim Saya</h1>
</div>

<?php if ($tim): ?>

<div class="card">
    <div class="card-header">
        <h4>Profil Tim
            <?php if (!$is_kapten): ?>
                <span class="badge badge-info" style="font-size:10px;margin-left:8px;">Anggota</span>
            <?php endif; ?>
        </h4>
        <?php if ($is_kapten): ?>
        <div style="display:flex;gap:8px">
            <a href="<?= base_url('tim/edit/' . $tim['id_tim']) ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit Tim</a>
            <a href="<?= base_url('tim/hapus/' . $tim['id_tim']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus tim ini?')"><i class="fas fa-trash"></i> Hapus Tim</a>
        </div>
        <?php endif; ?>
    </div>
    <div class="card-body-inner">
        <div style="display:flex;align-items:center;gap:20px;margin-bottom:8px">
            <div class="stat-icon orange" style="width:60px;height:60px;border-radius:14px;font-size:24px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                <i class="fas fa-shield-alt"></i>
            </div>
            <div>
                <div style="font-size:20px;font-weight:800;color:#fff"><?= esc($tim['nama_tim']) ?></div>
                <div style="font-size:12px;color:rgba(255,255,255,.4);margin-top:4px">
                    <i class="fas fa-map-marker-alt"></i> <?= esc($tim['asal_kota']) ?>
                    &nbsp;&nbsp;<i class="fas fa-phone"></i> <?= esc($tim['kontak_kapten']) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4>Daftar Anggota</h4>
        <?php if ($is_kapten): ?>
            <a href="<?= base_url('anggota/tambah-peserta') ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Anggota</a>
        <?php endif; ?>
    </div>
    <div class="card-body-inner" style="padding:0">
        <table class="tbl">
            <thead>
                <tr><th>#</th><th>Nickname</th><th>Peran / Posisi</th><th>Peringkat Game</th><th>Akun Terhubung</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                <?php if (empty($anggota)): ?>
                <tr><td colspan="5"><div class="empty-state"><i class="fas fa-user-plus"></i><p>Belum ada anggota. <a href="<?= base_url('anggota/tambah-peserta') ?>" style="color:#FF4B2B">Tambah sekarang</a></p></div></td></tr>
                <?php else: ?>
                    <?php foreach ($anggota as $i => $a): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= esc($a['nickname']) ?></td>
                        <td><?= esc($a['peran']) ?></td>
                        <td><span class="badge badge-info"><?= esc($a['peringkat_game']) ?></span></td>
                        <td>
                            <?php if (!empty($a['id_akun'])): ?>
                                <span class="badge badge-success"><i class="fas fa-link" style="margin-right:4px;"></i><?= esc($a['email_akun'] ?? 'Terhubung') ?></span>
                            <?php elseif ($is_kapten && !empty($peserta_tersedia)): ?>
                                <div style="display:flex;align-items:center;gap:6px;">
                                    <form action="<?= base_url('anggota/link-akun/'.$a['id_anggota']) ?>" method="post" style="display:flex;gap:5px;align-items:center;">
                                        <?= csrf_field() ?>
                                        <select name="id_akun" class="form-control" style="padding:4px 8px;font-size:11px;height:auto;">
                                            <option value="">-- pilih akun --</option>
                                            <?php foreach ($peserta_tersedia as $pt): ?>
                                                <option value="<?= $pt['id_akun'] ?>"><?= esc($pt['nama_lengkap'] ?: $pt['username']) ?> (<?= esc($pt['email']) ?>)</option>
                                            <?php endforeach; ?>
                                        </select>
                                        <button type="submit" class="btn btn-success btn-sm" title="Hubungkan"><i class="fas fa-link"></i></button>
                                    </form>
                                </div>
                            <?php else: ?>
                                <span class="badge badge-secondary">Belum terhubung</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($is_kapten): ?>
                                <a href="<?= base_url('anggota/edit-peserta/' . $a['id_anggota']) ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                <a href="<?= base_url('anggota/hapus-peserta/' . $a['id_anggota']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus anggota ini?')"><i class="fas fa-trash"></i></a>
                            <?php else: ?>
                                <span style="font-size:11px;color:rgba(255,255,255,.25)">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php else: ?>

<div style="max-width:500px;margin:0 auto">
    <div class="card">
        <div class="card-body-inner" style="text-align:center;padding:60px 40px">
            <div class="stat-icon orange" style="width:80px;height:80px;border-radius:20px;font-size:34px;display:inline-flex;align-items:center;justify-content:center;margin-bottom:20px">
                <i class="fas fa-users"></i>
            </div>
            <h3 style="color:#fff;margin-bottom:10px">Anda belum memiliki tim</h3>
            <p style="color:rgba(255,255,255,.4);font-size:13px;margin-bottom:24px">Buat tim Anda untuk mulai mendaftar ke turnamen.</p>
            <a href="<?= base_url('tim/tambah') ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Buat Tim Sekarang</a>
        </div>
    </div>
</div>

<?php endif; ?>

<?= $this->endSection() ?>
