<?= $this->extend('layout/dashboard_layout') ?>
<?= $this->section('content') ?>

<?php $peran = session('peran'); ?>

<div class="page-heading">
    <h1><i class="fas fa-info-circle"></i> Detail Turnamen</h1>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4><?= esc($turnamen['nama_turnamen']) ?></h4>
        <?php if (in_array($peran, ['Admin', 'AdminGame'])): ?>
            <a href="<?= base_url('turnamen/edit/' . $turnamen['id_turnamen']) ?>" class="btn btn-info btn-sm"><i class="fas fa-edit"></i> Edit Turnamen</a>
        <?php endif; ?>
    </div>
    <div class="card-body" style="padding: 25px;">
        <div style="display: flex; flex-wrap: wrap; gap: 30px;">
            <div style="flex: 1; min-width: 300px; text-align: center;">
                <?php $bannerImg = !empty($turnamen['banner']) ? base_url('uploads/turnamen/' . $turnamen['banner']) : base_url('uploads/turnamen/default_banner.jpg'); ?>
                <img src="<?= $bannerImg ?>" alt="Banner" style="box-shadow: 0 4px 20px rgba(0,0,0,0.4); max-height: 350px; object-fit: cover; width: 100%; border-radius: 12px; border: 1px solid rgba(255,255,255,0.1);">
            </div>
            <div style="flex: 1.5; min-width: 300px;">
                <table style="width: 100%; border-collapse: separate; border-spacing: 0 12px;">
                    <tr>
                        <th style="width: 160px; color: rgba(255,255,255,0.7); text-align: left; vertical-align: middle;"><i class="fas fa-gamepad" style="width: 20px;"></i> Game</th>
                        <td style="font-size: 16px;"><strong><?= esc($turnamen['game'] ?? '-') ?></strong></td>
                    </tr>
                    <tr>
                        <th style="color: rgba(255,255,255,0.7); text-align: left; vertical-align: middle;"><i class="fas fa-calendar-alt" style="width: 20px;"></i> Tanggal Mulai</th>
                        <td style="font-size: 16px;"><strong><?= date('d M Y', strtotime($turnamen['tanggal_mulai'])) ?></strong></td>
                    </tr>
                    <tr>
                        <th style="color: rgba(255,255,255,0.7); text-align: left; vertical-align: middle;"><i class="fas fa-money-bill-wave" style="width: 20px;"></i> Biaya</th>
                        <td style="font-size: 18px;"><strong style="color: #4facfe;">Rp <?= number_format($turnamen['biaya_pendaftaran'], 0, ',', '.') ?></strong></td>
                    </tr>
                    <tr>
                        <th style="color: rgba(255,255,255,0.7); text-align: left; vertical-align: middle;"><i class="fas fa-info-circle" style="width: 20px;"></i> Status</th>
                        <td>
                            <span class="badge <?= $turnamen['status']=='Pendaftaran' ? 'badge-warning' : ($turnamen['status']=='Berlangsung' ? 'badge-info' : 'badge-success') ?>" style="font-size: 14px; padding: 6px 12px;">
                                <?= esc($turnamen['status']) ?>
                            </span>
                        </td>
                    </tr>
                </table>

                <div style="margin-top: 30px;">
                    <h5 style="color: rgba(255,255,255,0.8); margin-bottom: 12px;"><i class="fas fa-align-left" style="margin-right: 8px;"></i> Deskripsi Turnamen</h5>
                    <div style="background: rgba(0,0,0,0.25); border: 1px solid rgba(255,255,255,0.08); padding: 18px; border-radius: 12px; min-height: 120px; color: rgba(255,255,255,0.9); line-height: 1.6;">
                        <?php if(!empty($turnamen['deskripsi'])): ?>
                            <?= nl2br(esc($turnamen['deskripsi'])) ?>
                        <?php else: ?>
                            <em style="color: rgba(255,255,255,0.4);">Tidak ada deskripsi tersedia.</em>
                        <?php endif; ?>
                    </div>
                </div>

                <div style="margin-top: 30px; display: flex; gap: 15px;">
                    <?php if ($peran === 'Peserta'): ?>
                        <a href="<?= base_url('turnamen/daftar-tersedia') ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
                    <?php else: ?>
                        <a href="<?= base_url('turnamen') ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
