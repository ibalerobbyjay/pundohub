

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <h2 class="mb-4 fw-bold text-info text-center">
        <i class="bi bi-file-earmark-text-fill me-2 text-warning"></i> Bereavement Case Details
    </h2>

    <div class="card shadow-lg rounded-4 mb-4 bg-dark text-light" 
         style="background: rgba(25,25,25,0.9); backdrop-filter: blur(12px);">
        <div class="card-body">
            <p><strong>Bereavement:</strong> <?php echo e($case->title); ?></p>
            <p><strong>Member:</strong> <?php echo e($case->user->name); ?></p>
            <p><strong>Date of Death:</strong> <?php echo e($case->date_of_death->format('F d, Y')); ?></p>
            <p><strong>Description:</strong> <?php echo e($case->description ?? 'N/A'); ?></p>
        </div>
    </div>

    <div class="card shadow-lg rounded-4 bg-dark text-light" 
         style="background: rgba(25,25,25,0.9); backdrop-filter: blur(12px);">
        <div class="card-body">
            <form action="<?php echo e(route('bereavement-cases.updateRemarks', $case->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="mb-3">
                    <label for="remarks" class="form-label"><strong>Remarks</strong></label>
                    <textarea name="remarks" id="remarks" class="form-control bg-dark text-light border-secondary" rows="4"><?php echo e(old('remarks', $case->remarks)); ?></textarea>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-3">
                    <button type="submit" class="btn btn-success rounded-pill px-4">
                        <i class="bi bi-check-circle me-1"></i> Update Remarks
                    </button>
                    <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="bi bi-arrow-left-circle me-1"></i> Back to Dashboard
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pundohub\resources\views/bereavement-cases/show.blade.php ENDPATH**/ ?>