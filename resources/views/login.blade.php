<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login Admin | Perpustakaan Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            --glass-bg: rgba(255, 255, 255, 0.1);
            --glass-border: rgba(255, 255, 255, 0.2);
        }

        body {
            background: #0f172a;
            background-image: 
                radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(168, 85, 247, 0.15) 0px, transparent 50%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow: hidden;
            margin: 0;
        }

        /* Background Animation Particles */
        .circles {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            overflow: hidden; z-index: -1;
        }
        .circles li {
            position: absolute; display: block; list-style: none;
            width: 20px; height: 20px; background: rgba(255, 255, 255, 0.1);
            animation: animate 25s linear infinite; bottom: -150px;
        }
        @keyframes animate {
            0% { transform: translateY(0) rotate(0deg); opacity: 1; border-radius: 0; }
            100% { transform: translateY(-1000px) rotate(720deg); opacity: 0; border-radius: 50%; }
        }

        .login-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            padding: 3rem;
            border-radius: 28px;
            border: 1px solid var(--glass-border);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            color: white;
            width: 100%;
            max-width: 420px;
            transform: translateY(0);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            animation: fadeInDown 0.8s ease-out;
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-card:hover {
            transform: translateY(-5px);
            border-color: rgba(255, 255, 255, 0.4);
        }

        .brand-logo {
            width: 65px;
            height: 65px;
            background: var(--primary-gradient);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.3);
        }

        .login-card h2 {
            font-weight: 800;
            letter-spacing: -1px;
            margin-bottom: 0.5rem;
            text-align: center;
        }

        .login-card p.subtitle {
            text-align: center;
            color: #94a3b8;
            font-size: 0.9rem;
            margin-bottom: 2rem;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-group-custom i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            transition: all 0.3s;
        }

        .form-control {
            background: rgba(15, 23, 42, 0.5) !important;
            border: 1px solid var(--glass-border);
            border-radius: 14px;
            padding: 12px 15px 12px 45px;
            color: white !important;
            transition: all 0.3s;
        }

        .form-control:focus {
            background: rgba(15, 23, 42, 0.8) !important;
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.2);
            outline: none;
        }

        .form-control:focus + i {
            color: #6366f1;
        }

        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            width: 100%;
            padding: 12px;
            font-weight: 700;
            border-radius: 14px;
            margin-top: 1rem;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-primary:hover {
            transform: scale(1.02);
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.4);
            filter: brightness(1.1);
        }

        .btn-primary:active {
            transform: scale(0.98);
        }

        .text-center a {
            color: #a855f7;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }

        .text-center a:hover {
            color: #6366f1;
            text-shadow: 0 0 10px rgba(99, 102, 241, 0.3);
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-card {
                padding: 2rem;
                margin: 15px;
                border-radius: 20px;
            }
        }
    </style>
</head>
<body>
    <ul class="circles">
        <li style="left: 25%; width: 80px; height: 80px; animation-delay: 0s;"></li>
        <li style="left: 10%; width: 20px; height: 20px; animation-delay: 2s; animation-duration: 12s;"></li>
        <li style="left: 70%; width: 20px; height: 20px; animation-delay: 4s;"></li>
        <li style="left: 40%; width: 60px; height: 60px; animation-delay: 0s; animation-duration: 18s;"></li>
        <li style="left: 65%; width: 20px; height: 20px; animation-delay: 0s;"></li>
    </ul>

    <div class="login-card">
        <div class="brand-logo">
            <i class="bi bi-book-half text-white"></i>
        </div>
        <h2>Welcome Back</h2>
        <p class="subtitle">Silakan login untuk mengelola perpustakaan</p>

        <form method="POST" action="/api/login" id="loginForm">
            @csrf
            <div class="input-group-custom">
                <i class="bi bi-envelope"></i>
                <input type="email" name="email" placeholder="Email Address" required class="form-control" />
            </div>
            
            <div class="input-group-custom">
                <i class="bi bi-lock"></i>
                <input type="password" name="password" placeholder="Password" required class="form-control" />
            </div>

            <button type="submit" class="btn btn-primary" id="btnSubmit">
                <span>Masuk Ke Panel</span>
                <i class="bi bi-arrow-right-short fs-4"></i>
            </button>
        </form>

        <p class="text-center mt-4 mb-0" style="font-size: 0.85rem; color: #94a3b8;">
            Belum punya akun? <a href="/register">Daftar Sekarang</a>
        </p>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const form = e.target;
            const btn = document.getElementById('btnSubmit');
            
            // Animasi Loading pada Tombol
            const originalContent = btn.innerHTML;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Autentikasi...';
            btn.disabled = true;

            const data = {
                email: form.email.value,
                password: form.password.value
            };

            try {
                const res = await fetch('/api/login', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify(data)
                });

                if (!res.ok) {
                    const err = await res.json();
                    alert(err.message || 'Login gagal, periksa kembali email & password');
                    btn.innerHTML = originalContent;
                    btn.disabled = false;
                    return;
                }

                const json = await res.json();
                localStorage.setItem('access_token', json.access_token);
                
                // Efek sukses sebelum redirect
                btn.classList.replace('btn-primary', 'btn-success');
                btn.innerHTML = '<i class="bi bi-check-circle"></i> Berhasil!';
                
                setTimeout(() => {
                    window.location.href = '/admin/dashboard';
                }, 800);

            } catch (error) {
                alert('Terjadi kesalahan koneksi server.');
                btn.innerHTML = originalContent;
                btn.disabled = false;
            }
        });
    </script>
</body>
</html>