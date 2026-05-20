<?= $this->extend('layout/dashboard_layout') ?>
<?= $this->section('content') ?>

<div class="page-heading">
    <h1><i class="fas fa-users"></i> <?= isset($tim) && !empty($tim['id_tim']) ? 'Edit' : 'Tambah' ?> Tim</h1>
</div>

<div style="max-width:600px;margin:0 auto">
    <div class="card">
        <div class="card-header">
            <h4><?= isset($tim) && !empty($tim['id_tim']) ? 'Edit' : 'Tambah' ?> Data Tim</h4>
        </div>
        <form action="<?= base_url(isset($tim) && !empty($tim['id_tim']) ? 'tim/update/'.$tim['id_tim'] : 'tim/simpan') ?>" method="post">
            <?= csrf_field() ?>
            <?php if (isset($tim) && !empty($tim['id_tim'])): ?>
            <input type="hidden" name="id_tim" value="<?= $tim['id_tim'] ?>">
            <?php endif; ?>
            <div class="card-body-inner">
                <div class="form-group">
                    <label class="form-label">Nama Tim</label>
                    <input type="text" name="nama_tim" class="form-control" value="<?= old('nama_tim', $tim['nama_tim'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Asal Kota</label>
                    <input type="text" name="asal_kota" class="form-control" value="<?= old('asal_kota', $tim['asal_kota'] ?? '') ?>" required>
                </div>
                <?php if (session()->get('peran') === 'Admin'): ?>
                <div class="form-group">
                    <label class="form-label">Kapten (Pilih dari akun peserta)</label>
                    <select name="id_akun" class="form-control" required>
                        <option value="">-- Pilih Kapten --</option>
                        <?php foreach ($akun_peserta ?? [] as $akun): ?>
                        <option value="<?= $akun['id_akun'] ?>" <?= (old('id_akun', $tim['id_akun'] ?? '') == $akun['id_akun']) ? 'selected' : '' ?>><?= $akun['username'] ?> - <?= $akun['nama_lengkap'] ?? '' ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php else: ?>
                <input type="hidden" name="id_akun" value="<?= session()->get('id_akun') ?>">
                <?php endif; ?>
                <div class="form-group">
                    <label class="form-label">Kontak Kapten</label>
                    <input type="text" name="kontak_kapten" class="form-control" value="<?= old('kontak_kapten', $tim['kontak_kapten'] ?? '') ?>" placeholder="Nomor HP / WhatsApp">
                </div>
            </div>
            <div class="card-footer-inner" style="display:flex;gap:10px">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                <a href="<?= base_url('tim') ?>" class="btn btn-secondary"><i class="fas fa-times"></i> Batal</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>