<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><h4><?= isset($turnamen) ? 'Edit' : 'Tambah' ?> Turnamen</h4></div>
            <div class="card-content">
                <form action="<?= base_url('turnamen/simpan') ?>" method="post">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Nama Turnamen</label>
                            <input type="text" name="name_tumamen" class="form-control" value="<?= isset($turnamen) ? $turnamen->name_tumamen : '' ?>" required>
                        </div>
                        <!-- field lain: game, tanggal, biaya, status -->
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>