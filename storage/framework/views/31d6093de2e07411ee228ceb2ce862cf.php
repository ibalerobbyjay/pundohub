

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <h2 class="mb-4 text-white">Report a Death</h2>

    <!-- Success Message -->
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card bg-dark text-white border-secondary">
        <div class="card-body">
            <form action="<?php echo e(route('report.death.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <!-- Name of Deceased -->
                <div class="mb-3">
                    <label for="name_of_deceased" class="form-label">Name of Deceased <span class="text-danger">*</span></label>
                    <input type="text" 
                           id="name_of_deceased" 
                           name="name_of_deceased" 
                           class="form-control bg-dark text-white border-secondary" 
                           required>
                </div>

                <!-- Date of Death -->
                <div class="mb-3">
                    <label for="date_of_death" class="form-label">Date of Death</label>
                    <input type="date" 
                           id="date_of_death" 
                           name="date_of_death" 
                           class="form-control bg-dark text-white border-secondary">
                </div>

                <!-- Notes -->
                <div class="mb-3">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea id="notes" 
                              name="notes" 
                              rows="4" 
                              class="form-control bg-dark text-white border-secondary"
                              placeholder="Optional: add any relevant details..."></textarea>
                </div>

                <button type="submit" class="btn btn-primary w-100">Submit Report</button>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pundohub\resources\views/death_reports/create.blade.php ENDPATH**/ ?>