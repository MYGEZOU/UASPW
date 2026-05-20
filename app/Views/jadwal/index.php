<?= $this->extend('layout/dashboard_layout') ?>
<?= $this->section('content') ?>

<div class="page-heading">
    <h1><i class="fas fa-calendar-alt"></i> Jadwal Pertandingan</h1>
</div>

<div class="card">
    <div class="card-header">
        <h4>Data Jadwal</h4>
        <a href="<?= base_url('jadwal/tambah') ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Jadwal</a>
    </div>
    <div class="card-body-inner" style="padding:0">
        <table class="tbl">
            <thead>
                <tr><th>Turnamen</th><th>Game</th><th>Tim 1</th><th>Tim 2</th><th>Waktu</th><th>Babak</th><th style="text-align:center">Aksi</th></tr>
            </thead>
            <tbody>
                <?php foreach ($jadwal as $j): ?>
                <tr>
                    <td><?= esc($j['nama_turnamen']) ?></td>
                    <td><?= esc($j['game']) ?></td>
                    <td><?= esc($j['nama_tim_1']) ?></td>
                    <td><?= esc($j['nama_tim_2']) ?></td>
                    <td><?= date('d M H:i', strtotime($j['jadwal_tanding'])) ?></td>
                    <td><span class="badge badge-info"><?= esc($j['babak']) ?></span></td>
                    <td style="text-align:center">
                        <a href="<?= base_url('jadwal/edit/'.$j['id_jadwal']) ?>" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                        <a href="<?= base_url('jadwal/hapus/'.$j['id_jadwal']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin?')"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($jadwal)): ?>
                <tr><td colspan="6"><div class="empty-state"><i class="fas fa-calendar"></i><p>Belum ada jadwal</p></div></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>