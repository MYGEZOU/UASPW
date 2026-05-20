<?= $this->extend('layout/dashboard_layout') ?>
<?= $this->section('content') ?>

<div class="page-heading">
    <h1><i class="fas fa-gamepad"></i> Master Game</h1>
</div>

<div class="card">
    <div class="card-header">
        <h4>Data Game</h4>
        <a href="<?= base_url('game/tambah') ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Game</a>
    </div>
    <div class="card-body-inner" style="padding:0">
        <table class="tbl">
            <thead>
                <tr>

                    <th>Nama Game</th>
                    <th>Slug</th>
                    <th>Deskripsi</th>
                    <th style="text-align:center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($games as $g): ?>
                <tr>

                    <td><strong><?= esc($g['nama_game']) ?></strong></td>
                    <td><?= esc($g['slug']) ?></td>
                    <td><?= esc(substr($g['deskripsi'] ?? '', 0, 50)) ?><?= (strlen($g['deskripsi'] ?? '') > 50) ? '...' : '' ?></td>
                    <td style="text-align:center">
                        <a href="<?= base_url('game/edit/'.$g['id_game']) ?>" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                        <a href="<?= base_url('game/hapus/'.$g['id_game']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus game ini?')"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($games)): ?>
                <tr>
                    <td colspan="4">
                        <div class="empty-state"><i class="fas fa-gamepad"></i><p>Belum ada data game</p></div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
