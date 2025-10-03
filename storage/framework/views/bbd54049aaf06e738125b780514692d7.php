

<?php $__env->startSection('content'); ?>
<h2>Bereavement Case Details</h2>

<?php if(session('success')): ?>
    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
<?php endif; ?>

<ul class="list-group mb-3">
    <li class="list-group-item"><strong>Member:</strong> <?php echo e($case->member->name); ?></li>
    <li class="list-group-item"><strong>Date of Death:</strong> <?php echo e($case->date_of_death); ?></li>
    <li class="list-group-item"><strong>Description:</strong> <?php echo e($case->description); ?></li>
</ul>

<!-- Editable Remarks -->
<form action="<?php echo e(route('bereavement-cases.updateRemarks', $case->id)); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <div class="form-group">
        <label for="remarks"><strong>Remarks:</strong></label>
        <textarea name="remarks" id="remarks" class="form-control" rows="4"><?php echo e(old('remarks', $case->remarks)); ?></textarea>
        <?php $__errorArgs = ['remarks'];
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

    <button type="submit" class="btn btn-primary mt-3">Update Remarks</button>
    <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-secondary mt-3">Back</a>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pundohub\resources\views/bereavement-cases/show.blade.php ENDPATH**/ ?>