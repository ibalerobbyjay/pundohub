

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <h1 class="mb-4">Edit Member</h1>

    <form action="<?php echo e(route('members.update', $member->id)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="mb-3">
            <label for="name" class="form-label">Member Name</label>
            <input type="text" name="name" id="name" class="form-control" 
                   value="<?php echo e($member->name); ?>" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" name="email" id="email" class="form-control" 
                   value="<?php echo e($member->email); ?>" required>
        </div>

        <div class="mb-3">
            <label for="household" class="form-label">Household</label>
            <input type="text" name="household" id="household" class="form-control" 
                   value="<?php echo e($member->household); ?>" required>
        </div>

        <div class="mb-3">
            <label for="contact" class="form-label">Contact Number</label>
            <input type="text" name="contact" id="contact" class="form-control" 
                   value="<?php echo e($member->contact); ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Member</button>
        <a href="<?php echo e(route('members.index')); ?>" class="btn btn-secondary ms-2">Back to Members</a>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pundohub\resources\views/members/edit.blade.php ENDPATH**/ ?>