<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PundoHub</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        body {
            overflow-x: hidden;
        }

        /* Sidebar styling */
        #sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: #343a40;
            color: white;
            transition: transform 0.3s ease-in-out;
            z-index: 1050;
        }

        #sidebar .nav-link {
            color: #adb5bd;
            font-weight: 500;
        }

        #sidebar .nav-link:hover,
        #sidebar .nav-link.active {
            background: #495057;
            color: #fff;
        }

        /* Main content */
        #content {
            flex-grow: 1;
            margin-left: 250px;
            padding: 20px;
            min-height: 100vh;
            background: url("<?php echo e(asset('images/background.jpg')); ?>") no-repeat center center fixed;
            background-size: cover;
            color: #fff;
            transition: margin-left 0.3s ease-in-out;
        }

        .card {
            background-color: #d8d7d7;
            color: #333;
            border: none;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            padding: 1rem;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.25);
        }

        /* Logo circle */
        .logo-img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
        }

        /* Sidebar responsive */
        @media (max-width: 992px) {
            #sidebar {
                transform: translateX(-100%);
            }
            #sidebar.show {
                transform: translateX(0);
            }
            #content {
                margin-left: 0;
            }
        }

        /* Toggle button */
        #sidebarToggle {
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1100;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <nav id="sidebar" class="bg-dark">
        <div class="text-center py-4 border-bottom border-secondary">
            <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Logo" class="logo-img mb-2">
            <h5 class="text-white">PundoHub</h5>
        </div>

        <ul class="nav flex-column mt-3 px-2">
            <?php if(auth()->guard()->check()): ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>"
                       href="<?php echo e(route('dashboard')); ?>">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>

                <?php if(auth()->user()->role === 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('bereavement-cases.*') ? 'active' : ''); ?>" 
                           href="<?php echo e(route('bereavement-cases.index')); ?>">
                           <i class="bi bi-people me-2"></i> Bereavement Cases
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.death-reports.*') ? 'active' : ''); ?>"
                           href="<?php echo e(route('admin.death-reports.index')); ?>">
                           <i class="bi bi-file-earmark-medical-fill me-2"></i> Death Reports
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('donations.*') ? 'active' : ''); ?>" 
                           href="<?php echo e(route('donations.index')); ?>">
                           <i class="bi bi-cash-coin me-2"></i> Donations
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('notifications.index') ? 'active' : ''); ?>" 
                           href="<?php echo e(route('notifications.index')); ?>">
                           <i class="bi bi-bell me-2"></i> Notifications
                           <?php if(Auth::user()->unreadNotifications->count() > 0): ?>
                               <span class="badge bg-danger"><?php echo e(Auth::user()->unreadNotifications->count()); ?></span>
                           <?php endif; ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('members.*') ? 'active' : ''); ?>" 
                           href="<?php echo e(route('members.index')); ?>">
                           <i class="bi bi-person-lines-fill me-2"></i> Members
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('donations.create') ? 'active' : ''); ?>" 
                           href="<?php echo e(route('donations.create')); ?>">
                           <i class="bi bi-heart-fill me-2"></i> Donate
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('report.death') ? 'active' : ''); ?>" 
                           href="<?php echo e(route('report.death')); ?>">
                           <i class="bi bi-file-earmark-medical-fill me-2"></i> Report a Death
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('notifications.index') ? 'active' : ''); ?>" 
                           href="<?php echo e(route('notifications.index')); ?>">
                           <i class="bi bi-bell me-2"></i> My Notifications
                           <?php if(Auth::user()->unreadNotifications->count() > 0): ?>
                               <span class="badge bg-danger"><?php echo e(Auth::user()->unreadNotifications->count()); ?></span>
                           <?php endif; ?>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endif; ?>
        </ul>

        <hr class="bg-secondary">

        <ul class="nav flex-column px-2 mb-3">
            <?php if(auth()->guard()->check()): ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('profile.edit') ? 'active' : ''); ?>" 
                       href="<?php echo e(route('profile.edit')); ?>">
                       <i class="bi bi-person-circle me-2"></i> Edit Profile
                    </a>
                </li>
                <li class="nav-item">
                    <span class="nav-link text-light">
                        <i class="bi bi-person-badge me-2"></i> Hello, <?php echo e(auth()->user()->name); ?>

                    </span>
                </li>
                <li class="nav-item">
                    <form action="<?php echo e(route('logout')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-link nav-link text-start">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </button>
                    </form>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('login') ? 'active' : ''); ?>" 
                       href="<?php echo e(route('login')); ?>">
                       <i class="bi bi-box-arrow-in-right me-2"></i> Login
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>

    <!-- Sidebar toggle button (visible only on small screens) -->
    <button id="sidebarToggle" class="btn btn-dark d-lg-none">
        <i class="bi bi-list"></i>
    </button>

    <!-- Main Content -->
    <div id="content" class="p-4">
        <?php echo $__env->yieldContent('content'); ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('show');
        });
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\pundohub\resources\views/layouts/app.blade.php ENDPATH**/ ?>