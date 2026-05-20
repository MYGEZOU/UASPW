<?= $this->extend('layout/dashboard_layout') ?>
<?= $this->section('content') ?>

<div class="page-heading">
    <h1><i class="fas fa-user-cog"></i> <?= isset($akun) ? 'Edit Akun' : 'Tambah Akun' ?></h1>
</div>

<div style="max-width:600px;margin:0 auto">
    <div class="card">
        <div class="card-header">
            <h4><?= isset($akun) ? 'Edit Akun' : 'Tambah Akun Baru' ?></h4>
        </div>
        <form action="<?= base_url(isset($akun) ? 'akun/update/'.$akun['id_akun'] : 'akun/simpan') ?>" method="post">
            <?= csrf_field() ?>
            <div class="card-body-inner">
                <?php if (session('error')): ?>
                    <div class="flash-msg error"><i class="fas fa-exclamation-circle"></i> <?= session('error') ?></div>
                <?php endif; ?>
                <div class="form-group">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" value="<?= old('username', $akun['username'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= old('email', $akun['email'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Password <?= isset($akun) ? '<small style="font-weight:400;text-transform:none">(Kosongkan jika tidak ingin mengubah)</small>' : '' ?></label>
                    <input type="password" name="password" class="form-control" <?= isset($akun) ? '' : 'required' ?>>
                </div>
                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" value="<?= old('nama_lengkap', $akun['nama_lengkap'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Peran</label>
                    <select name="peran" class="form-control" required>
                        <option value="">-- Pilih Peran --</option>
                        <option value="Admin" <?= old('peran', $akun['peran'] ?? '') == 'Admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="Peserta" <?= old('peran', $akun['peran'] ?? '') == 'Peserta' ? 'selected' : '' ?>>Peserta</option>
                        <option value="AdminGame" <?= old('peran', $akun['peran'] ?? '') == 'AdminGame' ? 'selected' : '' ?>>Admin Game</option>
                    </select>
                </div>
            </div>
            <div class="card-footer-inner" style="display:flex;gap:10px">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                <a href="<?= base_url('akun') ?>" class="btn btn-secondary"><i class="fas fa-times"></i> Batal</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>