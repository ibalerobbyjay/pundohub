

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <h2 class="text-primary mb-3">Bereavement Case Details</h2>

    <div class="card mb-3">
        <div class="card-body">
            <p><strong>Bereavement:</strong> <?php echo e($case->title); ?></p>
            <p><strong>Member:</strong> <?php echo e($case->user->name); ?></p>
            <p><strong>Date of Death:</strong> <?php echo e($case->date_of_death->format('F d, Y')); ?></p>
            <p><strong>Description:</strong> <?php echo e($case->description ?? 'N/A'); ?></p>
        </div>
    </div>

    <form action="<?php echo e(route('bereavement-cases.updateRemarks', $case->id)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="mb-3">
            <label for="remarks" class="form-label"><strong>Remarks</strong></label>
            <textarea name="remarks" id="remarks" class="form-control" rows="4"><?php echo e(old('remarks', $case->remarks)); ?></textarea>
        </div>

        <button type="submit" class="btn btn-success">Update Remarks</button>
        <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-secondary ms-2">Back to Dashboard</a>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pundohub\resources\views/bereavement-cases/show.blade.php ENDPATH**/ ?>