<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PundoHub</title>

    <!-- ✅ Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        body { overflow-x: hidden; }
        #sidebar { width: 250px; height: 100vh; position: fixed; top: 0; left: 0; background: #343a40; color: white; transition: transform 0.3s ease-in-out; z-index: 1050; }
        #sidebar .nav-link { color: #adb5bd; font-weight: 500; }
        #sidebar .nav-link:hover, #sidebar .nav-link.active { background: #495057; color: #fff; }
        #content { flex-grow: 1; margin-left: 250px; padding: 20px; min-height: 100vh; background: url("<?php echo e(asset('images/background.jpg')); ?>") no-repeat center center fixed; background-size: cover; color: #fff; transition: margin-left 0.3s ease-in-out; }
        .card { background-color: #d8d7d7; color: #333; border: none; border-radius: 12px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15); transition: transform 0.2s ease, box-shadow 0.2s ease; padding: 1rem; }
        .card:hover { transform: translateY(-4px); box-shadow: 0 10px 20px rgba(0, 0, 0, 0.25); }
        .logo-img { width: 60px; height: 60px; border-radius: 50%; object-fit: cover; }
        @media (max-width: 992px) { #sidebar { transform: translateX(-100%); } #sidebar.show { transform: translateX(0); } #content { margin-left: 0; } }
        #sidebarToggle { position: fixed; top: 15px; left: 15px; z-index: 1100; }
        #loadingSpinner { display: none; opacity: 0; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.6); z-index: 2000; justify-content: center; align-items: center; transition: opacity 0.3s ease; pointer-events: none; }
        #loadingSpinner.active { display: flex; opacity: 1; pointer-events: all; }
        .spinner-border { width: 3rem; height: 3rem; }
        body.modal-open { overflow: hidden !important; padding-right: 0 !important; }
    </style>
</head>
<body>

    <!-- ✅ Global Loading Spinner -->
    <div id="loadingSpinner" class="d-flex">
        <div class="spinner-border text-light" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- ✅ Sidebar -->
    <nav id="sidebar" class="bg-dark">
        <div class="text-center py-4 border-bottom border-secondary">
            <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Logo" class="logo-img mb-2">
            <h5 class="text-white">PundoHub</h5>
        </div>

        <ul class="nav flex-column mt-3 px-2">
            <?php if(auth()->guard()->check()): ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('dashboard')); ?>">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>

                <?php if(auth()->user()->role === 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('bereavement-cases.*') ? 'active' : ''); ?>" href="<?php echo e(route('bereavement-cases.index')); ?>">
                            <i class="bi bi-people me-2"></i> Bereavement Cases
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.death-reports.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.death-reports.index')); ?>">
                            <i class="bi bi-file-earmark-medical-fill me-2"></i> Death Reports
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('donations.*') ? 'active' : ''); ?>" href="<?php echo e(route('donations.index')); ?>">
                            <i class="bi bi-cash-coin me-2"></i> Donations
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('notifications.index') ? 'active' : ''); ?>" href="<?php echo e(route('notifications.index')); ?>">
                            <i class="bi bi-bell me-2"></i> Notifications
                            <?php if(Auth::user()->unreadNotifications->count() > 0): ?>
                                <span class="badge bg-danger"><?php echo e(Auth::user()->unreadNotifications->count()); ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('members.*') ? 'active' : ''); ?>" href="<?php echo e(route('members.index')); ?>">
                            <i class="bi bi-person-lines-fill me-2"></i> Members
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('donations.create') ? 'active' : ''); ?>" href="<?php echo e(route('donations.create')); ?>">
                            <i class="bi bi-heart-fill me-2"></i> Donate
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('report.death') ? 'active' : ''); ?>" href="<?php echo e(route('report.death')); ?>">
                            <i class="bi bi-file-earmark-medical-fill me-2"></i> Report a Death
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('notifications.index') ? 'active' : ''); ?>" href="<?php echo e(route('notifications.index')); ?>">
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
        <li class="nav-item dropdown text-center">
            <a class="nav-link dropdown-toggle text-light d-flex align-items-center justify-content-center" 
               href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle me-2"></i>
                <?php echo e(auth()->user()->name); ?>

            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow border-0 mt-2" 
                aria-labelledby="userDropdown">
                <li>
                    <a class="dropdown-item <?php echo e(request()->routeIs('profile.edit') ? 'active' : ''); ?>" 
                       href="<?php echo e(route('profile.edit')); ?>">
                        <i class="bi bi-pencil-square me-2"></i> Edit Profile
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form id="logoutForm" action="<?php echo e(route('logout')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </li>
    <?php else: ?>
        <li class="nav-item">
            <a class="nav-link <?php echo e(request()->routeIs('login') ? 'active' : ''); ?>" href="<?php echo e(route('login')); ?>">
                <i class="bi bi-box-arrow-in-right me-2"></i> Login
            </a>
        </li>
    <?php endif; ?>
</ul>

    </nav>

    <!-- Sidebar toggle button -->
    <button id="sidebarToggle" class="btn btn-dark d-lg-none">
        <i class="bi bi-list"></i>
    </button>

    <!-- Main Content -->
    <div id="content" class="p-4">
        <?php echo $__env->yieldContent('content'); ?>
    </div>

    <!-- ✅ Logout Confirmation Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">Are you sure you want to log out?</div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button id="confirmLogoutBtn" type="button" class="btn btn-danger">Logout</button>
          </div>
        </div>
      </div>
    </div>

    <!-- ✅ Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const spinner = document.getElementById('loadingSpinner');

        function showSpinner() { spinner.classList.add('active'); }
        function hideSpinner() { spinner.classList.remove('active'); }

        // Sidebar toggle
        document.getElementById('sidebarToggle').addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('show');
        });

        // Spinner on navigation
        const navLinks = document.querySelectorAll('#sidebar a.nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', function (e) {
                if (this.getAttribute('href') === '#' || this.classList.contains('active')) return;
                showSpinner();
            });
        });

        // Hide spinner after full load
        window.addEventListener('load', () => {
            hideSpinner();
            setTimeout(hideSpinner, 3000);
        });

        // ✅ Logout Confirmation
        const logoutForm = document.getElementById('logoutForm');
        const confirmLogoutBtn = document.getElementById('confirmLogoutBtn');

        if (logoutForm && confirmLogoutBtn) {
            logoutForm.addEventListener('submit', function(e) {
                e.preventDefault(); // prevent immediate logout
                const logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'));
                logoutModal.show();

                confirmLogoutBtn.addEventListener('click', function() {
                    logoutForm.submit();
                }, { once: true });
            });
        }

        // ✅ Optional: Show "Login Successful" alert
        <?php if(session('success') && request()->routeIs('dashboard')): ?>
            alert("<?php echo e(session('success')); ?>");
        <?php endif; ?>
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\pundohub\resources\views/layouts/app.blade.php ENDPATH**/ ?>