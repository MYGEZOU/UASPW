<?= $this->extend('layout/dashboard_layout') ?>
<?= $this->section('content') ?>

<div class="page-heading">
    <h1><i class="fas fa-star"></i> Skor Pertandingan</h1>
</div>

<div class="card">
    <div class="card-header">
        <h4>Data Skor</h4>
    </div>
    <div class="card-body-inner" style="padding:0">
        <table class="tbl">
            <thead>
                <tr><th>Turnamen</th><th>Tim 1</th><th>Skor 1</th><th>Skor 2</th><th>Tim 2</th><th>Pemenang</th><th style="text-align:center">Aksi</th></tr>
            </thead>
            <tbody>
                <?php foreach ($skor as $s): ?>
                <tr>
                    <td><?= esc($s['nama_turnamen']) ?></td>
                    <td><?= esc($s['nama_tim_1']) ?></td>
                    <td style="font-weight:800;color:#FF4B2B"><?= $s['skor_tim_1'] ?></td>
                    <td style="font-weight:800;color:#FF4B2B"><?= $s['skor_tim_2'] ?></td>
                    <td><?= esc($s['nama_tim_2']) ?></td>
                    <td><span class="badge badge-success"><?= esc($s['pemenang']) ?></span></td>
                    <td style="text-align:center">
                        <a href="<?= base_url('skor/edit/'.$s['id_skor']) ?>" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                        <a href="<?= base_url('skor/hapus/'.$s['id_skor']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin?')"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($skor)): ?>
                <tr><td colspan="7"><div class="empty-state"><i class="fas fa-star"></i><p>Belum ada skor</p></div></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>