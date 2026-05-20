<?= $this->extend('layout/dashboard_layout') ?>
<?= $this->section('content') ?>

<div class="page-heading">
    <h1><i class="fas fa-id-card"></i> <?= isset($anggota) ? 'Edit Anggota Tim' : 'Tambah Anggota Tim' ?></h1>
</div>

<div style="max-width:560px;margin:0 auto">
    <div class="card">
        <div class="card-header">
            <h4><?= isset($anggota) ? 'Edit Anggota Tim' : 'Tambah Anggota Tim' ?></h4>
        </div>
        <form action="<?= base_url(isset($anggota) ? 'anggota/update-peserta/'.$anggota['id_anggota'] : 'anggota/simpan-peserta') ?>" method="post">
            <?= csrf_field() ?>
            <div class="card-body-inner">
                <?php if (session('error')): ?>
                    <div class="flash-msg error"><i class="fas fa-exclamation-circle"></i> <?= session('error') ?></div>
                <?php endif; ?>
                <div class="form-group">
                    <label class="form-label">Nickname / IGN</label>
                    <input type="text" name="nickname" class="form-control" value="<?= old('nickname', $anggota['nickname'] ?? '') ?>" placeholder="Contoh: xXProPlayerXx" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Peran (Role dalam Game)</label>
                    <input type="text" name="peran" class="form-control" value="<?= old('peran', $anggota['peran'] ?? '') ?>" placeholder="Contoh: Carry, Support, Jungler, dll.">
                </div>
                <div class="form-group">
                    <label class="form-label">Peringkat Game</label>
                    <input type="text" name="peringkat_game" class="form-control" value="<?= old('peringkat_game', $anggota['peringkat_game'] ?? '') ?>" placeholder="Contoh: Mythic, Grandmaster, dll.">
                </div>
                <?php if (!isset($anggota) && !empty($peserta_list)): ?>
                <div class="form-group">
                    <label class="form-label">Hubungkan ke Akun Peserta <span style="color:rgba(255,255,255,.3);font-weight:normal">(Opsional)</span></label>
                    <select name="id_akun_anggota" class="form-control">
                        <option value="">-- Tidak dihubungkan ke akun --</option>
                        <?php foreach ($peserta_list as $p): ?>
                            <option value="<?= $p['id_akun'] ?>"><?= esc($p['nama_lengkap']) ?> (<?= esc($p['email']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                    <div class="form-text">Jika dihubungkan, peserta ini bisa login dan melihat tim ini sebagai timnya.</div>
                </div>
                <?php endif; ?>
            </div>
            <div class="card-footer-inner" style="display:flex;gap:10px">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> <?= isset($anggota) ? 'Update Anggota' : 'Simpan Anggota' ?></button>
                <a href="<?= base_url('tim/profil') ?>" class="btn btn-secondary"><i class="fas fa-times"></i> Batal</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
