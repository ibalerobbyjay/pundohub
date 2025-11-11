

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <h2 class="mb-4 fw-bold text-info text-center">
        <i class="bi bi-file-earmark-text-fill me-2 text-warning"></i> Bereavement Case Details
    </h2>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i> <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-lg rounded-4 mb-4 bg-dark text-light" 
         style="background: rgba(25,25,25,0.9); backdrop-filter: blur(12px);">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Case Title:</strong> <?php echo e($case->title); ?></p>
                    <p><strong>Member:</strong> <?php echo e($case->user->name); ?></p>
                    <p><strong>Date of Death:</strong> <?php echo e($case->date_of_death->format('F d, Y')); ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Name of Deceased:</strong> <?php echo e($case->description_name ?? 'N/A'); ?></p>
                    <p><strong>Service Type:</strong> <?php echo e($case->description_what ?? 'N/A'); ?></p>
                    <p><strong>Service Date & Time:</strong> 
                        <?php if($case->description_when): ?>
                            <?php echo e(\Carbon\Carbon::parse($case->description_when)->format('F d, Y g:i A')); ?>

                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </p>
                    <p><strong>Location:</strong> <?php echo e($case->description_where ?? 'N/A'); ?></p>
                </div>
            </div>
            
            <?php if($case->description_notes): ?>
                <div class="mt-3 pt-3 border-top border-secondary">
                    <p><strong>Additional Notes:</strong></p>
                    <p class="mb-0"><?php echo e($case->description_notes); ?></p>
                </div>
            <?php endif; ?>
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
                    <textarea name="remarks" id="remarks" class="form-control bg-dark text-light border-secondary" rows="4" placeholder="Add any remarks or updates about this case..."><?php echo e(old('remarks', $case->remarks)); ?></textarea>
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

<style>
.card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 255, 255, 0.15);
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pundohub\resources\views/bereavement-cases/show.blade.php ENDPATH**/ ?>