<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <h2 class="mb-4">Add Donation</h2>

    <form action="<?php echo e(route('donations.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <!-- Donor (auto-filled) -->
        <div class="mb-3">
            <label class="form-label">Donor</label>
            <input type="text" class="form-control" 
                   value="<?php echo e(Auth::user()->name); ?>" readonly>
        </div>

        <!-- Type -->
        <!-- Type -->
<div class="mb-3">
    <label for="type" class="form-label">Donation Type</label>
    <select name="type" id="type" class="form-select" required>
        <option value="">Select type</option>
        <option value="Firewood">Firewood</option>
        <option value="Rice">Rice</option>
    </select>
</div>

        <!-- Amount -->
        <div class="mb-3">
            <label for="amount" class="form-label">Amount</label>
            <input type="number" name="amount" id="amount" class="form-control" step="0.01" required>
        </div>

        <!-- Optional Bereavement Case -->
        <div class="mb-3">
            <label for="bereavement_case_id" class="form-label">Bereavement Case (optional)</label>
            <select name="bereavement_case_id" id="bereavement_case_id" class="form-select">
                <option value="">None</option>
                <?php $__currentLoopData = $cases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $case): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                   <option value="<?php echo e($case->id); ?>">
    <?php echo e($case->title); ?> (<?php echo e($case->user->name ?? 'Unknown Member'); ?>)
</option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Save Donation</button>
    </form>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pundohub\resources\views/donations/create.blade.php ENDPATH**/ ?>