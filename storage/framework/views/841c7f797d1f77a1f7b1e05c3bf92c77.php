<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="card border-0 shadow-lg rounded-4 bg-dark text-light" 
                 style="background: rgba(20,20,20,0.85); backdrop-filter: blur(10px);">
                 
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
    <h2 class="mb-0 fw-bold text-info">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>Penalties Dashboard
    </h2>
</div>


                <div class="card-body">
                    <?php if($penalties->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-dark table-hover align-middle">
                                <thead class="table-light text-dark">
                                    <tr>
                                        <th>User</th>
                                        <th>Amount (₱)</th>
                                        <th>Reason</th>
                                        <th>Date Applied</th>
                                        <th>Status</th> <!-- New column for Paid button -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $penalties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $penalty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($penalty->user->name ?? 'Unknown'); ?></td>
                                            <td>₱<?php echo e(number_format($penalty->amount, 2)); ?></td>
                                            <td><?php echo e($penalty->reason); ?></td>
                                            <td><?php echo e(\Carbon\Carbon::parse($penalty->applied_at)->format('F d, Y g:i A')); ?></td>
                                            <td>
                                                <?php if($penalty->paid): ?>
                                                    <span class="badge bg-success">Paid</span>
                                                <?php else: ?>
                                                    <form action="<?php echo e(route('penalties.markPaid', $penalty->id)); ?>" method="POST">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PATCH'); ?>
                                                        <button type="submit" class="btn btn-sm btn-primary">Mark as Paid</button>
                                                    </form>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-3">
                            <?php echo e($penalties->links('pagination::bootstrap-5')); ?>

                        </div>
                    <?php else: ?>
                        <p class="text-center text-muted">No penalties recorded yet.</p>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<style>
.table-hover tbody tr:hover {
    transform: translateY(-2px);
    transition: transform 0.15s ease;
    box-shadow: 0 4px 12px rgba(0, 255, 255, 0.2);
}
</style>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pundohub\resources\views/admin/penalties.blade.php ENDPATH**/ ?>