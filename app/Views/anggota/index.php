<?= $this->extend('layout/dashboard_layout') ?>
<?= $this->section('content') ?>

<div class="page-heading">
    <h1><i class="fas fa-id-card"></i> Daftar Anggota Tim</h1>
</div>

<div class="card">
    <div class="card-header">
        <h4>Data Anggota</h4>
        <a href="<?= base_url('anggota/tambah') ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Anggota</a>
    </div>
    <div class="card-body-inner" style="padding:0">
        <table class="tbl">
            <thead>
                <tr><th>Nickname</th><th>Tim</th><th>Peran (Role)</th><th>Peringkat</th><th style="text-align:center">Aksi</th></tr>
            </thead>
            <tbody>
                <?php foreach ($anggota as $a): ?>
                <tr>
                    <td><?= esc($a['nickname']) ?></td>
                    <td><?= esc($a['nama_tim']) ?></td>
                    <td><?= esc($a['peran']) ?></td>
                    <td><?= esc($a['peringkat_game']) ?></td>
                    <td style="text-align:center">
                        <a href="<?= base_url('anggota/edit/'.$a['id_anggota']) ?>" class="btn btn-info btn-sm" aria-label="Edit"><i class="fas fa-edit"></i></a>
                        <a href="<?= base_url('anggota/hapus/'.$a['id_anggota']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin?')" aria-label="Hapus"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($anggota)): ?>
                <tr><td colspan="5"><div class="empty-state"><i class="fas fa-id-card"></i><p>Belum ada anggota</p></div></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>