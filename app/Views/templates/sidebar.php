<?php
$peran = session('peran');
$menu = [];

// Menu untuk Admin
if ($peran == 'Admin') {
    $menu = [
        ['title' => 'Dashboard', 'icon' => 'la la-home', 'link' => 'dashboard'],
        ['title' => 'Master Data', 'icon' => 'la la-database', 'submenu' => [
            ['title' => 'Turnamen', 'link' => 'turnamen'],
            ['title' => 'Tim', 'link' => 'tim'],
            ['title' => 'Anggota', 'link' => 'anggota'],
            ['title' => 'Akun', 'link' => 'akun']
        ]],
        ['title' => 'Transaksi', 'icon' => 'la la-money', 'submenu' => [
            ['title' => 'Pendaftaran', 'link' => 'daftar'],
            ['title' => 'Pembayaran', 'link' => 'daftar/pembayaran']
        ]],
        ['title' => 'Pertandingan', 'icon' => 'la la-gamepad', 'submenu' => [
            ['title' => 'Jadwal', 'link' => 'jadwal'],
            ['title' => 'Skor', 'link' => 'skor']
        ]],
    ];
}
// Menu untuk Peserta
elseif ($peran == 'Peserta') {
    $menu = [
        ['title' => 'Dashboard', 'icon' => 'la la-home', 'link' => 'dashboard'],
        ['title' => 'Tim Saya', 'icon' => 'la la-users', 'link' => 'tim/profil'],
        ['title' => 'Turnamen', 'icon' => 'la la-trophy', 'link' => 'turnamen/peserta'],
        ['title' => 'Jadwal & Skor', 'icon' => 'la la-calendar', 'link' => 'jadwal/peserta'],
    ];
}
// Menu untuk AdminGame
elseif ($peran == 'AdminGame') {
    $menu = [
        ['title' => 'Dashboard', 'icon' => 'la la-home', 'link' => 'dashboard'],
        ['title' => 'Turnamen', 'icon' => 'la la-trophy', 'submenu' => [
            ['title' => 'Kelola Turnamen', 'link' => 'turnamen'],
            ['title' => 'Jadwal', 'link' => 'jadwal'],
            ['title' => 'Input Skor', 'link' => 'skor']
        ]],
        ['title' => 'Tim & Peserta', 'icon' => 'la la-users', 'link' => 'tim'],
    ];
}
?>

<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <?php foreach ($menu as $item): ?>
                <?php if (isset($item['submenu'])): ?>
                    <li class="nav-item">
                        <a href="#"><i class="<?= $item['icon'] ?>"></i><span class="menu-title"><?= $item['title'] ?></span></a>
                        <ul class="menu-content">
                            <?php foreach ($item['submenu'] as $sub): ?>
                                <li><a class="menu-item" href="<?= base_url($sub['link']) ?>"><?= $sub['title'] ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="<?= (current_url() == base_url($item['link'])) ? 'active' : '' ?>">
                        <a href="<?= base_url($item['link']) ?>"><i class="<?= $item['icon'] ?>"></i><span class="menu-title"><?= $item['title'] ?></span></a>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
</div>