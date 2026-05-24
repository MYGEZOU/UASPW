<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? esc($title).' — E-Sports Tournament' : 'Dashboard — E-Sports Tournament' ?></title>
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?= isset($title) ? esc($title).' — E-Sports Tournament' : 'E-Sports Tournament Management' ?>">
    <meta property="og:description" content="Platform manajemen turnamen E-Sports terpercaya. Daftar tim, ikuti turnamen, dan raih kemenanganmu!">
    <meta property="og:image" content="<?= base_url('assets/img/og-banner.jpg') ?>">
    <meta property="og:url" content="<?= current_url() ?>">
    <meta property="og:type" content="website">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700;800&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700;800&display=swap" rel="stylesheet"></noscript>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="<?= base_url('assets/css/custom.css') ?>">
</head>
<body class="dashboard-body">
<!-- Toast Container -->
<div id="custom-toast-container" class="custom-toast-container"></div>

<!-- Particles -->
<div class="particles">
    <span></span><span></span><span></span><span></span>
</div>

<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon"><i class="fas fa-trophy"></i></div>
        <div>
            <div class="brand-text">E-Sports</div>
            <div class="brand-sub">Tournament System</div>
        </div>
    </div>
    <nav class="sidebar-nav" id="sidebarNav">
        <?php
        $peran = session('peran');
        $cur = current_url();

        function navLink($href, $icon, $label, $cur) {
            $active = (strpos($cur, base_url($href)) !== false && $href !== '#') ? 'active' : '';
            echo '<a class="nav-link '.$active.'" href="'.base_url($href).'"><i class="fas '.$icon.'"></i> '.$label.'</a>';
        }

        function navDropdown($id, $icon, $label, $links, $cur) {
            // Check if any child link is active
            $isOpen = false;
            foreach($links as $link) {
                if (strpos($cur, base_url($link['href'])) !== false && $link['href'] !== '#') {
                    $isOpen = true;
                    break;
                }
            }
            $openClass = $isOpen ? 'open' : '';
            
            echo '<div class="nav-item '.$openClass.'" id="'.$id.'">
                    <a class="nav-link" href="#" onclick="toggleNav(\''.$id.'\');return false;">
                        <i class="fas '.$icon.'"></i> '.$label.' <i class="fas fa-chevron-right nav-arrow"></i>
                    </a>
                    <div class="nav-sub">';
            foreach($links as $link) {
                navLink($link['href'], '', $link['label'], $cur);
            }
            echo '  </div>
                  </div>';
        }

        if ($peran === 'Admin'):
        ?>
        <div class="nav-section-title">Main</div>
        <?php navLink('dashboard','fa-home','Dashboard',$cur); ?>
        
        <div class="nav-section-title">Master Data</div>
        <?php 
            navDropdown('ni-turnamen', 'fa-trophy', 'Turnamen', [
                ['href' => 'turnamen', 'label' => 'Data Turnamen'],
                ['href' => 'game', 'label' => 'Master Game']
            ], $cur);
            
            navDropdown('ni-tim', 'fa-users', 'Tim & Anggota', [
                ['href' => 'tim', 'label' => 'Data Tim'],
                ['href' => 'anggota', 'label' => 'Data Anggota']
            ], $cur);
        ?>
        <?php navLink('akun','fa-user-cog','Manajemen Akun',$cur); ?>
        
        <div class="nav-section-title">Transaksi</div>
        <?php navLink('daftar','fa-clipboard-list','Pendaftaran',$cur); ?>
        <?php navLink('pembayaran/menunggu','fa-clock','Konfirmasi Bayar',$cur); ?>
        <?php navLink('pembayaran/riwayat','fa-history','Riwayat Lunas',$cur); ?>
        
        <div class="nav-section-title">Pertandingan</div>
        <?php navLink('jadwal','fa-calendar-alt','Jadwal',$cur); ?>
        <?php navLink('skor','fa-star','Input Skor',$cur); ?>

        <?php elseif ($peran === 'AdminGame'): ?>
        <div class="nav-section-title">Main</div>
        <?php navLink('dashboard','fa-home','Dashboard',$cur); ?>
        
        <div class="nav-section-title">Master Data</div>
        <?php 
            navDropdown('ni-turnamen', 'fa-trophy', 'Turnamen', [
                ['href' => 'turnamen', 'label' => 'Data Turnamen'],
                ['href' => 'game', 'label' => 'Master Game']
            ], $cur);
            
            navDropdown('ni-tim', 'fa-users', 'Tim & Anggota', [
                ['href' => 'tim', 'label' => 'Data Tim']
            ], $cur);
        ?>

        <div class="nav-section-title">Transaksi</div>
        <?php navLink('daftar','fa-clipboard-list','Pendaftaran',$cur); ?>
        <?php navLink('pembayaran/menunggu','fa-clock','Konfirmasi Bayar',$cur); ?>
        <?php navLink('pembayaran/riwayat','fa-history','Riwayat Lunas',$cur); ?>
        
        <div class="nav-section-title">Pertandingan</div>
        <?php navLink('jadwal','fa-calendar-alt','Jadwal',$cur); ?>
        <?php navLink('skor','fa-star','Input Skor',$cur); ?>

        <?php elseif ($peran === 'Peserta'): ?>
        <div class="nav-section-title">Main</div>
        <?php navLink('dashboard','fa-home','Dashboard',$cur); ?>
        <div class="nav-section-title">Saya</div>
        <?php navLink('tim/profil','fa-users','Tim Saya',$cur); ?>
        
        <?php 
            navDropdown('ni-peserta-turnamen', 'fa-trophy', 'Turnamen', [
                ['href' => 'turnamen/daftar-tersedia', 'label' => 'Daftar Turnamen'],
                ['href' => 'turnamen/peserta', 'label' => 'Turnamen Saya']
            ], $cur);
        ?>
        
        <?php navLink('pembayaran/saya','fa-file-invoice-dollar','Tagihan & Riwayat',$cur); ?>
        <?php navLink('jadwal/saya','fa-calendar-alt','Jadwal & Skor',$cur); ?>
        <?php endif; ?>
    </nav>
    <div class="sidebar-footer">
        <a href="<?= base_url('profil') ?>" class="user-info" style="text-decoration:none; display:flex; align-items:center; gap:10px; margin-bottom:12px; padding:8px; border-radius:8px; transition:background .2s;" onmouseover="this.style.background='rgba(255,255,255,.05)'" onmouseout="this.style.background='none'">
            <div class="user-avatar"><i class="fas fa-user"></i></div>
            <div style="flex:1; min-width:0;">
                <div class="user-name"><?= esc(session('nama_lengkap') ?? 'User') ?></div>
                <div class="user-role"><?= esc(session('peran') ?? '') ?> · <span style="color:rgba(255,75,43,.7)">Edit Profil</span></div>
            </div>
            <i class="fas fa-chevron-right" style="font-size:10px; color:rgba(255,255,255,.2);"></i>
        </a>
        <a href="<?= base_url('auth/logout') ?>" class="btn-logout">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>
</aside>

<!-- Main -->
<div class="main-wrapper" id="mainWrapper">
    <header class="topbar">
        <div class="topbar-left">
            <button class="btn-toggle" id="toggleBtn" onclick="toggleSidebar()" aria-label="Toggle Sidebar">
                <i class="fas fa-bars"></i>
            </button>
            <span class="topbar-title"><?= isset($title) ? esc($title) : 'Dashboard' ?></span>
        </div>
        <div class="topbar-right">
            <a href="<?= base_url('profil') ?>" style="display:flex;align-items:center;gap:8px;text-decoration:none;background:rgba(255,255,255,.06);border:1px solid var(--border);border-radius:20px;padding:5px 14px 5px 8px;transition:background .2s;" onmouseover="this.style.background='rgba(255,255,255,.1)'" onmouseout="this.style.background='rgba(255,255,255,.06)'">
                <div style="width:26px;height:26px;border-radius:50%;background:linear-gradient(135deg,var(--accent),var(--accent2));display:flex;align-items:center;justify-content:center;font-size:11px;"><i class="fas fa-user"></i></div>
                <span style="font-size:12px;color:rgba(255,255,255,.7);"><?= esc(session('nama_lengkap') ?? '') ?></span>
            </a>
        </div>
    </header>

    <div class="content-area">
        <?= $this->renderSection('content') ?>
    </div>

    <footer class="main-footer">
        &copy; <?= date('Y') ?> E-Sports Tournament System — All rights reserved
    </footer>
</div>

<script src="<?= base_url('assets/js/main.js') ?>" defer></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
<?php if (session()->getFlashdata('success')): ?>
showMinimalToast('success', '<?= addslashes(session()->getFlashdata('success')) ?>');
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
showMinimalToast('error', '<?= addslashes(session()->getFlashdata('error')) ?>');
<?php endif; ?>

<?php if (session()->getFlashdata('info')): ?>
showMinimalToast('info', '<?= addslashes(session()->getFlashdata('info')) ?>');
<?php endif; ?>
});
</script>
</body>
</html>
