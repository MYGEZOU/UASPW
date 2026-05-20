<?= $this->extend('layout/dashboard_layout') ?>
<?= $this->section('content') ?>

<?php
$isEdit = isset($game);
$action = $isEdit ? base_url('game/update/'.$game['id_game']) : base_url('game/simpan');
?>

<div class="page-heading">
    <h1><i class="fas fa-gamepad"></i> <?= esc($title) ?></h1>
</div>

<div class="card">
    <div class="card-header">
        <h4>Form Game</h4>
        <a href="<?= base_url('game') ?>" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
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

        <form action="<?= $action ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <div class="form-group">
                <label for="nama_game">Nama Game</label>
                <input type="text" name="nama_game" id="nama_game" class="form-control" value="<?= old('nama_game', $isEdit ? $game['nama_game'] : '') ?>" required>
            </div>
            
            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4"><?= old('deskripsi', $isEdit ? $game['deskripsi'] : '') ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="logo">Logo (Opsional)</label>
                <?php if ($isEdit && $game['logo']): ?>
                    <div style="margin-bottom:10px;">
                        <img src="<?= base_url('uploads/game/'.$game['logo']) ?>" width="100" style="border-radius:5px;">
                    </div>
                <?php endif; ?>
                <input type="file" name="logo" id="logo" class="form-control" accept="image/png, image/jpeg, image/jpg, image/webp" onchange="previewImage(event)">
                <small class="form-text text-muted">Format: JPG, PNG, WEBP. Maks 2MB.</small>
                
                <div id="imagePreview" style="margin-top:10px; display:none;">
                    <img id="preview" src="#" width="100" style="border-radius:5px;">
                </div>
            </div>
            
            <div class="form-actions mt-4">
                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function(){
        var output = document.getElementById('preview');
        var previewContainer = document.getElementById('imagePreview');
        output.src = reader.result;
        previewContainer.style.display = 'block';
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>

<?= $this->endSection() ?>
