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
                    <?php if ($s['id_skor']): ?>
                        <td style="font-weight:800;color:#FF4B2B"><?= $s['skor_tim_1'] ?></td>
                        <td style="font-weight:800;color:#FF4B2B"><?= $s['skor_tim_2'] ?></td>
                        <td><?= esc($s['nama_tim_2']) ?></td>
                        <td><span class="badge badge-success"><?= esc($s['pemenang'] ?: 'Seri') ?></span></td>
                        <td style="text-align:center">
                            <a href="<?= base_url('skor/input/'.$s['id_jadwal']) ?>" class="btn btn-info btn-sm" title="Edit Skor"><i class="fas fa-edit"></i> Edit</a>
                        </td>
                    <?php else: ?>
                        <td style="color:rgba(255,255,255,0.2)">-</td>
                        <td style="color:rgba(255,255,255,0.2)">-</td>
                        <td><?= esc($s['nama_tim_2']) ?></td>
                        <td><span class="badge badge-secondary">Belum Main</span></td>
                        <td style="text-align:center">
                            <a href="<?= base_url('skor/input/'.$s['id_jadwal']) ?>" class="btn btn-primary btn-sm" title="Input Skor"><i class="fas fa-star"></i> Input</a>
                        </td>
                    <?php endif; ?>
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