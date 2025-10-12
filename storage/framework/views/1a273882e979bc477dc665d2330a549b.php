<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <h2 class="mb-4 text-primary">Add New Bereavement Case</h2>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('bereavement-cases.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <div class="mb-3">
            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
            <input type="text" name="title" id="title" class="form-control" value="<?php echo e(old('title')); ?>" required>
        </div>

        <div class="mb-3">
            <label for="user_id" class="form-label">Member <span class="text-danger">*</span></label>
            <select name="user_id" id="user_id" class="form-select" required>
                <option value="">-- Select Member --</option>
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($user->id); ?>" <?php echo e(old('user_id') == $user->id ? 'selected' : ''); ?>>
                        <?php echo e($user->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="date_of_death" class="form-label">Date of Death <span class="text-danger">*</span></label>
            <input type="date" name="date_of_death" id="date_of_death" class="form-control" value="<?php echo e(old('date_of_death')); ?>" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="4"><?php echo e(old('description')); ?></textarea>
        </div>

        <button type="submit" class="btn btn-success">Add Case</button>
        <a href="<?php echo e(route('bereavement-cases.index')); ?>" class="btn btn-secondary ms-2">Back to Cases</a>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pundohub\resources\views/bereavement-cases/create.blade.php ENDPATH**/ ?>