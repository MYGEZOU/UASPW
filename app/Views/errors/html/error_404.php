<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Stage Not Found</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
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
            flex-direction: column;
            color: #fff;
            overflow: hidden;
            text-align: center;
            position: relative;
        }

        /* Particles */
        .particles { position: absolute; inset: 0; pointer-events: none; z-index: 0; }
        .particles span {
            position: absolute; display: block; border-radius: 50%;
            background: rgba(255,75,43,0.07); animation: float linear infinite;
        }
        .particles span:nth-child(1) { width:80px; height:80px; left:15%; animation-duration:22s; }
        .particles span:nth-child(2) { width:30px; height:30px; left:45%; animation-duration:14s; animation-delay:4s; background:rgba(120,50,255,.08); }
        .particles span:nth-child(3) { width:60px; height:60px; left:75%; animation-duration:18s; animation-delay:2s; }
        .particles span:nth-child(4) { width:20px; height:20px; left:90%; animation-duration:11s; animation-delay:6s; background:rgba(120,50,255,.10); }
        @keyframes float {
            0%   { transform: translateY(110vh) scale(0); opacity:0; }
            10%  { opacity: .8; }
            90%  { opacity: .8; }
            100% { transform: translateY(-10vh) scale(1); opacity:0; }
        }

        .error-container {
            position: relative;
            z-index: 10;
            padding: 40px;
        }

        /* Glitch Effect */
        .glitch {
            font-size: 120px;
            font-weight: 900;
            line-height: 1;
            position: relative;
            display: inline-block;
            margin-bottom: 10px;
            color: #fff;
            text-shadow: 0 0 20px rgba(255,75,43,0.5);
            letter-spacing: -5px;
        }
        
        .glitch::before, .glitch::after {
            content: attr(data-text);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: transparent;
        }
        
        .glitch::before {
            left: 3px;
            text-shadow: -2px 0 #FF416C;
            clip: rect(24px, 550px, 90px, 0);
            animation: glitch-anim 3s infinite linear alternate-reverse;
        }
        
        .glitch::after {
            left: -3px;
            text-shadow: -2px 0 #00ffff;
            clip: rect(85px, 550px, 140px, 0);
            animation: glitch-anim 2.5s infinite linear alternate-reverse;
        }

        @keyframes glitch-anim {
            0% { clip: rect(10px, 9999px, 81px, 0); }
            20% { clip: rect(65px, 9999px, 31px, 0); }
            40% { clip: rect(23px, 9999px, 98px, 0); }
            60% { clip: rect(89px, 9999px, 12px, 0); }
            80% { clip: rect(45px, 9999px, 56px, 0); }
            100% { clip: rect(12px, 9999px, 90px, 0); }
        }

        .subtitle {
            font-size: 24px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 4px;
            color: rgba(255,255,255,0.9);
            margin-bottom: 20px;
            background: linear-gradient(90deg, #FF4B2B, #FF416C);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .message {
            font-size: 14px;
            color: rgba(255,255,255,0.6);
            max-width: 500px;
            margin: 0 auto 40px;
            line-height: 1.6;
        }

        .btn-home {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 28px;
            border-radius: 30px;
            background: linear-gradient(135deg, #FF4B2B, #FF416C);
            color: #fff;
            text-decoration: none;
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            box-shadow: 0 10px 30px rgba(255,75,43,0.3);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-home::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-home:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(255,75,43,0.5);
        }

        .btn-home:hover::before {
            left: 100%;
        }

        .btn-home i {
            font-size: 16px;
        }
        
        .game-pad {
            font-size: 60px;
            color: rgba(255, 255, 255, 0.05);
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1;
            pointer-events: none;
        }
    </style>
</head>
<body>

    <!-- Particles Background -->
    <div class="particles">
        <span></span><span></span><span></span><span></span>
    </div>

    <i class="fas fa-gamepad game-pad" style="font-size: 350px;"></i>

    <div class="error-container">
        <div class="glitch" data-text="404">404</div>
        <div class="subtitle">Stage Not Found</div>
        <p class="message">
            Ups! Sepertinya kamu masuk ke arena yang salah atau halaman ini telah dihapus dari server. Mari kembali ke markas untuk melanjutkan permainan.
        </p>
        
        <a href="<?= rtrim(site_url(), '/') ?>/dashboard" class="btn-home">
            <i class="fas fa-home"></i> Kembali ke Base
        </a>
    </div>

</body>
</html>
