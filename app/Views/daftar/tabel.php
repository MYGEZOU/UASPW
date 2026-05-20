<table class="tbl">
    <thead>
        <tr>
            <th>Turnamen</th><th>Tim</th><th>Tanggal Daftar</th><th>Status Bayar</th><th style="text-align:center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($daftar_list as $d): ?>
        <tr>
            <td><?= esc($d['nama_turnamen']) ?></td>
            <td><?= esc($d['nama_tim']) ?></td>
            <td><?= date('d M Y', strtotime($d['tanggal_daftar'])) ?></td>
            <td><span class="badge <?= $d['status_pembayaran'] == 'Lunas' ? 'badge-success' : 'badge-warning' ?>"><?= esc($d['status_pembayaran']) ?></span></td>
            <td style="text-align:center">
                <?php if ($d['status_pembayaran'] != 'Lunas'): ?>
                <a href="<?= base_url('daftar/ubah-status/'.$d['id_daftar']) ?>" class="btn btn-success btn-sm">Tandai Lunas</a>
                <?php else: ?>
                <a href="<?= base_url('daftar/ubah-status/'.$d['id_daftar']) ?>" class="btn btn-warning btn-sm">Batalkan Lunas</a>
                <?php endif; ?>
                <a href="<?= base_url('daftar/hapus/'.$d['id_daftar']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus pendaftaran ini?')"><i class="fas fa-trash"></i></a>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($daftar_list)): ?>
        <tr><td colspan="5" style="text-align:center;padding:24px;color:rgba(255,255,255,.3)">Tidak ada data</td></tr>
        <?php endif; ?>
    </tbody>
</table>