<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password — E-Sports Tournament</title>
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

        .particles { position: fixed; inset: 0; pointer-events: none; z-index: 0; }
        .particles span {
            position: absolute; display: block; border-radius: 50%;
            background: rgba(120,50,255,0.12); animation: float linear infinite;
        }
        .particles span:nth-child(1) { width:50px; height:50px; left:15%; animation-duration:16s; }
        .particles span:nth-child(2) { width:20px; height:20px; left:40%; animation-duration:11s; animation-delay:4s; background:rgba(255,75,43,.12); }
        .particles span:nth-child(3) { width:35px; height:35px; left:65%; animation-duration:19s; animation-delay:2s; }
        .particles span:nth-child(4) { width:12px; height:12px; left:80%; animation-duration:9s;  animation-delay:6s; background:rgba(255,75,43,.15); }
        @keyframes float {
            0%   { transform: translateY(110vh) scale(0); opacity:0; }
            10%  { opacity: 1; }  90%  { opacity: 1; }
            100% { transform: translateY(-10vh) scale(1); opacity:0; }
        }

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

        .flash-msg {
            width: 420px; max-width: 95vw;
            padding: 12px 18px; border-radius: 8px;
            font-size: 13px; font-weight: 600; text-align: center;
        }
        .flash-msg.error   { background: rgba(255,75,43,.18);  color: #FF4B2B; border: 1px solid rgba(255,75,43,.35); }
        .flash-msg.success { background: rgba(46,213,115,.15); color: #2ed573; border: 1px solid rgba(46,213,115,.35); }

        .auth-card {
            background: #16213e;
            border-radius: 16px;
            box-shadow:
                0 25px 60px rgba(0,0,0,.55),
                0 0 0 1px rgba(255,255,255,.05),
                0 0 80px rgba(120,50,255,.08);
            width: 420px; max-width: 95vw;
            overflow: hidden;
        }

        .card-top {
            background: linear-gradient(135deg, #7832ff 0%, #5c1e9e 100%);
            padding: 30px 40px 24px;
            text-align: center; position: relative;
        }
        .card-top::after {
            content: '';
            position: absolute; bottom: -1px; left: 0; right: 0;
            height: 20px; background: #16213e;
            clip-path: ellipse(55% 100% at 50% 100%);
        }
        .card-top .icon { font-size: 38px; color: rgba(255,255,255,.9); margin-bottom: 10px; }
        .card-top h2 { font-size: 22px; font-weight: 800; color: #fff; letter-spacing: 1px; margin: 0; }
        .card-top p  { font-size: 12px; color: rgba(255,255,255,.7); margin-top: 6px; }

        .card-body { padding: 32px 40px 36px; }

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
            pointer-events: none; z-index: 1;
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
            border-color: #7832ff;
            background: rgba(120,50,255,.07);
        }
        .input-wrap:focus-within i { color: #7832ff; }

        /* Password strength bar */
        .strength-bar {
            height: 3px; border-radius: 3px;
            background: rgba(255,255,255,.07);
            margin-top: 6px; overflow: hidden;
        }
        .strength-bar-fill {
            height: 100%; width: 0;
            border-radius: 3px;
            transition: width 0.3s, background 0.3s;
        }

        .btn-submit {
            width: 100%; margin-top: 8px;
            border-radius: 25px; border: none;
            background: linear-gradient(135deg, #7832ff, #5c1e9e);
            color: #fff; font-family: inherit;
            font-size: 13px; font-weight: 700;
            padding: 13px 20px; letter-spacing: 1.5px;
            text-transform: uppercase; cursor: pointer;
            transition: box-shadow 0.2s, transform 80ms;
            box-shadow: 0 4px 20px rgba(120,50,255,.45);
        }
        .btn-submit:hover  { box-shadow: 0 6px 28px rgba(120,50,255,.65); }
        .btn-submit:active { transform: scale(0.97); }

        .rules {
            margin-top: 14px; padding: 12px 14px;
            background: rgba(255,255,255,.04);
            border-radius: 8px; border: 1px solid rgba(255,255,255,.06);
            font-size: 11px; color: rgba(255,255,255,.35);
            line-height: 1.8;
        }
        .rules i { margin-right: 5px; }

        .back-link {
            display: block; text-align: center;
            margin-top: 20px; font-size: 12px;
            color: rgba(255,255,255,.35);
            text-decoration: none; transition: color 0.2s;
        }
        .back-link:hover { color: #7832ff; }
        .back-link i { margin-right: 5px; }
    </style>
</head>
<body>

<div class="particles">
    <span></span><span></span><span></span><span></span>
</div>

<div class="wrapper">

    <div class="site-brand">
        <strong><i class="fas fa-trophy"></i> E-Sports Tournament</strong>
        Sistem Manajemen Turnamen Online
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="flash-msg error"><i class="fas fa-circle-exclamation"></i> <?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="flash-msg success"><i class="fas fa-circle-check"></i> <?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <div class="auth-card">
        <div class="card-top">
            <div class="icon"><i class="fas fa-shield-halved"></i></div>
            <h2>Buat Password Baru</h2>
            <p>Akun ditemukan. Silakan atur password baru Anda.</p>
        </div>

        <div class="card-body">
            <form action="<?= site_url('reset-password/update') ?>" method="POST">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label>Password Baru</label>
                    <div class="input-wrap">
                        <input type="password" name="password" id="passwordInput"
                               placeholder="Minimal 6 karakter" required>
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="strength-bar">
                        <div class="strength-bar-fill" id="strengthBar"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Konfirmasi Password</label>
                    <div class="input-wrap">
                        <input type="password" name="konfirmasi_password"
                               placeholder="Ulangi password baru" required>
                        <i class="fas fa-lock-open"></i>
                    </div>
                </div>

                <div class="rules">
                    <i class="fas fa-circle-info"></i> Password minimal <strong>6 karakter</strong>.<br>
                    <i class="fas fa-circle-info"></i> Gunakan kombinasi huruf dan angka untuk keamanan lebih baik.
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-floppy-disk"></i> Simpan Password Baru
                </button>
            </form>

            <a href="<?= site_url('lupa-password') ?>" class="back-link">
                <i class="fas fa-arrow-left"></i> Kembali ke Lupa Password
            </a>
        </div>
    </div>

</div>

<script>
    // Simple password strength indicator
    const input = document.getElementById('passwordInput');
    const bar   = document.getElementById('strengthBar');

    input.addEventListener('input', () => {
        const val = input.value;
        let score = 0;
        if (val.length >= 6)  score++;
        if (val.length >= 10) score++;
        if (/[A-Z]/.test(val)) score++;
        if (/[0-9]/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;

        const map = [
            { w: '0%',   bg: 'transparent' },
            { w: '25%',  bg: '#e74c3c' },
            { w: '50%',  bg: '#e67e22' },
            { w: '75%',  bg: '#f1c40f' },
            { w: '90%',  bg: '#2ecc71' },
            { w: '100%', bg: '#27ae60' },
        ];
        bar.style.width      = map[score].w;
        bar.style.background = map[score].bg;
    });
</script>

</body>
</html>
