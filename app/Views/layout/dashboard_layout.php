<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? esc($title).' — E-Sports Tournament' : 'Dashboard — E-Sports Tournament' ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
        :root{
            --bg:#0d0d1a;--surface:#16213e;--surface2:#1a1a2e;
            --accent:#FF4B2B;--accent2:#FF416C;
            --purple:rgba(120,50,255,.18);--text:#fff;
            --text-muted:rgba(255,255,255,.5);--border:rgba(255,255,255,.07);
            --sidebar-w:260px;
        }
        body{
            background:var(--bg);
            background-image:
                radial-gradient(ellipse at 10% 50%,var(--purple) 0%,transparent 55%),
                radial-gradient(ellipse at 90% 10%,rgba(255,75,43,.12) 0%,transparent 55%);
            font-family:'Montserrat',sans-serif;
            color:var(--text);
            min-height:100vh;
            display:flex;
        }
        /* particles */
        .particles{position:fixed;inset:0;pointer-events:none;z-index:0;}
        .particles span{position:absolute;display:block;border-radius:50%;background:rgba(255,75,43,.07);animation:float linear infinite;}
        .particles span:nth-child(1){width:70px;height:70px;left:5%;animation-duration:22s;}
        .particles span:nth-child(2){width:20px;height:20px;left:40%;animation-duration:14s;animation-delay:4s;background:rgba(120,50,255,.08);}
        .particles span:nth-child(3){width:50px;height:50px;left:75%;animation-duration:18s;animation-delay:2s;}
        .particles span:nth-child(4){width:12px;height:12px;left:90%;animation-duration:11s;animation-delay:6s;background:rgba(120,50,255,.10);}
        @keyframes float{
            0%{transform:translateY(110vh) scale(0);opacity:0;}
            10%{opacity:.8;}90%{opacity:.8;}
            100%{transform:translateY(-10vh) scale(1);opacity:0;}
        }
        /* ── SIDEBAR ── */
        .sidebar{
            position:fixed;left:0;top:0;bottom:0;
            width:var(--sidebar-w);
            background:var(--surface2);
            border-right:1px solid var(--border);
            z-index:100;
            display:flex;flex-direction:column;
            transition:transform .3s ease;
            box-shadow:4px 0 30px rgba(0,0,0,.4);
        }
        .sidebar.collapsed{transform:translateX(calc(-1 * var(--sidebar-w)));}
        .sidebar-brand{
            padding:24px 20px;
            border-bottom:1px solid var(--border);
            display:flex;align-items:center;gap:12px;
        }
        .sidebar-brand .brand-icon{
            width:40px;height:40px;border-radius:10px;
            background:linear-gradient(135deg,var(--accent),var(--accent2));
            display:flex;align-items:center;justify-content:center;
            font-size:18px;flex-shrink:0;
            box-shadow:0 4px 15px rgba(255,75,43,.35);
        }
        .sidebar-brand .brand-text{font-size:13px;font-weight:800;letter-spacing:.5px;color:#fff;}
        .sidebar-brand .brand-sub{font-size:10px;color:var(--text-muted);margin-top:2px;}
        .sidebar-nav{flex:1;padding:16px 0;overflow-y:auto;}
        .sidebar-nav::-webkit-scrollbar{width:3px;}
        .sidebar-nav::-webkit-scrollbar-thumb{background:var(--border);border-radius:2px;}
        .nav-section-title{
            font-size:9px;font-weight:700;letter-spacing:2px;text-transform:uppercase;
            color:rgba(255,255,255,.25);padding:12px 20px 6px;
        }
        .nav-item{display:block;position:relative;}
        .nav-link{
            display:flex;align-items:center;gap:12px;
            padding:11px 20px;
            color:rgba(255,255,255,.55);
            text-decoration:none;
            font-size:13px;font-weight:500;
            border-radius:0;
            transition:color .2s,background .2s;
            border-left:3px solid transparent;
        }
        .nav-link:hover{color:#fff;background:rgba(255,255,255,.05);}
        .nav-link.active{
            color:#fff;
            background:rgba(255,75,43,.12);
            border-left-color:var(--accent);
        }
        .nav-link i{width:18px;text-align:center;font-size:14px;}
        .nav-link .nav-arrow{margin-left:auto;font-size:10px;transition:transform .2s;}
        .nav-item.open .nav-arrow{transform:rotate(90deg);}
        .nav-sub{display:none;background:rgba(0,0,0,.15);}
        .nav-item.open .nav-sub{display:block;}
        .nav-sub .nav-link{
            padding:9px 20px 9px 50px;
            font-size:12px;border-left:none;
        }
        .nav-sub .nav-link.active{background:rgba(255,75,43,.08);color:var(--accent);}
        .sidebar-footer{
            padding:16px 20px;
            border-top:1px solid var(--border);
        }
        .user-info{display:flex;align-items:center;gap:10px;margin-bottom:12px;}
        .user-avatar{
            width:36px;height:36px;border-radius:50%;
            background:linear-gradient(135deg,var(--accent),var(--accent2));
            display:flex;align-items:center;justify-content:center;
            font-size:14px;flex-shrink:0;
        }
        .user-name{font-size:12px;font-weight:700;color:#fff;}
        .user-role{font-size:10px;color:var(--text-muted);}
        .btn-logout{
            display:flex;align-items:center;justify-content:center;gap:8px;
            width:100%;padding:9px;
            background:rgba(255,75,43,.1);
            border:1px solid rgba(255,75,43,.2);
            border-radius:8px;
            color:rgba(255,75,43,.8);
            text-decoration:none;
            font-size:12px;font-weight:600;
            transition:all .2s;
        }
        .btn-logout:hover{background:rgba(255,75,43,.2);color:var(--accent);}
        /* ── MAIN ── */
        .main-wrapper{
            margin-left:var(--sidebar-w);
            flex:1;display:flex;flex-direction:column;
            min-height:100vh;
            position:relative;z-index:1;
            transition:margin .3s;
        }
        .main-wrapper.expanded{margin-left:0;}
        /* topbar */
        .topbar{
            background:rgba(26,26,46,.85);
            backdrop-filter:blur(12px);
            border-bottom:1px solid var(--border);
            padding:0 28px;
            height:62px;
            display:flex;align-items:center;
            justify-content:space-between;
            position:sticky;top:0;z-index:50;
        }
        .topbar-left{display:flex;align-items:center;gap:16px;}
        .btn-toggle{
            background:rgba(255,255,255,.06);border:1px solid var(--border);
            border-radius:8px;width:36px;height:36px;
            display:flex;align-items:center;justify-content:center;
            color:var(--text-muted);cursor:pointer;
            transition:all .2s;
        }
        .btn-toggle:hover{background:rgba(255,255,255,.1);color:#fff;}
        .topbar-title{font-size:15px;font-weight:700;color:#fff;}
        .topbar-right{display:flex;align-items:center;gap:12px;}
        .topbar-user{font-size:12px;color:var(--text-muted);}
        .topbar-user span{color:#fff;font-weight:700;}
        /* content */
        .content-area{flex:1;padding:28px;max-width:1400px;width:100%;}
        /* flash */
        .flash-msg{
            padding:12px 18px;border-radius:10px;
            font-size:13px;font-weight:600;margin-bottom:20px;
            display:flex;align-items:center;gap:10px;
        }
        .flash-msg.error{background:rgba(255,75,43,.15);color:#FF4B2B;border:1px solid rgba(255,75,43,.3);}
        .flash-msg.success{background:rgba(46,213,115,.12);color:#2ed573;border:1px solid rgba(46,213,115,.3);}
        .flash-msg.info{background:rgba(83,131,254,.12);color:#5383fe;border:1px solid rgba(83,131,254,.3);}
        /* cards */
        .card{
            background:var(--surface);
            border:1px solid var(--border);
            border-radius:14px;
            overflow:hidden;
            box-shadow:0 8px 32px rgba(0,0,0,.25);
            margin-bottom:24px;
        }
        .card-header{
            padding:18px 22px;
            border-bottom:1px solid var(--border);
            display:flex;align-items:center;justify-content:space-between;
            background:rgba(255,255,255,.02);
        }
        .card-header h4,.card-title{
            font-size:15px;font-weight:700;color:#fff;margin:0;
        }
        .card-body-inner{padding:22px;}
        .card-footer-inner{
            padding:16px 22px;
            border-top:1px solid var(--border);
            background:rgba(255,255,255,.02);
        }
        /* stat cards */
        .stat-card{
            background:var(--surface);
            border:1px solid var(--border);
            border-radius:14px;padding:22px;
            display:flex;align-items:center;gap:16px;
            box-shadow:0 8px 32px rgba(0,0,0,.25);
            transition:transform .2s,box-shadow .2s;
            margin-bottom:24px;
        }
        .stat-card:hover{transform:translateY(-3px);box-shadow:0 12px 40px rgba(0,0,0,.35);}
        .stat-icon{
            width:54px;height:54px;border-radius:12px;
            display:flex;align-items:center;justify-content:center;
            font-size:22px;flex-shrink:0;
        }
        .stat-icon.orange{background:rgba(255,75,43,.15);color:var(--accent);}
        .stat-icon.green{background:rgba(46,213,115,.12);color:#2ed573;}
        .stat-icon.blue{background:rgba(83,131,254,.12);color:#5383fe;}
        .stat-icon.purple{background:rgba(120,50,255,.12);color:#a855f7;}
        .stat-label{font-size:11px;color:var(--text-muted);font-weight:600;text-transform:uppercase;letter-spacing:.5px;}
        .stat-value{font-size:26px;font-weight:800;color:#fff;margin-top:2px;}
        /* table */
        .tbl{width:100%;border-collapse:collapse;}
        .tbl thead tr{border-bottom:1px solid var(--border);}
        .tbl th{
            padding:12px 14px;font-size:11px;font-weight:700;
            color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;
            text-align:left;
        }
        .tbl td{
            padding:13px 14px;font-size:13px;color:rgba(255,255,255,.8);
            border-bottom:1px solid rgba(255,255,255,.04);
        }
        .tbl tbody tr:hover{background:rgba(255,255,255,.03);}
        .tbl tbody tr:last-child td{border-bottom:none;}
        /* badges */
        .badge{
            display:inline-flex;align-items:center;
            padding:3px 10px;border-radius:20px;
            font-size:11px;font-weight:700;letter-spacing:.3px;
        }
        .badge-success{background:rgba(46,213,115,.15);color:#2ed573;border:1px solid rgba(46,213,115,.25);}
        .badge-warning{background:rgba(255,171,0,.15);color:#ffab00;border:1px solid rgba(255,171,0,.25);}
        .badge-danger{background:rgba(255,75,43,.15);color:#FF4B2B;border:1px solid rgba(255,75,43,.25);}
        .badge-info{background:rgba(83,131,254,.15);color:#5383fe;border:1px solid rgba(83,131,254,.25);}
        .badge-secondary{background:rgba(255,255,255,.08);color:rgba(255,255,255,.55);border:1px solid rgba(255,255,255,.1);}
        .badge-primary{background:rgba(168,85,247,.15);color:#a855f7;border:1px solid rgba(168,85,247,.25);}
        /* buttons */
        .btn{
            display:inline-flex;align-items:center;gap:6px;
            padding:8px 18px;border-radius:8px;border:none;
            font-family:'Montserrat',sans-serif;font-size:12px;font-weight:700;
            cursor:pointer;text-decoration:none;
            transition:all .2s;letter-spacing:.3px;
        }
        .btn-primary{background:linear-gradient(135deg,var(--accent),var(--accent2));color:#fff;box-shadow:0 4px 15px rgba(255,75,43,.3);}
        .btn-primary:hover{box-shadow:0 6px 22px rgba(255,75,43,.5);transform:translateY(-1px);}
        .btn-success{background:rgba(46,213,115,.15);color:#2ed573;border:1px solid rgba(46,213,115,.25);}
        .btn-success:hover{background:rgba(46,213,115,.25);}
        .btn-info{background:rgba(83,131,254,.15);color:#5383fe;border:1px solid rgba(83,131,254,.25);}
        .btn-info:hover{background:rgba(83,131,254,.25);}
        .btn-warning{background:rgba(255,171,0,.15);color:#ffab00;border:1px solid rgba(255,171,0,.25);}
        .btn-warning:hover{background:rgba(255,171,0,.25);}
        .btn-danger{background:rgba(255,75,43,.12);color:#FF4B2B;border:1px solid rgba(255,75,43,.2);}
        .btn-danger:hover{background:rgba(255,75,43,.22);}
        .btn-secondary{background:rgba(255,255,255,.07);color:rgba(255,255,255,.6);border:1px solid var(--border);}
        .btn-secondary:hover{background:rgba(255,255,255,.12);color:#fff;}
        .btn-sm{padding:5px 12px;font-size:11px;}
        /* forms */
        .form-group{margin-bottom:20px;}
        .form-label{
            display:block;font-size:11px;font-weight:700;
            color:var(--text-muted);text-transform:uppercase;
            letter-spacing:1px;margin-bottom:8px;
        }
        .form-control{
            width:100%;background:rgba(255,255,255,.05);
            border:1px solid var(--border);border-radius:8px;
            color:#fff;padding:11px 14px;
            font-family:'Montserrat',sans-serif;font-size:13px;
            transition:border-color .2s,background .2s;outline:none;
        }
        .form-control::placeholder{color:rgba(255,255,255,.2);}
        .form-control:focus{
            border-color:var(--accent);
            background:rgba(255,75,43,.05);
            box-shadow:0 0 0 3px rgba(255,75,43,.1);
        }
        select.form-control option{background:#16213e;color:#fff;}
        .form-text{font-size:11px;color:rgba(255,255,255,.3);margin-top:5px;}
        /* alert-info in forms */
        .alert-info-form{
            background:rgba(83,131,254,.1);
            border:1px solid rgba(83,131,254,.2);
            border-radius:10px;padding:14px 18px;
            font-size:13px;color:#5383fe;margin-bottom:18px;
        }
        .alert-warning-form{
            background:rgba(255,171,0,.08);
            border:1px solid rgba(255,171,0,.2);
            border-radius:10px;padding:14px 18px;
            font-size:13px;color:#ffab00;margin-bottom:18px;
        }
        /* row/col simple grid */
        .row{display:flex;flex-wrap:wrap;gap:24px;margin-bottom:0;}
        .col-12{width:100%;}
        .col-6{width:calc(50% - 12px);}
        .col-4{width:calc(33.333% - 16px);}
        .col-3{width:calc(25% - 18px);}
        .col-8{width:calc(66.666% - 8px);}
        /* tabs */
        .nav-tabs{display:flex;gap:4px;border-bottom:1px solid var(--border);margin-bottom:20px;}
        .nav-tab{
            padding:9px 18px;border-radius:8px 8px 0 0;
            font-size:12px;font-weight:700;color:var(--text-muted);
            text-decoration:none;cursor:pointer;border:none;background:none;
            transition:all .2s;border-bottom:2px solid transparent;
        }
        .nav-tab.active,.nav-tab:hover{color:#fff;}
        .nav-tab.active{border-bottom-color:var(--accent);color:var(--accent);}
        .tab-pane{display:none;}.tab-pane.active{display:block;}
        /* empty state */
        .empty-state{text-align:center;padding:48px 20px;}
        .empty-state i{font-size:48px;color:rgba(255,255,255,.1);margin-bottom:14px;}
        .empty-state p{color:var(--text-muted);font-size:13px;}
        /* page heading */
        .page-heading{margin-bottom:24px;}
        .page-heading h1{font-size:22px;font-weight:800;color:#fff;}
        .page-heading p{font-size:13px;color:var(--text-muted);margin-top:4px;}
        /* detail table */
        .detail-table{width:100%;border-collapse:collapse;}
        .detail-table th{
            width:180px;padding:10px 0;
            font-size:12px;color:var(--text-muted);font-weight:600;
            vertical-align:top;
        }
        .detail-table td{
            padding:10px 0;font-size:13px;color:#fff;
            border-bottom:1px solid rgba(255,255,255,.04);
        }
        /* footer */
        .main-footer{
            padding:16px 28px;
            border-top:1px solid var(--border);
            font-size:11px;color:rgba(255,255,255,.2);
            text-align:center;
        }
        /* responsive */
        @media(max-width:768px){
            .sidebar{transform:translateX(calc(-1 * var(--sidebar-w)));}
            .sidebar.mobile-open{transform:translateX(0);}
            .main-wrapper{margin-left:0;}
            .row{flex-direction:column;}
            .col-6,.col-4,.col-3,.col-8{width:100%;}
            .content-area{padding:16px;}
        }
        /* scrollbar */
        ::-webkit-scrollbar{width:6px;height:6px;}
        ::-webkit-scrollbar-track{background:transparent;}
        ::-webkit-scrollbar-thumb{background:rgba(255,255,255,.1);border-radius:3px;}
        ::-webkit-scrollbar-thumb:hover{background:rgba(255,255,255,.2);}
    </style>
</head>
<body>
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

        if ($peran === 'Admin'):
        ?>
        <div class="nav-section-title">Main</div>
        <?php navLink('dashboard','fa-home','Dashboard',$cur); ?>
        <div class="nav-section-title">Master Data</div>
        <div class="nav-item" id="ni-turnamen">
            <a class="nav-link" href="#" onclick="toggleNav('ni-turnamen');return false;">
                <i class="fas fa-trophy"></i> Turnamen <i class="fas fa-chevron-right nav-arrow"></i>
            </a>
            <div class="nav-sub">
                <?php navLink('turnamen','','Data Turnamen',$cur); ?>
                <?php navLink('game','','Master Game',$cur); ?>
            </div>
        </div>
        <div class="nav-item" id="ni-tim">
            <a class="nav-link" href="#" onclick="toggleNav('ni-tim');return false;">
                <i class="fas fa-users"></i> Tim & Anggota <i class="fas fa-chevron-right nav-arrow"></i>
            </a>
            <div class="nav-sub">
                <?php navLink('tim','','Data Tim',$cur); ?>
                <?php navLink('anggota','','Data Anggota',$cur); ?>
            </div>
        </div>
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
        <div class="nav-item" id="ni-turnamen">
            <a class="nav-link" href="#" onclick="toggleNav('ni-turnamen');return false;">
                <i class="fas fa-trophy"></i> Turnamen <i class="fas fa-chevron-right nav-arrow"></i>
            </a>
            <div class="nav-sub">
                <?php navLink('turnamen','','Data Turnamen',$cur); ?>
                <?php navLink('game','','Master Game',$cur); ?>
            </div>
        </div>
        <div class="nav-item" id="ni-tim">
            <a class="nav-link" href="#" onclick="toggleNav('ni-tim');return false;">
                <i class="fas fa-users"></i> Tim & Anggota <i class="fas fa-chevron-right nav-arrow"></i>
            </a>
            <div class="nav-sub">
                <?php navLink('tim','','Data Tim',$cur); ?>
            </div>
        </div>

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
        <div class="nav-item" id="ni-peserta-turnamen">
            <a class="nav-link" href="#" onclick="toggleNav('ni-peserta-turnamen');return false;">
                <i class="fas fa-trophy"></i> Turnamen <i class="fas fa-chevron-right nav-arrow"></i>
            </a>
            <div class="nav-sub">
                <?php navLink('turnamen/daftar-tersedia','','Daftar Turnamen',$cur); ?>
                <?php navLink('turnamen/peserta','','Turnamen Saya',$cur); ?>
            </div>
        </div>
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
            <button class="btn-toggle" id="toggleBtn" onclick="toggleSidebar()">
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

<script>
function toggleSidebar(){
    const sb=document.getElementById('sidebar');
    const mw=document.getElementById('mainWrapper');
    if(window.innerWidth<=768){
        sb.classList.toggle('mobile-open');
    } else {
        sb.classList.toggle('collapsed');
        mw.classList.toggle('expanded');
    }
}
function toggleNav(id){
    const el=document.getElementById(id);
    el.classList.toggle('open');
}
// Auto-open active submenu
document.querySelectorAll('.nav-item').forEach(function(item){
    if(item.querySelector('.nav-link.active')){
        item.classList.add('open');
    }
});
// Tabs
document.querySelectorAll('.nav-tab').forEach(function(tab){
    tab.addEventListener('click',function(){
        const target=this.dataset.tab;
        document.querySelectorAll('.nav-tab').forEach(t=>t.classList.remove('active'));
        document.querySelectorAll('.tab-pane').forEach(p=>p.classList.remove('active'));
        this.classList.add('active');
        const pane=document.getElementById(target);
        if(pane) pane.classList.add('active');
    });
});

// SweetAlert2 Global Handlers
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    background: '#1a1a2e',
    color: '#fff',
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

<?php if (session()->getFlashdata('success')): ?>
Toast.fire({ icon: 'success', title: '<?= addslashes(session()->getFlashdata('success')) ?>' });
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
Toast.fire({ icon: 'error', title: '<?= addslashes(session()->getFlashdata('error')) ?>' });
<?php endif; ?>

<?php if (session()->getFlashdata('info')): ?>
Toast.fire({ icon: 'info', title: '<?= addslashes(session()->getFlashdata('info')) ?>' });
<?php endif; ?>

function handleConfirm(e) {
    let target = null;
    
    // Check if it's a click on an element with onclick="return confirm..."
    if (e.type === 'click') {
        target = e.target.closest('[onclick*="return confirm"]');
    } 
    // Check if it's a form submit with onsubmit="return confirm..."
    else if (e.type === 'submit') {
        if (e.target.hasAttribute('onsubmit') && e.target.getAttribute('onsubmit').includes('return confirm')) {
            target = e.target;
        }
    }

    if (!target) return;

    e.preventDefault();
    e.stopPropagation();

    let text = 'Apakah Anda yakin?';
    let match = target.getAttribute(e.type === 'submit' ? 'onsubmit' : 'onclick').match(/confirm\(['"]([^'"]+)['"]\)/);
    if (match) text = match[1];

    Swal.fire({
        title: 'Konfirmasi',
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#FF4B2B',
        cancelButtonColor: 'rgba(255,255,255,0.1)',
        confirmButtonText: 'Ya, Lanjutkan!',
        cancelButtonText: 'Batal',
        background: '#16213e',
        color: '#fff',
        backdrop: `rgba(0,0,10,0.6)`
    }).then((result) => {
        if (result.isConfirmed) {
            if (target.tagName.toLowerCase() === 'form') {
                target.removeAttribute('onsubmit');
                target.submit();
            } else if (target.tagName.toLowerCase() === 'a') {
                window.location.href = target.href;
            } else if (target.tagName.toLowerCase() === 'button' && target.form) {
                target.removeAttribute('onclick');
                target.form.submit();
            }
        }
    });
}

document.addEventListener('click', handleConfirm, true);
document.addEventListener('submit', handleConfirm, true);
</script>
</body>
</html>
