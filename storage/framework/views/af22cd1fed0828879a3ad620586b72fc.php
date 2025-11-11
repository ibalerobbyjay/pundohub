<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-white fw-bold">
            <i class="bi bi-file-earmark-text me-2"></i>Bereavement Cases
        </h2>
      
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if($cases->isEmpty()): ?>
        <div class="alert alert-info shadow-sm rounded-3">
            No bereavement cases found.
        </div>
    <?php else: ?>
        <div class="table-responsive shadow-sm rounded-4">
            <table class="table table-hover table-dark align-middle mb-0">
                <thead class="table-secondary text-dark">
                    <tr>
                        <th>Title</th>
                        <th>Member</th>
                        <th>Date of Death</th>
                        <th>Name of the Deceased</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $cases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $case): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="bg-dark text-light">
                            <td><?php echo e($case->title); ?></td>
                            <td><?php echo e($case->user->name ?? 'N/A'); ?></td>
                            <td><?php echo e($case->date_of_death->format('F d, Y')); ?></td>
                            <td><?php echo e($case->description_name ?? 'N/A'); ?></td>
                            <td class="d-flex justify-content-center">
                                <a href="<?php echo e(route('bereavement-cases.edit', $case->id)); ?>" 
                                   class="btn btn-sm btn-warning me-2 shadow-sm">
                                   <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="<?php echo e(route('bereavement-cases.destroy', $case->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-danger shadow-sm"
                                            onclick="return confirm('Are you sure you want to delete this case?')">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<a href="<?php echo e(route('dashboard')); ?>" class="btn btn-outline-light mt-3 shadow-sm">
    ← Back to Dashboard
</a>


<style>
.table-hover tbody tr:hover {
    transform: translateY(-2px);
    transition: transform 0.15s ease;
    box-shadow: 0 4px 12px rgba(0, 255, 255, 0.2);
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pundohub\resources\views/bereavement-cases/index.blade.php ENDPATH**/ ?>