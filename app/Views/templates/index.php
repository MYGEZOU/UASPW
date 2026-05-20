<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Data Turnamen</h4>
                <a href="<?= base_url('turnamen/tambah') ?>" class="btn btn-primary btn-sm float-right">Tambah</a>
            </div>
            <div class="card-content">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Game</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($turnamen_list as $t): ?>
                            <tr>
                                <td><?= $t->name_tumamen ?></td>
                                <td><?= $t->game ?></td>
                                <td><?= $t->status ?></td>
                                <td>
                                    <a href="<?= base_url('turnamen/edit/'.$t->id_tumamen) ?>" class="btn btn-sm btn-info">Edit</a>
                                    <a href="<?= base_url('turnamen/hapus/'.$t->id_tumamen) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin?')">Hapus</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>