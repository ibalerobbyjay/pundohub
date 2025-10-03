

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Bereavement Cases</h2>
        <a href="<?php echo e(route('bereavement-cases.create')); ?>" class="btn btn-primary">Add New Case</a>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if($cases->isEmpty()): ?>
        <p>No bereavement cases found.</p>
    <?php else: ?>
        <div class="row">
            <?php $__currentLoopData = $cases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $case): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-6 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo e($case->title); ?></h5>
                            <p class="card-text"><strong>Member:</strong> <?php echo e($case->member->name ?? 'N/A'); ?></p>
                            <p class="card-text"><strong>Date of Death:</strong> <?php echo e($case->date_of_death); ?></p>
                            <p class="card-text"><strong>Description:</strong> <?php echo e($case->description ?? 'N/A'); ?></p>
                            <a href="<?php echo e(route('bereavement-cases.edit', $case->id)); ?>" class="btn btn-sm btn-warning me-2">Edit</a>
                            <form action="<?php echo e(route('bereavement-cases.destroy', $case->id)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pundohub\resources\views/bereavement-cases/index.blade.php ENDPATH**/ ?>