<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="text-primary">Bereavement Cases</h2>
        <a href="<?php echo e(route('bereavement-cases.create')); ?>" class="btn btn-success">Add New Case</a>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if($cases->isEmpty()): ?>
        <div class="alert alert-info">No bereavement cases found.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Title</th>
                        <th>Member</th>
                        <th>Date of Death</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $cases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $case): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($case->title); ?></td>
                            <td><?php echo e($case->user->name ?? 'N/A'); ?></td>
                            <td><?php echo e($case->date_of_death->format('F d, Y')); ?></td>
                            <td><?php echo e($case->description ?? 'N/A'); ?></td>
                            <td class="d-flex">
                                <a href="<?php echo e(route('bereavement-cases.edit', $case->id)); ?>" class="btn btn-sm btn-warning me-2">Edit</a>
                                <form action="<?php echo e(route('bereavement-cases.destroy', $case->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pundohub\resources\views/bereavement-cases/index.blade.php ENDPATH**/ ?>