<?= $this->extend('layout/dashboard_layout') ?>
<?= $this->section('content') ?>

<div class="page-heading">
    <h1><i class="fas fa-trophy"></i> <?= isset($turnamen) ? 'Edit' : 'Tambah' ?> Turnamen</h1>
</div>

<div style="max-width:600px;margin:0 auto">
    <div class="card">
        <div class="card-header">
            <h4><?= isset($turnamen) ? 'Edit' : 'Tambah' ?> Data Turnamen</h4>
        </div>
        <form action="<?= base_url(isset($turnamen) && !empty($turnamen['id_turnamen']) ? 'turnamen/update/'.$turnamen['id_turnamen'] : 'turnamen/simpan') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="card-body-inner">
                <div class="form-group">
                    <label class="form-label">Nama Turnamen</label>
                    <input type="text" name="nama_turnamen" class="form-control" value="<?= old('nama_turnamen', $turnamen['nama_turnamen'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Deskripsi Turnamen</label>
                    <textarea name="deskripsi" class="form-control" rows="4"><?= old('deskripsi', $turnamen['deskripsi'] ?? '') ?></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Game</label>
                    <select name="id_game" class="form-control" required>
                        <option value="">-- Pilih Game --</option>
                        <?php foreach($games as $g): ?>
                            <option value="<?= $g['id_game'] ?>" <?= (old('id_game', $turnamen['id_game'] ?? '') == $g['id_game']) ? 'selected' : '' ?>>
                                <?= esc($g['nama_game']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="form-control" value="<?= old('tanggal_mulai', $turnamen['tanggal_mulai'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Biaya Pendaftaran (Rp)</label>
                    <input type="number" name="biaya_pendaftaran" class="form-control" value="<?= old('biaya_pendaftaran', $turnamen['biaya_pendaftaran'] ?? '') ?>" placeholder="0" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="Pendaftaran" <?= (old('status', $turnamen['status'] ?? '') == 'Pendaftaran') ? 'selected' : '' ?>>Pendaftaran</option>
                        <option value="Berlangsung" <?= (old('status', $turnamen['status'] ?? '') == 'Berlangsung') ? 'selected' : '' ?>>Berlangsung</option>
                        <option value="Selesai" <?= (old('status', $turnamen['status'] ?? '') == 'Selesai') ? 'selected' : '' ?>>Selesai</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Banner Turnamen (Opsional, max 2MB)</label>
                    <input type="file" name="banner" class="form-control" accept="image/jpeg,image/png,image/webp">
                    <?php if (isset($turnamen) && !empty($turnamen['banner'])): ?>
                        <div style="margin-top: 10px;">
                            <img src="<?= base_url('uploads/turnamen/' . $turnamen['banner']) ?>" alt="Banner" width="400" height="200" loading="lazy" style="max-width: 100%; height: auto; border-radius: 8px;">
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-footer-inner" style="display:flex;gap:10px">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                <a href="<?= base_url('turnamen') ?>" class="btn btn-secondary"><i class="fas fa-times"></i> Batal</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>