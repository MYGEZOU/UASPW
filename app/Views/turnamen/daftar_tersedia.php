<?= $this->extend('layout/dashboard_layout') ?>
<?= $this->section('content') ?>

<div class="page-heading">
    <h1><i class="fas fa-gamepad"></i> <?= esc($title) ?></h1>
    <?php if ($is_kapten): ?>
        <p>Sebagai <strong>Kapten Tim</strong>, Anda dapat mendaftarkan tim ke turnamen yang tersedia.</p>
    <?php else: ?>
        <p>Anda dapat melihat semua turnamen yang tersedia. Hubungi kapten tim untuk pendaftaran.</p>
    <?php endif; ?>
</div>

<style>
.tournament-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 22px;
    margin-bottom: 30px;
}
.tournament-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(0,0,0,.3);
    transition: transform .25s, box-shadow .25s;
    position: relative;
}
.tournament-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 48px rgba(0,0,0,.45);
}
.tc-banner {
    height: 130px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 52px;
    position: relative;
    overflow: hidden;
}
.tc-banner::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 50px;
    background: linear-gradient(to bottom, transparent, var(--surface));
}
.tc-banner.ml  { background: linear-gradient(135deg, #1a1a3e 0%, #0d2137 100%); }
.tc-banner.pubg{ background: linear-gradient(135deg, #2d1f0d 0%, #1a1200 100%); }
.tc-banner.ff  { background: linear-gradient(135deg, #1f2d0d 0%, #0d1a00 100%); }
.tc-banner.val { background: linear-gradient(135deg, #2d0d0d 0%, #1a0000 100%); }
.tc-banner.other{ background: linear-gradient(135deg, #1a1a2e 0%, #0d0d1a 100%); }
.tc-game-tag {
    position: absolute;
    top: 10px; left: 12px;
    background: rgba(0,0,0,.6);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,.1);
    border-radius: 20px;
    padding: 3px 10px;
    font-size: 10px;
    font-weight: 700;
    color: #fff;
    letter-spacing: .5px;
}
.tc-status-tag {
    position: absolute;
    top: 10px; right: 12px;
    background: rgba(255,171,0,.2);
    border: 1px solid rgba(255,171,0,.4);
    border-radius: 20px;
    padding: 3px 10px;
    font-size: 10px;
    font-weight: 700;
    color: #ffab00;
}
.tc-status-tag.lunas {
    background: rgba(46,213,115,.15);
    border-color: rgba(46,213,115,.35);
    color: #2ed573;
}
.tc-body { padding: 16px 18px 18px; }
.tc-name {
    font-size: 16px;
    font-weight: 800;
    color: #fff;
    margin: 0 0 12px;
    line-height: 1.3;
}
.tc-meta {
    display: flex;
    flex-direction: column;
    gap: 6px;
    margin-bottom: 16px;
}
.tc-meta-row {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    color: rgba(255,255,255,.55);
}
.tc-meta-row i {
    width: 14px;
    color: rgba(255,255,255,.3);
}
.tc-meta-row strong { color: rgba(255,255,255,.85); }
.tc-price {
    font-size: 20px;
    font-weight: 800;
    color: #4facfe;
    margin-bottom: 16px;
}
.tc-price span { font-size: 12px; color: rgba(255,255,255,.4); font-weight: 500; }
.tc-footer {
    display: flex;
    gap: 8px;
    align-items: center;
}
.tc-footer form { flex: 1; }
.tc-footer .btn { width: 100%; justify-content: center; }
.tc-registered {
    width: 100%;
    display: flex;
    flex-direction: column;
    gap: 6px;
}
</style>

<div class="tournament-grid">
    <?php if (empty($turnamen)): ?>
        <div style="grid-column: 1/-1;">
            <div class="empty-state">
                <i class="fas fa-folder-open"></i>
                <p>Tidak ada turnamen yang membuka pendaftaran saat ini.</p>
            </div>
        </div>
    <?php else: ?>
        <?php foreach ($turnamen as $t):
            $sudahDaftar = isset($pendaftaran_saya[$t['id_turnamen']]);
            $statusBayar = $sudahDaftar ? $pendaftaran_saya[$t['id_turnamen']]['status_pembayaran'] : '';
            $bannerImg = !empty($t['banner']) ? base_url('uploads/turnamen/' . $t['banner']) : base_url('uploads/turnamen/default_banner.jpg');
        ?>
        <div class="tournament-card">
            <div class="tc-banner" style="background-image: url('<?= $bannerImg ?>'); background-size: cover; background-position: center; position: relative;">
                <!-- Add a subtle dark overlay so text is readable -->
                <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.4); border-radius: inherit;"></div>
                
                <span class="tc-game-tag" style="z-index: 2;"><?= esc($t['game'] ?? 'Game') ?></span>
                <?php if ($sudahDaftar): ?>
                    <span class="tc-status-tag <?= $statusBayar === 'Lunas' ? 'lunas' : '' ?>" style="z-index: 2;">
                        <?= $statusBayar === 'Lunas' ? '✓ Terdaftar' : '⏳ Menunggu' ?>
                    </span>
                <?php else: ?>
                    <span class="tc-status-tag" style="z-index: 2;">🟢 BUKA</span>
                <?php endif; ?>
            </div>
            <div class="tc-body">
                <h3 class="tc-name"><?= esc($t['nama_turnamen']) ?></h3>
                <div class="tc-meta">
                    <div class="tc-meta-row">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Mulai: <strong><?= date('d M Y', strtotime($t['tanggal_mulai'])) ?></strong></span>
                    </div>
                    <div class="tc-meta-row">
                        <i class="fas fa-gamepad"></i>
                        <span>Game: <strong><?= esc($t['game'] ?? '-') ?></strong></span>
                    </div>
                </div>
                <div class="tc-price">
                    Rp <?= number_format($t['biaya_pendaftaran'], 0, ',', '.') ?>
                    <span>/ tim</span>
                </div>
                <div class="tc-footer" style="flex-wrap: wrap;">
                    <a href="<?= base_url('turnamen/detail/' . $t['id_turnamen']) ?>" class="btn btn-secondary" style="flex: 1; min-width: 45%; display: flex; align-items: center; justify-content: center;"><i class="fas fa-info-circle" style="margin-right:5px"></i> Detail</a>
                    <?php if ($sudahDaftar): ?>
                        <div class="tc-registered">
                            <?php if ($statusBayar === 'Menunggu'): ?>
                                <?php if ($is_kapten): ?>
                                    <a href="<?= base_url('pembayaran/upload/' . $pendaftaran_saya[$t['id_turnamen']]['id_daftar']) ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-upload"></i> Upload Bukti Bayar
                                    </a>
                                <?php endif; ?>
                                <span style="font-size:11px;color:rgba(255,255,255,.4);text-align:center">⏳ Menunggu konfirmasi admin</span>
                            <?php else: ?>
                                <div class="btn btn-success btn-sm" style="pointer-events:none">
                                    <i class="fas fa-check-circle"></i> Sudah Terdaftar & Lunas
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php elseif ($is_kapten): ?>
                        <form action="<?= base_url('turnamen/daftar/' . $t['id_turnamen']) ?>" method="post" onsubmit="return confirm('Apakah Anda yakin ingin mendaftar ke turnamen <?= addslashes(esc($t['nama_turnamen'])) ?>?')">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt"></i> Daftar Sekarang
                            </button>
                        </form>
                    <?php else: ?>
                        <div style="width:100%;text-align:center;padding:6px 0;">
                            <span style="font-size:11px;color:rgba(255,255,255,.3);"><i class="fas fa-lock" style="margin-right:4px;"></i>Hanya kapten tim yang dapat mendaftar</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
