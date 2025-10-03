

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <h1 class="mb-4">Edit Bereavement Case</h1>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <form action="<?php echo e(route('bereavement-cases.update', $case->id)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="mb-3">
            <label for="title" class="form-label">Case Title</label>
            <input type="text" name="title" id="title" class="form-control" value="<?php echo e($case->title); ?>" required>
        </div>

        <div class="mb-3">
            <label for="member_id" class="form-label">Member</label>
            <select name="member_id" id="member_id" class="form-select" required>
                <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($member->id); ?>" <?php echo e($member->id == $case->member_id ? 'selected' : ''); ?>>
                        <?php echo e($member->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="date_of_death" class="form-label">Date of Death</label>
            <input type="date" name="date_of_death" id="date_of_death" class="form-control" value="<?php echo e($case->date_of_death->format('Y-m-d')); ?>" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="3"><?php echo e($case->description); ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Case</button>
        <a href="<?php echo e(route('bereavement-cases.index')); ?>" class="btn btn-secondary ms-2">Back to Cases</a>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pundohub\resources\views/bereavement-cases/edit.blade.php ENDPATH**/ ?>