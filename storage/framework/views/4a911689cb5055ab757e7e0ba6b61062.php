<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title'); ?> - Admin Panel Premium</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --primary-green: #10b981;
            --dark-green: #065f46;
            --soft-white: #f8fafc;
            --luxury-shadow: 0 15px 35px -5px rgba(0, 0, 0, 0.08);
        }

        body {
            background-color: var(--soft-white);
            color: #1e293b;
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            margin: 0;
            overflow-x: hidden;
        }

        /* FIX: Tinggi dinaikkan jadi 280px agar sapaan tidak nabrak background putih body */
        .header-bg {
            background: linear-gradient(135deg, var(--dark-green) 0%, var(--primary-green) 100%);
            height: 280px; 
            width: 100%;
            position: absolute;
            top: 0;
            z-index: -1;
            border-radius: 0 0 50px 50px;
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.2);
        }

        .navbar {
            padding: 1.2rem 0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1050;
        }

        .navbar.scrolled {
            padding: 0.8rem 0;
            background: rgba(255, 255, 255, 0.8) !important;
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }

        .navbar.scrolled .navbar-brand, 
        .navbar.scrolled .nav-link:not(.active) {
            color: #1e293b !important;
        }
        
        .navbar.scrolled .nav-link.active {
            background: var(--primary-green);
            color: white !important;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.4rem;
            letter-spacing: -1px;
            color: #ffffff !important;
            display: flex;
            align-items: center;
        }

        .nav-link {
            font-weight: 600;
            color: rgba(255, 255, 255, 0.9) !important;
            margin: 0 4px;
            padding: 10px 18px !important;
            transition: all 0.3s ease;
            border-radius: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.95rem;
        }

        .nav-link:hover {
            color: #ffffff !important;
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .nav-link.active {
            color: #ffffff !important;
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.3);
        }

        .btn-logout {
            background: #ffffff;
            border: none;
            color: var(--dark-green);
            padding: 10px 20px;
            border-radius: 14px;
            font-weight: 700;
            transition: 0.3s;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .navbar.scrolled .btn-logout {
            background: #f1f5f9;
            color: #ef4444;
        }

        .btn-logout:hover {
            background: #ef4444;
            color: #ffffff;
            transform: scale(1.05);
        }

        .main-content {
            margin-top: 30px;
            padding-bottom: 60px;
            min-height: 70vh;
        }

        .page-fade-in {
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        footer {
            padding: 30px 0;
            color: #94a3b8;
            font-size: 0.85rem;
            text-align: center;
        }

        @media (max-width: 991px) {
            .navbar-collapse {
                background: white;
                padding: 20px;
                border-radius: 20px;
                margin-top: 15px;
                box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            }
            .nav-link { color: #1e293b !important; margin: 8px 0; }
            .navbar-toggler { filter: brightness(0) invert(1); }
            .navbar.scrolled .navbar-toggler { filter: none; }
        }
    </style>
</head>
<body>

    <div class="header-bg"></div>

    <nav class="navbar navbar-expand-lg sticky-top" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand" href="<?php echo e(route('dashboard')); ?>">
                <div class="bg-white rounded-3 p-2 me-2 d-flex align-items-center justify-content-center shadow-sm" style="width: 35px; height: 35px;">
                    <i class="bi bi-shield-lock-fill text-success" style="font-size: 1.1rem;"></i>
                </div>
                <span>ADMIN PANEL</span>
            </a>
            
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a href="<?php echo e(route('dashboard')); ?>" class="nav-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">
                            <i class="bi bi-grid-1x2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo e(route('admin.books.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.books.*') ? 'active' : ''); ?>">
                            <i class="bi bi-book"></i> Buku
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo e(route('admin.loans.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.loans.*') ? 'active' : ''); ?>">
                            <i class="bi bi-arrow-left-right"></i> Peminjaman
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo e(route('admin.fines.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.fines.*') ? 'active' : ''); ?>">
                            <i class="bi bi-wallet2"></i> Denda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo e(route('admin.users.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.users.*') ? 'active' : ''); ?>">
                            <i class="bi bi-people"></i> Users
                        </a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <form action="<?php echo e(route('logout')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn-logout">
                                <i class="bi bi-power"></i> Keluar
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container main-content">
        <div class="page-fade-in">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>

    <footer>
        <div class="container">
            <hr class="opacity-10 mb-4">
            <p>&copy; <?php echo e(date('Y')); ?> <strong>Admin Panel Premium</strong>. Professional Library System.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('mainNavbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
    
    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html><?php /**PATH C:\Users\AINANHAMMAL\perpustakaan-api\resources\views/layouts/admin.blade.php ENDPATH**/ ?>