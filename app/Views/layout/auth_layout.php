<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? esc($title) . ' — E-Sports Tournament' : 'E-Sports Tournament' ?></title>
    <meta name="description" content="Sistem Manajemen Turnamen E-Sports Online">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700;800&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700;800&display=swap" rel="stylesheet"></noscript>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="<?= base_url('assets/css/custom.css') ?>">
</head>
<body class="auth-body">

<!-- Toast Container -->
<div id="custom-toast-container" class="custom-toast-container"></div>

<!-- Animated particles -->
<div class="particles">
    <span></span><span></span><span></span><span></span><span></span>
</div>

<div class="auth-wrapper">
    <!-- Brand -->
    <div class="site-brand">
        <strong><i class="fas fa-trophy"></i> E-Sports Tournament</strong>
        Sistem Manajemen Turnamen Online
    </div>



    <!-- Page Content -->
    <?= $this->renderSection('content') ?>

    <p class="copyright">&copy; <?= date('Y') ?> E-Sports Tournament System &mdash; All rights reserved</p>
</div>

</body>
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
</html>
