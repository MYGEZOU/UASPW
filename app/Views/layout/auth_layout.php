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
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: #0d0d1a;
            background-image:
                radial-gradient(ellipse at 20% 50%, rgba(120,50,255,0.18) 0%, transparent 60%),
                radial-gradient(ellipse at 80% 20%, rgba(255,75,43,0.15) 0%, transparent 60%);
            min-height: 100vh;
            font-family: 'Montserrat', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        /* ── Particles ── */
        .particles { position: fixed; inset: 0; pointer-events: none; z-index: 0; }
        .particles span {
            position: absolute; display: block; border-radius: 50%;
            background: rgba(255,75,43,0.12); animation: float linear infinite;
        }
        .particles span:nth-child(1) { width:60px; height:60px; left:10%; animation-duration:18s; animation-delay:0s; }
        .particles span:nth-child(2) { width:25px; height:25px; left:25%; animation-duration:12s; animation-delay:3s; background:rgba(120,50,255,.12); }
        .particles span:nth-child(3) { width:45px; height:45px; left:55%; animation-duration:20s; animation-delay:1s; }
        .particles span:nth-child(4) { width:15px; height:15px; left:70%; animation-duration:10s; animation-delay:5s; background:rgba(120,50,255,.15); }
        .particles span:nth-child(5) { width:35px; height:35px; left:85%; animation-duration:15s; animation-delay:2s; }
        @keyframes float {
            0%   { transform: translateY(110vh) scale(0); opacity:0; }
            10%  { opacity: 1; }
            90%  { opacity: 1; }
            100% { transform: translateY(-10vh) scale(1); opacity:0; }
        }

        /* ── Wrapper ── */
        .auth-wrapper {
            position: relative; z-index: 10;
            display: flex; flex-direction: column;
            align-items: center; gap: 22px;
            width: 100%; padding: 20px;
        }

        /* ── Brand ── */
        .site-brand {
            text-align: center; color: #fff;
            letter-spacing: 4px; font-size: 12px;
            font-weight: 700; text-transform: uppercase; opacity: 0.7;
        }
        .site-brand strong {
            font-size: 22px; font-weight: 800; letter-spacing: 2px;
            background: linear-gradient(90deg, #FF4B2B, #FF416C);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            display: block; margin-bottom: 4px;
        }

        /* ── Flash Messages ── */
        .flash-msg {
            max-width: 95vw; padding: 12px 20px;
            border-radius: 8px; font-size: 13px;
            font-weight: 600; text-align: center;
        }
        .flash-msg.error   { background: rgba(255,75,43,.18); color: #FF4B2B; border: 1px solid rgba(255,75,43,.35); }
        .flash-msg.success { background: rgba(46,213,115,.15); color: #2ed573; border: 1px solid rgba(46,213,115,.35); }

        /* ── Auth Card ── */
        .auth-card {
            background: #16213e;
            border-radius: 16px;
            box-shadow:
                0 25px 60px rgba(0,0,0,.55),
                0 0 0 1px rgba(255,255,255,.05),
                0 0 80px rgba(255,75,43,.07);
            overflow: hidden;
        }

        /* Card top gradient bar */
        .card-top {
            background: linear-gradient(135deg, #FF4B2B 0%, #FF416C 100%);
            padding: 30px 40px 24px;
            text-align: center;
            position: relative;
        }
        .card-top::after {
            content: '';
            position: absolute; bottom: -1px; left: 0; right: 0;
            height: 20px;
            background: #16213e;
            clip-path: ellipse(55% 100% at 50% 100%);
        }
        .card-top .icon {
            font-size: 38px; color: rgba(255,255,255,.9);
            text-shadow: 0 0 20px rgba(255,255,255,.3);
            margin-bottom: 10px;
        }
        .card-top h2 {
            font-size: 22px; font-weight: 800;
            color: #fff; letter-spacing: 1px; margin: 0;
        }
        .card-top p {
            font-size: 12px; color: rgba(255,255,255,.7);
            margin-top: 6px; font-weight: 400;
        }

        /* Card body */
        .card-body-auth { padding: 32px 40px 36px; }

        /* Form group */
        .form-group-auth { margin-bottom: 18px; }
        .form-group-auth label {
            display: block; font-size: 11px; font-weight: 700;
            color: rgba(255,255,255,.5); text-transform: uppercase;
            letter-spacing: 1px; margin-bottom: 7px;
        }
        .input-wrap { position: relative; }
        .input-wrap i {
            position: absolute; left: 14px; top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,.25); font-size: 14px;
            transition: color 0.2s; pointer-events: none; z-index: 1;
        }
        .input-wrap input, .input-wrap select {
            width: 100%;
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 8px; color: #fff;
            padding: 12px 16px 12px 40px;
            font-family: inherit; font-size: 13px;
            transition: border-color 0.2s, background 0.2s;
            outline: none;
        }
        .input-wrap input::placeholder { color: rgba(255,255,255,.25); }
        .input-wrap input:focus,
        .input-wrap select:focus {
            border-color: #FF4B2B;
            background: rgba(255,75,43,.06);
        }
        .input-wrap:focus-within i { color: #FF4B2B; }

        /* Buttons */
        .btn-auth {
            width: 100%; margin-top: 8px;
            border-radius: 25px; border: none;
            background: linear-gradient(135deg, #FF4B2B, #FF416C);
            color: #fff; font-family: inherit;
            font-size: 13px; font-weight: 700;
            padding: 13px 20px; letter-spacing: 1.5px;
            text-transform: uppercase; cursor: pointer;
            transition: box-shadow 0.2s, transform 80ms;
            box-shadow: 0 4px 20px rgba(255,75,43,.45);
        }
        .btn-auth:hover  { box-shadow: 0 6px 28px rgba(255,75,43,.65); }
        .btn-auth:active { transform: scale(0.97); }

        /* Back link */
        .back-link {
            display: block; text-align: center;
            margin-top: 20px; font-size: 12px;
            color: rgba(255,255,255,.35);
            text-decoration: none; transition: color 0.2s;
        }
        .back-link:hover { color: #FF4B2B; }
        .back-link i { margin-right: 5px; }

        /* Hint */
        .hint-text {
            font-size: 11px; color: rgba(255,255,255,.3);
            text-align: center; margin-top: 16px; line-height: 1.6;
        }

        /* Copyright */
        .copyright {
            color: rgba(255,255,255,.25); font-size: 11px; text-align: center;
        }
        .copyright a { color: rgba(255,75,43,.7); text-decoration: none; }
        .copyright a:hover { color: #FF4B2B; }
    </style>
</head>
<body>

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

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="flash-msg error"><i class="fas fa-circle-exclamation"></i> <?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="flash-msg success"><i class="fas fa-circle-check"></i> <?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <!-- Page Content -->
    <?= $this->renderSection('content') ?>

    <p class="copyright">&copy; <?= date('Y') ?> E-Sports Tournament System &mdash; All rights reserved</p>
</div>

</body>
</html>
