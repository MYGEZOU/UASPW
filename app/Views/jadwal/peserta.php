<?= $this->extend('layout/dashboard_layout') ?>
<?= $this->section('content') ?>

<div class="page-heading">
    <h1><i class="fas fa-calendar-alt"></i> Jadwal Tim Saya</h1>
</div>

<div class="card">
    <div class="card-header">
        <h4>Jadwal Pertandingan</h4>
    </div>
    <div class="card-body-inner" style="padding:0">
        <table class="tbl">
            <thead>
                <tr><th>Waktu</th><th>Turnamen</th><th>Game</th><th>Lawan</th><th>Babak</th></tr>
            </thead>
            <tbody>
                <?php foreach ($jadwal as $j): ?>
                <tr>
                    <td><?= date('d M Y H:i', strtotime($j['jadwal_tanding'])) ?></td>
                    <td><?= esc($j['nama_turnamen']) ?></td>
                    <td><?= esc($j['game']) ?></td>
                    <td>
                        <?php
                        $id_tim = session()->get('id_tim');
                        $lawan = ($j['id_tim_1'] == $id_tim) ? esc($j['nama_tim_2']) : esc($j['nama_tim_1']);
                        ?>
                        <strong><?= $lawan ?></strong>
                    </td>
                    <td><span class="badge badge-info"><?= esc($j['babak']) ?></span></td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($jadwal)): ?>
                <tr><td colspan="4"><div class="empty-state"><i class="fas fa-calendar"></i><p>Belum ada jadwal pertandingan untuk tim Anda</p></div></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
