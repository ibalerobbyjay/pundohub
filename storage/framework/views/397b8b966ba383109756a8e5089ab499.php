<?php $__env->startSection('content'); ?>
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card border-0 shadow-lg rounded-4 bg-dark text-light px-4 py-5"
         style="background: rgba(20,20,20,0.85); backdrop-filter: blur(12px); max-width: 500px; width: 100%;">

        <div class="text-center mb-4">
            <i class="bi bi-key-fill text-warning fs-1 mb-3"></i>
            <h3 class="fw-bold text-info">Forgot Password</h3>
            <p class="text-secondary small mt-2">
                No worries! Enter your registered email and we’ll send you a reset link.
            </p>
        </div>

        
        <?php if(session('status')): ?>
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm">
                <?php echo e(session('status')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('password.email')); ?>">
            <?php echo csrf_field(); ?>

            
            <div class="mb-4">
                <label for="email" class="form-label text-light">Email Address <span class="text-danger">*</span></label>
                <input id="email" type="email" name="email"
                       class="form-control bg-dark text-light border-secondary rounded-3 shadow-sm"
                       placeholder="Enter your registered email" value="<?php echo e(old('email')); ?>" required autofocus>
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <small class="text-danger"><?php echo e($message); ?></small>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div class="d-grid">
                <button type="submit" class="btn btn-primary rounded-pill shadow-sm py-2 fw-semibold">
                    <i class="bi bi-envelope-paper me-1"></i> Send Password Reset Link
                </button>
            </div>

            
            <div class="text-center mt-3">
                <a href="<?php echo e(route('login')); ?>" class="text-decoration-none text-info small">
                    <i class="bi bi-arrow-left-circle me-1"></i> Back to Login
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pundohub\resources\views/auth/forgot-password.blade.php ENDPATH**/ ?>