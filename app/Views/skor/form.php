<?= $this->extend('layout/dashboard_layout') ?>
<?= $this->section('content') ?>

<div class="page-heading">
    <h1><i class="fas fa-star"></i> <?= isset($skor_existing) ? 'Edit' : 'Input' ?> Skor</h1>
</div>

<div style="max-width:600px;margin:0 auto">
    <div class="card">
        <div class="card-header">
            <h4><?= isset($skor_existing) ? 'Edit' : 'Input' ?> Skor Pertandingan</h4>
        </div>
        <form action="<?= base_url('skor/simpan') ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="id_jadwal" value="<?= $jadwal['id_jadwal'] ?>">
            <div class="card-body-inner">
                <div class="alert-info-form">
                    <i class="fas fa-gamepad"></i>
                    Pertandingan: <strong><?= esc($jadwal['nama_tim_1']) ?></strong> vs <strong><?= esc($jadwal['nama_tim_2']) ?></strong>
                    <br><span style="font-size:12px;opacity:.7">Babak: <?= esc($jadwal['babak']) ?></span>
                </div>
                <div style="display:flex;gap:16px">
                    <div class="form-group" style="flex:1;text-align:center">
                        <label class="form-label"><?= esc($jadwal['nama_tim_1']) ?></label>
                        <input type="number" name="skor_tim_1" class="form-control" style="text-align:center;font-size:28px;font-weight:800;padding:16px" value="<?= old('skor_tim_1', $skor_existing['skor_tim_1'] ?? '0') ?>" required min="0">
                    </div>
                    <div style="display:flex;align-items:center;padding-top:20px;font-size:22px;color:rgba(255,255,255,.3);font-weight:800">VS</div>
                    <div class="form-group" style="flex:1;text-align:center">
                        <label class="form-label"><?= esc($jadwal['nama_tim_2']) ?></label>
                        <input type="number" name="skor_tim_2" class="form-control" style="text-align:center;font-size:28px;font-weight:800;padding:16px" value="<?= old('skor_tim_2', $skor_existing['skor_tim_2'] ?? '0') ?>" required min="0">
                    </div>
                </div>
                <div class="alert-warning-form">
                    <i class="fas fa-info-circle"></i> Tim pemenang akan ditentukan secara otomatis berdasarkan skor tertinggi.
                </div>
            </div>
            <div class="card-footer-inner" style="display:flex;gap:10px">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Skor</button>
                <a href="<?= base_url('skor') ?>" class="btn btn-secondary"><i class="fas fa-times"></i> Batal</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>