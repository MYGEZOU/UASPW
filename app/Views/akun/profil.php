<?= $this->extend('layout/dashboard_layout') ?>
<?= $this->section('content') ?>

<div class="page-heading">
    <h1><i class="fas fa-user-edit"></i> Edit Profil Saya</h1>
    <p>Perbarui informasi akun dan ganti password Anda di sini</p>
</div>

<div style="max-width:560px;">
    <div class="card">
        <div class="card-header">
            <h4><i class="fas fa-id-card"></i> Informasi Akun</h4>
        </div>
        <div class="card-body-inner">
            <form action="<?= base_url('profil/update') ?>" method="post">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control"
                           value="<?= esc(old('nama_lengkap', $akun['nama_lengkap'])) ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control"
                           value="<?= esc(old('username', $akun['username'])) ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control"
                           value="<?= esc(old('email', $akun['email'])) ?>" required>
                </div>

                <hr style="border-color:rgba(255,255,255,.06); margin:20px 0;">

                <p style="font-size:12px; color:rgba(255,255,255,.35); margin-bottom:14px;">
                    <i class="fas fa-lock" style="margin-right:5px;"></i>
                    Kosongkan field password jika tidak ingin menggantinya
                </p>

                <div class="form-group">
                    <label class="form-label">Password Baru</label>
                    <div style="position:relative;">
                        <input type="password" id="new_pass" name="password" class="form-control"
                               placeholder="Min. 6 karakter" style="padding-right:42px;">
                        <button type="button" onclick="togglePass('new_pass', this)"
                                style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;color:rgba(255,255,255,.4);cursor:pointer;font-size:14px;">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <div style="position:relative;">
                        <input type="password" id="conf_pass" name="password_confirm" class="form-control"
                               placeholder="Ulangi password baru" style="padding-right:42px;">
                        <button type="button" onclick="togglePass('conf_pass', this)"
                                style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;color:rgba(255,255,255,.4);cursor:pointer;font-size:14px;">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div style="display:flex; gap:10px; margin-top:24px;">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
                    <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary"><i class="fas fa-times"></i> Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function togglePass(id, btn) {
    const input = document.getElementById(id);
    const icon = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'fas fa-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'fas fa-eye';
    }
}
</script>

<?= $this->endSection() ?>
