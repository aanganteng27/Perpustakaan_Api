<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Panel - <?php echo $__env->yieldContent('title', 'Dashboard'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f4f7fa;
        }
        nav.navbar {
            box-shadow: 0 2px 4px rgb(0 0 0 / 0.1);
        }
        main.container {
            min-height: 80vh;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?php echo e(route('dashboard')); ?>">
            <i class="bi bi-shield-lock-fill me-1"></i> Admin Panel
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto fs-6">
                <li class="nav-item"><a href="<?php echo e(route('admin.fines.index')); ?>" class="nav-link">Denda</a></li>
                <li class="nav-item"><a href="<?php echo e(route('logout')); ?>" class="nav-link">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<main class="container py-4">
    <?php echo $__env->yieldContent('content'); ?>
</main>

<footer class="bg-light text-center py-3 shadow-sm mt-auto">
    <small class="text-muted">&copy; <?php echo e(date('Y')); ?> Perpustakaan</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH C:\Users\AINANHAMMAL\perpustakaan-api\resources\views/admin/index.blade.php ENDPATH**/ ?>