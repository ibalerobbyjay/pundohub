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
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(to right, #1c1f26, #2a2f38);
        color: #fff;
        overflow-x: hidden;
        scroll-behavior: smooth;
    }

    header {
        background: rgba(0, 0, 0, 0.3);
        backdrop-filter: blur(10px);
    }

    .hero {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        text-align: center;
        background: url("<?php echo e(asset('images/background.jpg')); ?>") no-repeat center center/cover;
        position: relative;
    }

    .hero::before {
        content: "";
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.55);
    }

    .hero-content {
        position: relative;
        z-index: 1;
        max-width: 700px;
    }

    .hero h1 {
        font-size: 3rem;
        font-weight: 700;
    }

    .hero p {
        font-size: 1.2rem;
        color: #dcdcdc;
        margin: 20px 0;
    }

    /* ✅ White Button */
    .btn-login {
        background-color: #fff;
        color: black;
        font-weight: 600;
        border: none;
        padding: 12px 28px;
        border-radius: 30px;
        transition: 0.3s ease;
        position: relative;
        box-shadow: 0 4px 10px rgba(255, 255, 255, 0.3);
    }

    .btn-login:hover {
        background-color: #e6e6e6;
        box-shadow: 0 6px 15px rgba(255, 255, 255, 0.4);
    }

    /* ✅ Members Section */
    #members img {
        border: 3px solid #fff;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    #members img:hover {
        transform: scale(1.05);
        box-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
    }
    

    /* ✅ Tech Stack */
    #tech-stack {
        background-color: #0f1117;
    }

    .tech-item {
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        padding: 10px 20px;
        font-weight: 500;
        transition: 0.3s ease;
    }

    .tech-item:hover {
        background-color: rgba(255, 255, 255, 0.25);
        transform: scale(1.05);
    }

    footer {
        text-align: center;
        padding: 20px 0;
        background-color: rgba(0, 0, 0, 0.4);
        backdrop-filter: blur(10px);
    }

    /* ✅ Back-to-Top Button */
    #backToTop {
        position: fixed;
        bottom: 25px;
        right: 25px;
        background: white;
        color: black;
        border: none;
        border-radius: 50%;
        width: 45px;
        height: 45px;
        font-size: 1.5rem;
        box-shadow: 0 4px 10px rgba(255, 255, 255, 0.3);
        cursor: pointer;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        z-index: 1000;
    }

    #backToTop.show {
        opacity: 1;
        visibility: visible;
    }

    /* ✅ Modals */
    .modal-content {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        color: #fff;
        box-shadow: 0 0 20px rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
    }

    .modal-content:hover {
        box-shadow: 0 0 30px rgba(255, 255, 255, 0.35);
    }

    .modal-header {
        border-bottom: 1px solid rgba(255, 255, 255, 0.4);
    }

    .modal-title {
        font-weight: 700;
        color: #fff;
    }

    .form-control {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: #fff;
        border-radius: 10px;
    }
    a{
        color: #fff;
        cursor: pointer;
    }

    .form-control:focus {
        background: rgba(255, 255, 255, 0.15);
        border-color: white;
        box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.25);
    }

    .form-label {
        color: #fff;
        font-weight: 500;
    }

    .form-check-label {
        color: #ddd;
    }

    .btn-close {
        filter: invert(1);
    }
    .text-muted {
    color: rgba(255, 255, 255, 0.7) !important;
}
        
    </style>
</head>
<body>

    <!-- ✅ Navbar -->
    <header class="py-3 shadow-sm">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Logo" class="me-2" style="width: 50px; height: 50px; border-radius: 50%;">
                <h4 class="mb-0 fw-bold">
                    Pundo<span style="background-color: white; color: black; padding: 2px 6px; border-radius: 4px;">Hub</span>
                </h4>
            </div>
            <button class="btn btn-login" data-bs-toggle="modal" data-bs-target="#loginModal">
                <i class="bi bi-box-arrow-in-right me-1"></i> Log In
            </button>
        </div>
    </header>

    <!-- ✅ Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>
                Welcome to Pundo<span style="background-color: white; color: black; padding: 2px 6px; border-radius: 6px;">Hub</span>
            </h1>
            <p>PundoHub is a compassionate platform designed to support families in times of loss. 
               We connect communities, manage bereavement cases, and streamline donations with transparency and care.</p>
            <button class="btn btn-login mt-3" data-bs-toggle="modal" data-bs-target="#loginModal">Get Started</button>
        </div>
    </section>

    <!-- ✅ Members Section -->
    <section id="members" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5 fw-bold">Meet Our Team</h2>
            <div class="row g-4 justify-content-center">
                <div class="col-md-4 text-center">
                    <img src="https://via.placeholder.com/150" class="rounded-circle mb-3" alt="Robby Jay Ibale" width="150" height="150">
                    <h5>Robby Jay Ibale</h5>
                    <p class="text-muted">Leader / Full Stack Developer</p>
                </div>
                <div class="col-md-4 text-center">
                    <img src="https://via.placeholder.com/150" class="rounded-circle mb-3" alt="Cherry Ann Cagoco" width="150" height="150">
                    <h5>Cherry Ann Cagoco</h5>
                    <p class="text-muted">Presenter / Assistant Leader</p>
                </div>
                <div class="col-md-4 text-center">
                    <img src="https://via.placeholder.com/150" class="rounded-circle mb-3" alt="Ageneth Balahay" width="150" height="150">
                    <h5>Ageneth Balahay</h5>
                    <p class="text-muted">System Analyst</p>
                </div>
                <div class="col-md-4 text-center">
                    <img src="https://via.placeholder.com/150" class="rounded-circle mb-3" alt="Angel Mae Quinlog" width="150" height="150">
                    <h5>Angel Mae Quinlog</h5>
                    <p class="text-muted">Documentation</p>
                </div>
                <div class="col-md-4 text-center">
                    <img src="https://via.placeholder.com/150" class="rounded-circle mb-3" alt="Christian Bautista" width="150" height="150">
                    <h5>Christian Bautista</h5>
                    <p class="text-muted">Documentation</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ✅ Tech Stack -->
    <section id="tech-stack" class="py-5 text-center">
        <div class="container">
            <h2 class="mb-5 fw-bold">Our Tech Stack</h2>
            <div class="d-flex justify-content-center flex-wrap gap-3">
                <div class="tech-item">Laravel</div>
                <div class="tech-item">Bootstrap 5</div>
                <div class="tech-item">MySQL / MariaDB</div>
                <div class="tech-item">PHP 8+</div>
                <div class="tech-item">JavaScript</div>
                <div class="tech-item">HTML5 & CSS3</div>
            </div>
        </div>
    </section>

    <!-- ✅ Footer -->
    <footer>
        <p class="mb-0">
            &copy; <?php echo e(date('Y')); ?> Pundo<span style="background-color: white; color: black; padding: 2px 6px; border-radius: 4px;">Hub</span>. 
            All rights reserved.
        </p>
    </footer>

    <!-- ✅ Back to Top Button -->
    <button id="backToTop" title="Back to top"><i class="bi bi-arrow-up-short"></i></button>

    <!-- ✅ Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-dark rounded-4">
                <div class="modal-header">
                   <h5 class="modal-title" id="loginModalLabel"> Log In to Pundo<span style="background-color: white; color: black; padding: 2px 6px; border-radius: 4px;">Hub</span> </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="loginForm" method="POST" action="<?php echo e(route('login')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" class="form-control" type="email" name="email" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" class="form-control" type="password" name="password" required>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                            <label class="form-check-label" for="remember_me">Remember me</label>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                           <a href="<?php echo e(route('password.request')); ?>" class="small text-decoration-none">Forgot password?</a>

                            <button type="submit" id="loginBtn" class="btn btn-login d-flex align-items-center justify-content-center">
                                <span class="btn-text">Log In</span>
                                <span class="spinner-border spinner-border-sm text-dark ms-2 d-none"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

   
    <!-- ✅ Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Show back-to-top button
    const backToTop = document.getElementById("backToTop");
    window.addEventListener("scroll", () => {
        if (window.scrollY > 300) backToTop.classList.add("show");
        else backToTop.classList.remove("show");
    });
    backToTop.addEventListener("click", () => window.scrollTo({ top: 0, behavior: "smooth" }));

    // Loading spinner
    function handleLoading(formId, btnId) {
        const form = document.getElementById(formId);
        const btn = document.getElementById(btnId);
        const spinner = btn.querySelector('.spinner-border');
        const text = btn.querySelector('.btn-text');
        form.addEventListener('submit', () => {
            btn.classList.add('loading');
            spinner.classList.remove('d-none');
            text.textContent = 'Please wait...';
        });
    }
    handleLoading('loginForm', 'loginBtn');
    handleLoading('forgotForm', 'forgotBtn');
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\pundohub\resources\views/auth/login.blade.php ENDPATH**/ ?>