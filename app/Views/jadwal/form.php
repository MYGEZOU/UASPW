<?= $this->extend('layout/dashboard_layout') ?>
<?= $this->section('content') ?>

<div class="page-heading">
    <h1><i class="fas fa-calendar-alt"></i> <?= isset($jadwal) ? 'Edit' : 'Tambah' ?> Jadwal</h1>
</div>

<div style="max-width:640px;margin:0 auto">
    <div class="card">
        <div class="card-header">
            <h4><?= isset($jadwal) ? 'Edit' : 'Tambah' ?> Jadwal Pertandingan</h4>
        </div>
        
        <div class="card-body">
            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger" style="margin-bottom: 20px;">
                    <ul style="margin:0; padding-left: 20px;">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <form action="<?= base_url(isset($jadwal) ? 'jadwal/update/'.$jadwal['id_jadwal'] : 'jadwal/simpan') ?>" method="post" id="formJadwal" onsubmit="return validateForm()">
                <?= csrf_field() ?>
                <div class="card-body-inner">
                    <div class="form-group">
                        <label class="form-label">Turnamen</label>
                        <select name="id_turnamen" class="form-control" required>
                            <option value="">-- Pilih Turnamen --</option>
                            <?php foreach ($turnamen as $t): ?>
                            <option value="<?= $t['id_turnamen'] ?>" <?= (old('id_turnamen', $jadwal['id_turnamen'] ?? '') == $t['id_turnamen']) ? 'selected' : '' ?>>
                                <?= esc($t['nama_turnamen']) ?> (<?= esc($t['game_nama'] ?? 'Tanpa Game') ?>) - <?= esc($t['status']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tim 1</label>
                        <select name="id_tim_1" id="id_tim_1" class="form-control" required>
                            <option value="">-- Pilih Tim --</option>
                            <?php foreach ($tim as $t1): ?>
                            <option value="<?= $t1['id_tim'] ?>" <?= (old('id_tim_1', $jadwal['id_tim_1'] ?? '') == $t1['id_tim']) ? 'selected' : '' ?>><?= esc($t1['nama_tim']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tim 2</label>
                        <select name="id_tim_2" id="id_tim_2" class="form-control" required>
                            <option value="">-- Pilih Tim --</option>
                            <?php foreach ($tim as $t2): ?>
                            <option value="<?= $t2['id_tim'] ?>" <?= (old('id_tim_2', $jadwal['id_tim_2'] ?? '') == $t2['id_tim']) ? 'selected' : '' ?>><?= esc($t2['nama_tim']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <small id="errorTim" class="text-danger" style="display:none;">Tim 1 dan Tim 2 tidak boleh sama!</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal &amp; Waktu</label>
                        <input type="datetime-local" name="jadwal_tanding" class="form-control" value="<?= old('jadwal_tanding', isset($jadwal) ? date('Y-m-d\TH:i', strtotime($jadwal['jadwal_tanding'])) : '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Babak</label>
                        <input type="text" name="babak" class="form-control" value="<?= old('babak', $jadwal['babak'] ?? '') ?>" placeholder="Contoh: Grup A, Semi Final, Final" required>
                    </div>
                </div>
                <div class="card-footer-inner" style="display:flex;gap:10px">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                    <a href="<?= base_url('jadwal') ?>" class="btn btn-secondary"><i class="fas fa-times"></i> Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function validateForm() {
    var tim1 = document.getElementById('id_tim_1').value;
    var tim2 = document.getElementById('id_tim_2').value;
    var errorLabel = document.getElementById('errorTim');
    
    if (tim1 !== "" && tim1 === tim2) {
        errorLabel.style.display = 'block';
        return false;
    }
    
    errorLabel.style.display = 'none';
    return true;
}

// Optional real-time checking
document.getElementById('id_tim_1').addEventListener('change', checkDuplicate);
document.getElementById('id_tim_2').addEventListener('change', checkDuplicate);

function checkDuplicate() {
    var tim1 = document.getElementById('id_tim_1').value;
    var tim2 = document.getElementById('id_tim_2').value;
    var errorLabel = document.getElementById('errorTim');
    
    if (tim1 !== "" && tim2 !== "" && tim1 === tim2) {
        errorLabel.style.display = 'block';
    } else {
        errorLabel.style.display = 'none';
    }
}
</script>

<?= $this->endSection() ?>