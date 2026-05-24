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
                <tr><th>Waktu</th><th>Turnamen</th><th>Game</th><th>Lawan</th><th>Babak</th><th>Hasil</th></tr>
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
                    <td>
                        <?php
                        if ($j['skor_tim_1'] !== null && $j['skor_tim_2'] !== null) {
                            $skor_saya = ($j['id_tim_1'] == $id_tim) ? $j['skor_tim_1'] : $j['skor_tim_2'];
                            $skor_lawan = ($j['id_tim_1'] == $id_tim) ? $j['skor_tim_2'] : $j['skor_tim_1'];
                            
                            $status = '';
                            if ($j['id_tim_pemenang'] == $id_tim) {
                                $status = '<span class="badge badge-success" style="margin-left:5px;">Menang</span>';
                            } elseif ($j['id_tim_pemenang'] != null) {
                                $status = '<span class="badge badge-danger" style="margin-left:5px;">Kalah</span>';
                            } else {
                                $status = '<span class="badge badge-warning" style="margin-left:5px;">Seri</span>';
                            }
                            
                            echo "<strong>{$skor_saya} - {$skor_lawan}</strong>" . $status;
                        } else {
                            echo '<span style="color:rgba(255,255,255,.5);">-</span>';
                        }
                        ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($jadwal)): ?>
                <tr><td colspan="6"><div class="empty-state"><i class="fas fa-calendar"></i><p>Belum ada jadwal pertandingan untuk tim Anda</p></div></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
