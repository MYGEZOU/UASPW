<?= $this->extend('layout/dashboard_layout') ?>
<?= $this->section('content') ?>

<div class="page-heading">
    <h1><i class="fas fa-id-card"></i> <?= isset($anggota) ? 'Edit' : 'Tambah' ?> Anggota</h1>
</div>

<div style="max-width:600px;margin:0 auto">
    <div class="card">
        <div class="card-header">
            <h4><?= isset($anggota) ? 'Edit' : 'Tambah' ?> Anggota Tim</h4>
        </div>
        <form action="<?= base_url(isset($anggota) ? 'anggota/update/'.$anggota['id_anggota'] : 'anggota/simpan') ?>" method="post">
            <?= csrf_field() ?>
            <div class="card-body-inner">
                <?php if (session('error')): ?>
                    <div class="flash-msg error"><i class="fas fa-exclamation-circle"></i> <?= session('error') ?></div>
                <?php endif; ?>
                <div class="form-group">
                    <label class="form-label">Pilih Tim</label>
                    <select name="id_tim" class="form-control" required>
                        <option value="">-- Pilih Tim --</option>
                        <?php foreach ($tim_list as $tim): ?>
                        <option value="<?= $tim['id_tim'] ?>" <?= (old('id_tim', $anggota['id_tim'] ?? '') == $tim['id_tim']) ? 'selected' : '' ?>><?= $tim['nama_tim'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Nickname</label>
                    <input type="text" name="nickname" class="form-control" value="<?= old('nickname', $anggota['nickname'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Peran (Role Game)</label>
                    <input type="text" name="peran" class="form-control" value="<?= old('peran', $anggota['peran'] ?? '') ?>" placeholder="Contoh: Carry, Support, dll.">
                </div>
                <div class="form-group">
                    <label class="form-label">Peringkat Game</label>
                    <input type="text" name="peringkat_game" class="form-control" value="<?= old('peringkat_game', $anggota['peringkat_game'] ?? '') ?>">
                </div>
            </div>
            <div class="card-footer-inner" style="display:flex;gap:10px">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                <a href="<?= base_url('anggota') ?>" class="btn btn-secondary"><i class="fas fa-times"></i> Batal</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>