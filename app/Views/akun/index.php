<?= $this->extend('layout/dashboard_layout') ?>
<?= $this->section('content') ?>

<div class="page-heading">
    <h1><i class="fas fa-user-cog"></i> Manajemen Akun</h1>
</div>

<div class="card">
    <div class="card-header">
        <h4>Daftar Akun</h4>
        <a href="<?= base_url('akun/tambah') ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Akun</a>
    </div>
    <div class="card-body-inner" style="padding:0">
        <table class="tbl">
            <thead>
                <tr>
                    <th>Username</th><th>Email</th><th>Nama Lengkap</th><th>Peran</th><th>Tgl Dibuat</th><th style="text-align:center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($akun_list)): ?>
                    <?php foreach ($akun_list as $akun): ?>
                    <tr>
                        <td><?= esc($akun['username']) ?></td>
                        <td><?= esc($akun['email']) ?></td>
                        <td><?= esc($akun['nama_lengkap']) ?></td>
                        <td>
                            <span class="badge <?= $akun['peran']=='Admin' ? 'badge-danger' : ($akun['peran']=='AdminGame' ? 'badge-warning' : 'badge-info') ?>">
                                <?= esc($akun['peran']) ?>
                            </span>
                        </td>
                        <td><?= date('d M Y', strtotime($akun['tanggal_dibuat'])) ?></td>
                        <td style="text-align:center">
                            <a href="<?= base_url('akun/edit/'.$akun['id_akun']) ?>" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                            <a href="<?= base_url('akun/hapus/'.$akun['id_akun']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus akun ini?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6"><div class="empty-state"><i class="fas fa-users"></i><p>Belum ada data akun</p></div></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>