<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg rounded-4 text-light"
                 style="background: rgba(20, 20, 20, 0.9); backdrop-filter: blur(10px);">
                <div class="card-body p-5">
                    <h2 class="mb-4 text-info text-center">
                        <i class="bi bi-heartbreak-fill me-2"></i> Add New Bereavement Case
                    </h2>

                    
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger rounded-3">
                            <ul class="mb-0">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    
                    <form action="<?php echo e(route('bereavement-cases.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>

                        <div class="mb-4">
                            <label for="title" class="form-label fw-semibold text-light">
                                Title <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="title" 
                                   id="title" 
                                   class="form-control bg-dark text-light border-secondary rounded-3"
                                   value="<?php echo e(old('title')); ?>" required
                                   placeholder="Enter case title">
                        </div>

           <div class="mb-4">
    <label for="user_id" class="form-label fw-semibold text-light">
        Select Member <span class="text-danger">*</span>
    </label>
    <select name="user_id" id="user_id" 
            class="form-select bg-dark text-light border-secondary rounded-3" required>
        <option value="">-- Select Member --</option>
        <?php $__currentLoopData = $assignableUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($user->id); ?>" <?php echo e(old('user_id') == $user->id ? 'selected' : ''); ?>>
                <?php echo e($user->name); ?> (<?php echo e(ucfirst($user->role)); ?>)
            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>


                        <div class="mb-4">
                            <label for="date_of_death" class="form-label fw-semibold text-light">
                                Date of Death <span class="text-danger">*</span>
                            </label>
                            <input type="date" 
                                   name="date_of_death" 
                                   id="date_of_death" 
                                   class="form-control bg-dark text-light border-secondary rounded-3"
                                   value="<?php echo e(old('date_of_death')); ?>" required>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label fw-semibold text-light">
                                Description
                            </label>
                            <textarea name="description" 
                                      id="description" 
                                      class="form-control bg-dark text-light border-secondary rounded-3" 
                                      rows="4"
                                      placeholder="Write a short description..."><?php echo e(old('description')); ?></textarea>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="<?php echo e(route('bereavement-cases.index')); ?>" class="btn btn-outline-light me-2 rounded-3">
                                <i class="bi bi-arrow-left"></i> Back
                            </a>
                            <button type="submit" class="btn btn-info text-dark fw-bold rounded-3 px-4">
                                <i class="bi bi-plus-circle me-1"></i> Add Case
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 0.25rem rgba(0, 255, 255, 0.25);
        border-color: #17a2b8;
    }
    .btn-info:hover {
        background-color: #0dcaf0 !important;
        color: #000 !important;
        box-shadow: 0 0 10px rgba(13, 202, 240, 0.6);
    }
    .btn-outline-light:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pundohub\resources\views/bereavement-cases/create.blade.php ENDPATH**/ ?>