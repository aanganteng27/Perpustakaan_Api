<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Welcome | Digital Library System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --accent-color: #00f2fe;
            --main-gradient: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
        }

        body {
            background: var(--main-gradient);
            color: white;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0;
            overflow: hidden;
            position: relative;
        }

        /* Animated Aurora Background */
        body::before {
            content: "";
            position: absolute;
            top: -50%; left: -50%;
            width: 200%; height: 200%;
            background: radial-gradient(circle at center, rgba(99, 102, 241, 0.1) 0%, transparent 40%),
                        radial-gradient(circle at 20% 30%, rgba(0, 242, 254, 0.05) 0%, transparent 30%);
            animation: rotate 20s linear infinite;
            z-index: -1;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .welcome-container {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            padding: 4rem;
            border-radius: 40px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 40px 100px rgba(0, 0, 0, 0.4);
            text-align: center;
            max-width: 700px;
            width: 90%;
            animation: slideUp 1s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(50px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .icon-box {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            font-size: 2.5rem;
            color: var(--accent-color);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: 0.5s;
        }

        .welcome-container:hover .icon-box {
            transform: rotateY(180deg);
            background: var(--accent-color);
            color: #0f172a;
            box-shadow: 0 0 30px rgba(0, 242, 254, 0.5);
        }

        .welcome-container h1 {
            font-weight: 800;
            font-size: clamp(2rem, 5vw, 3.5rem);
            letter-spacing: -2px;
            margin-bottom: 1.5rem;
            background: linear-gradient(to right, #fff 20%, #94a3b8 80%);
            /* Fix Compatibility Issue */
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .welcome-container p {
            font-size: 1.1rem;
            color: #94a3b8;
            margin-bottom: 3rem;
            line-height: 1.6;
        }

        /* Glossy Button Sweep Effect */
        .btn-luxury {
            position: relative;
            background: white;
            color: #0f172a;
            border: none;
            padding: 1rem 3rem;
            font-size: 1.1rem;
            font-weight: 700;
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 10px 30px rgba(255, 255, 255, 0.1);
        }

        .btn-luxury::before {
            content: "";
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(120deg, transparent, rgba(255,255,255,0.6), transparent);
            transition: 0.6s;
        }

        .btn-luxury:hover::before {
            left: 100%;
        }

        .btn-luxury:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 20px 40px rgba(0, 242, 254, 0.2);
            color: #0f172a;
        }

        footer {
            position: fixed;
            bottom: 30px;
            width: 100%;
            text-align: center;
            color: #475569;
            font-size: 0.85rem;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        /* Responsive Mobile */
        @media (max-width: 576px) {
            .welcome-container {
                padding: 2.5rem 1.5rem;
                border-radius: 30px;
            }
            .icon-box {
                width: 60px; height: 60px; font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>

    <div class="welcome-container">
        <div class="icon-box">
            <i class="bi bi-rocket-takeoff-fill"></i>
        </div>
        <h1>Library Intelligence System</h1>
        <p>Masa depan manajemen literasi dalam genggaman Anda. Kelola aset buku, data peminjaman, dan sistem admin dengan performa tinggi.</p>
        
        <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
            <a href="{{ route('login') }}" class="btn-luxury">
                <span>Enter Dashboard</span>
                <i class="bi bi-chevron-right"></i>
            </a>
        </div>
    </div>

    <footer>
        &copy; {{ date('Y') }} Quantum Library &bull; Designed for Excellence
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>