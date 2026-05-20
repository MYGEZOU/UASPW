<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password — E-Sports Tournament</title>
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

        /* Animated particles */
        .particles { position: fixed; inset: 0; pointer-events: none; z-index: 0; }
        .particles span {
            position: absolute; display: block; border-radius: 50%;
            background: rgba(255,75,43,0.12); animation: float linear infinite;
        }
        .particles span:nth-child(1) { width:55px; height:55px; left:8%;  animation-duration:18s; }
        .particles span:nth-child(2) { width:22px; height:22px; left:30%; animation-duration:12s; animation-delay:3s; background:rgba(120,50,255,.12); }
        .particles span:nth-child(3) { width:40px; height:40px; left:60%; animation-duration:20s; animation-delay:1s; }
        .particles span:nth-child(4) { width:14px; height:14px; left:75%; animation-duration:10s; animation-delay:5s; background:rgba(120,50,255,.15); }
        @keyframes float {
            0%   { transform: translateY(110vh) scale(0); opacity:0; }
            10%  { opacity: 1; }
            90%  { opacity: 1; }
            100% { transform: translateY(-10vh) scale(1); opacity:0; }
        }

        /* Wrapper */
        .wrapper {
            position: relative; z-index: 10;
            display: flex; flex-direction: column;
            align-items: center; gap: 22px;
            width: 100%; padding: 20px;
        }

        .site-brand {
            text-align: center; color: #fff;
            letter-spacing: 4px; font-size: 12px;
            font-weight: 700; text-transform: uppercase; opacity: 0.7;
        }
        .site-brand strong {
            font-size: 20px; font-weight: 800; letter-spacing: 2px;
            background: linear-gradient(90deg, #FF4B2B, #FF416C);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            display: block; margin-bottom: 4px;
        }

        /* Flash */
        .flash-msg {
            width: 420px; max-width: 95vw;
            padding: 12px 18px; border-radius: 8px;
            font-size: 13px; font-weight: 600; text-align: center;
        }
        .flash-msg.error   { background: rgba(255,75,43,.18);  color: #FF4B2B; border: 1px solid rgba(255,75,43,.35); }
        .flash-msg.success { background: rgba(46,213,115,.15); color: #2ed573; border: 1px solid rgba(46,213,115,.35); }

        /* Card */
        .auth-card {
            background: #16213e;
            border-radius: 16px;
            box-shadow:
                0 25px 60px rgba(0,0,0,.55),
                0 0 0 1px rgba(255,255,255,.05),
                0 0 80px rgba(255,75,43,.07);
            width: 420px; max-width: 95vw;
            overflow: hidden;
        }

        /* Card header gradient bar */
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
        .card-body {
            padding: 32px 40px 36px;
        }

        .form-group { margin-bottom: 18px; }
        .form-group label {
            display: block; font-size: 11px; font-weight: 700;
            color: rgba(255,255,255,.5); text-transform: uppercase;
            letter-spacing: 1px; margin-bottom: 7px;
        }
        .input-wrap { position: relative; }
        .input-wrap i {
            position: absolute; left: 14px; top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,.25); font-size: 14px;
            transition: color 0.2s;
        }
        .input-wrap input {
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
        .input-wrap input:focus {
            border-color: #FF4B2B;
            background: rgba(255,75,43,.06);
        }
        .input-wrap input:focus + i,
        .input-wrap:focus-within i { color: #FF4B2B; }

        /* Fix icon layering */
        .input-wrap i { pointer-events: none; z-index: 1; }
        .input-wrap input { position: relative; z-index: 0; }

        .btn-submit {
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
        .btn-submit:hover  { box-shadow: 0 6px 28px rgba(255,75,43,.65); }
        .btn-submit:active { transform: scale(0.97); }

        .back-link {
            display: block; text-align: center;
            margin-top: 20px; font-size: 12px;
            color: rgba(255,255,255,.35);
            text-decoration: none; transition: color 0.2s;
        }
        .back-link:hover { color: #FF4B2B; }
        .back-link i { margin-right: 5px; }

        /* Hint text */
        .hint-text {
            font-size: 11px; color: rgba(255,255,255,.3);
            text-align: center; margin-top: 16px; line-height: 1.6;
        }
    </style>
</head>
<body>

<div class="particles">
    <span></span><span></span><span></span><span></span>
</div>

<div class="wrapper">

    <!-- Brand -->
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

    <!-- Card -->
    <div class="auth-card">
        <div class="card-top">
            <div class="icon"><i class="fas fa-key"></i></div>
            <h2>Lupa Password?</h2>
            <p>Masukkan Email dan Username akun Anda</p>
        </div>

        <div class="card-body">
            <form action="<?= site_url('lupa-password/proses') ?>" method="POST">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label>Email Akun</label>
                    <div class="input-wrap">
                        <input type="email" name="email" placeholder="email@domain.com"
                               value="<?= old('email') ?>" required autofocus>
                        <i class="fas fa-envelope"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Username</label>
                    <div class="input-wrap">
                        <input type="text" name="username" placeholder="Username Anda"
                               value="<?= old('username') ?>" required>
                        <i class="fas fa-user"></i>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-magnifying-glass"></i> Cek Akun
                </button>
            </form>

            <p class="hint-text">
                Pastikan Email dan Username sesuai dengan yang Anda daftarkan.<br>
                Jika tidak ingat username, hubungi Admin.
            </p>

            <a href="<?= site_url('login') ?>" class="back-link">
                <i class="fas fa-arrow-left"></i> Kembali ke Login
            </a>
        </div>
    </div>

</div>

</body>
</html>
