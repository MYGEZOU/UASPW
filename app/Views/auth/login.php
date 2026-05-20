<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Sports Tournament — Login & Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: #0d0d1a;
            background-image:
                radial-gradient(ellipse at 20% 50%, rgba(120,50,255,0.18) 0%, transparent 60%),
                radial-gradient(ellipse at 80% 20%, rgba(255,75,43,0.15) 0%, transparent 60%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: 'Montserrat', sans-serif;
            overflow: hidden;
        }

        /* ───── Animated bg particles ───── */
        .particles {
            position: fixed; inset: 0; pointer-events: none; z-index: 0;
        }
        .particles span {
            position: absolute;
            display: block;
            border-radius: 50%;
            background: rgba(255,75,43,0.12);
            animation: float linear infinite;
        }
        .particles span:nth-child(1)  { width:60px; height:60px; left:10%; animation-duration:18s; animation-delay:0s; }
        .particles span:nth-child(2)  { width:25px; height:25px; left:25%; animation-duration:12s; animation-delay:3s; background:rgba(120,50,255,.12); }
        .particles span:nth-child(3)  { width:45px; height:45px; left:55%; animation-duration:20s; animation-delay:1s; }
        .particles span:nth-child(4)  { width:15px; height:15px; left:70%; animation-duration:10s; animation-delay:5s; background:rgba(120,50,255,.15); }
        .particles span:nth-child(5)  { width:35px; height:35px; left:85%; animation-duration:15s; animation-delay:2s; }
        @keyframes float {
            0%   { transform: translateY(110vh) scale(0); opacity:0; }
            10%  { opacity: 1; }
            90%  { opacity: 1; }
            100% { transform: translateY(-10vh) scale(1); opacity:0; }
        }

        /* ───── Wrapper ───── */
        .wrapper {
            position: relative;
            z-index: 10;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 24px;
        }

        .site-brand {
            text-align: center;
            color: #fff;
            letter-spacing: 4px;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            opacity: 0.7;
        }
        .site-brand strong {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: 2px;
            background: linear-gradient(90deg, #FF4B2B, #FF416C);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: block;
            opacity: 1;
        }

        /* ───── Flashdata alerts ───── */
        .flash-msg {
            width: 768px;
            max-width: 95vw;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            text-align: center;
        }
        .flash-msg.error   { background: rgba(255,75,43,.18); color: #FF4B2B; border: 1px solid rgba(255,75,43,.35); }
        .flash-msg.success { background: rgba(46,213,115,.15); color: #2ed573; border: 1px solid rgba(46,213,115,.35); }

        /* ───── Slider container ───── */
        #container {
            background: #1a1a2e;
            border-radius: 16px;
            box-shadow:
                0 25px 60px rgba(0,0,0,.55),
                0 0 0 1px rgba(255,255,255,.05),
                0 0 80px rgba(255,75,43,.08);
            position: relative;
            overflow: hidden;
            width: 768px;
            max-width: 95vw;
            min-height: 500px;
        }

        /* ───── Form panels ───── */
        .form-container {
            position: absolute;
            top: 0; height: 100%;
            transition: all 0.6s ease-in-out;
        }
        .sign-in-container { left: 0; width: 50%; z-index: 2; }
        #container.right-panel-active .sign-in-container { transform: translateX(100%); }

        .sign-up-container { left: 0; width: 50%; opacity: 0; z-index: 1; }
        #container.right-panel-active .sign-up-container {
            transform: translateX(100%);
            opacity: 1; z-index: 5;
            animation: reveal 0.6s;
        }
        @keyframes reveal {
            0%, 49.99% { opacity:0; z-index:1; }
            50%, 100%  { opacity:1; z-index:5; }
        }

        /* ───── Form styling ───── */
        form {
            background: #16213e;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 44px;
            height: 100%;
            text-align: center;
        }

        form h1 {
            font-weight: 800;
            font-size: 24px;
            color: #fff;
            margin-bottom: 4px;
            letter-spacing: 1px;
        }

        form > span {
            font-size: 11px;
            color: rgba(255,255,255,.45);
            margin-bottom: 18px;
            letter-spacing: 0.5px;
        }

        form input {
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 8px;
            color: #fff;
            padding: 12px 16px;
            margin: 5px 0;
            width: 100%;
            font-family: inherit;
            font-size: 13px;
            transition: border-color 0.2s, background 0.2s;
            outline: none;
        }
        form input::placeholder { color: rgba(255,255,255,.3); }
        form input:focus {
            border-color: #FF4B2B;
            background: rgba(255,75,43,.06);
        }

        form button[type="submit"] {
            margin-top: 18px;
            border-radius: 25px;
            border: none;
            background: linear-gradient(135deg, #FF4B2B, #FF416C);
            color: #fff;
            font-family: inherit;
            font-size: 12px;
            font-weight: 700;
            padding: 13px 48px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            cursor: pointer;
            transition: transform 80ms ease-in, box-shadow 0.2s;
            box-shadow: 0 4px 20px rgba(255,75,43,.45);
        }
        form button[type="submit"]:hover  { box-shadow: 0 6px 28px rgba(255,75,43,.65); }
        form button[type="submit"]:active { transform: scale(0.96); }

        form a.forgot {
            color: rgba(255,255,255,.4);
            font-size: 12px;
            margin-top: 14px;
            text-decoration: none;
            transition: color 0.2s;
        }
        form a.forgot:hover { color: #FF4B2B; }

        /* ───── Overlay ───── */
        .overlay-container {
            position: absolute;
            top: 0; left: 50%;
            width: 50%; height: 100%;
            overflow: hidden;
            transition: transform 0.6s ease-in-out;
            z-index: 100;
        }
        #container.right-panel-active .overlay-container { transform: translateX(-100%); }

        .overlay {
            background: linear-gradient(135deg, #FF4B2B 0%, #c0392b 40%, #8e1a2e 100%);
            position: relative;
            left: -100%;
            height: 100%;
            width: 200%;
            transform: translateX(0);
            transition: transform 0.6s ease-in-out;
        }
        #container.right-panel-active .overlay { transform: translateX(50%); }

        /* grid lines on overlay */
        .overlay::before {
            content: '';
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.05) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        .overlay-panel {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 44px;
            text-align: center;
            top: 0; height: 100%; width: 50%;
            transition: transform 0.6s ease-in-out;
        }
        .overlay-panel h1 {
            font-size: 26px;
            font-weight: 800;
            color: #fff;
            letter-spacing: 1px;
            margin-bottom: 12px;
        }
        .overlay-panel p {
            font-size: 13px;
            color: rgba(255,255,255,.75);
            line-height: 1.6;
            margin-bottom: 28px;
        }
        .overlay-panel .icon-trophy {
            font-size: 42px;
            color: rgba(255,255,255,.9);
            margin-bottom: 16px;
            text-shadow: 0 0 20px rgba(255,255,255,.4);
        }

        .overlay-left  { transform: translateX(-20%); }
        #container.right-panel-active .overlay-left { transform: translateX(0); }
        .overlay-right { right: 0; transform: translateX(0); }
        #container.right-panel-active .overlay-right { transform: translateX(20%); }

        button.ghost {
            border-radius: 25px;
            border: 2px solid #fff;
            background: transparent;
            color: #fff;
            font-family: inherit;
            font-size: 12px;
            font-weight: 700;
            padding: 12px 40px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            cursor: pointer;
            transition: background 0.2s, color 0.2s, transform 80ms;
        }
        button.ghost:hover  { background: rgba(255,255,255,.15); }
        button.ghost:active { transform: scale(0.96); }

        /* ───── Copyright ───── */
        .copyright {
            color: rgba(255,255,255,.25);
            font-size: 11px;
            text-align: center;
        }
        .copyright a { color: rgba(255,75,43,.7); text-decoration: none; }
        .copyright a:hover { color: #FF4B2B; }
    </style>
</head>
<body>

<!-- Animated floating particles -->
<div class="particles">
    <span></span><span></span><span></span><span></span><span></span>
</div>

<div class="wrapper">
    <!-- Brand header -->
    <div class="site-brand">
        <strong><i class="fas fa-trophy"></i> E-Sports Tournament</strong>
        Sistem Manajemen Turnamen Online
    </div>

    <!-- Flash messages -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="flash-msg error"><i class="fas fa-circle-exclamation"></i> <?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="flash-msg success"><i class="fas fa-circle-check"></i> <?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <!-- Double Slider Container -->
    <div id="container">

        <!-- ── Sign Up Form ── -->
        <div class="form-container sign-up-container">
            <form action="<?= site_url('register') ?>" method="POST">
                <?= csrf_field() ?>
                <h1>Buat Akun</h1>
                <span>Gunakan email untuk mendaftar sebagai Peserta</span>
                <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" value="<?= old('nama_lengkap') ?>" required>
                <input type="email" name="email" placeholder="Email" value="<?= old('email') ?>" required>
                <input type="password" name="password" placeholder="Password (min. 6 karakter)" required>
                <input type="password" name="konfirmasi_password" placeholder="Ulangi Password" required>
                <a href="<?= site_url('lupa-password') ?>" class="forgot">Lupa password?</a>
                <button type="submit"><i class="fas fa-user-plus"></i> Daftar Sekarang</button>
            </form>
        </div>

        <!-- ── Sign In Form ── -->
        <div class="form-container sign-in-container">
            <form action="<?= site_url('login') ?>" method="POST">
                <?= csrf_field() ?>
                <h1>Masuk</h1>
                <span>Gunakan username atau email dan password</span>
                <input type="text" name="username" placeholder="Username atau Email" required autofocus>
                <input type="password" name="password" placeholder="Password" required>
                <a href="<?= site_url('lupa-password') ?>" class="forgot">Lupa password?</a>
                <button type="submit"><i class="fas fa-right-to-bracket"></i> Masuk</button>
            </form>
        </div>

        <!-- ── Sliding Overlay ── -->
        <div class="overlay-container">
            <div class="overlay">
                <!-- LEFT panel: shown when Sign Up is active -->
                <div class="overlay-panel overlay-left">
                    <i class="fas fa-gamepad icon-trophy"></i>
                    <h1>Selamat Datang!</h1>
                    <p>Sudah punya akun? Masuk sekarang dan kelola turnamen Anda.</p>
                    <button class="ghost" id="signIn"><i class="fas fa-arrow-left"></i> Masuk</button>
                </div>
                <!-- RIGHT panel: shown on default (login) -->
                <div class="overlay-panel overlay-right">
                    <i class="fas fa-trophy icon-trophy"></i>
                    <h1>Halo, Pejuang!</h1>
                    <p>Daftarkan diri dan bergabunglah dalam arena turnamen e-sports terbaik.</p>
                    <button class="ghost" id="signUp">Daftar <i class="fas fa-arrow-right"></i></button>
                </div>
            </div>
        </div>

    </div><!-- end #container -->

    <p class="copyright">&copy; <?= date('Y') ?> E-Sports Tournament System &mdash; All rights reserved</p>
</div>

<script>
    const signUpButton  = document.getElementById('signUp');
    const signInButton  = document.getElementById('signIn');
    const container     = document.getElementById('container');

    signUpButton.addEventListener('click', () => container.classList.add('right-panel-active'));
    signInButton.addEventListener('click', () => container.classList.remove('right-panel-active'));

    // Auto-switch to register panel if there's a register error
    <?php if (session()->getFlashdata('show_register')): ?>
    container.classList.add('right-panel-active');
    <?php endif; ?>
</script>

</body>
</html>