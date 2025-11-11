<?php $__env->startSection('content'); ?>
<div class="container my-5">
    <div class="card border-0 shadow-lg rounded-4 bg-dark text-light" 
         style="background: rgba(25,25,25,0.9); backdrop-filter: blur(12px);">
        <div class="card-body p-4">
            <h2 class="mb-4 fw-bold text-info text-center">
                <i class="bi bi-heart-fill me-2 text-danger"></i> All Donations
            </h2>

            <!-- Delete All Button -->
            <?php if(auth()->user()->role === 'admin' && $donations->count() > 0): ?>
            <div class="mb-3 text-end">
                <form action="<?php echo e(route('donations.deleteAll')); ?>" method="POST" class="d-inline" 
                      onsubmit="return confirmDeleteAll()">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger rounded-pill px-4">
                        <i class="bi bi-trash-fill me-2"></i>Delete All Donations
                    </button>
                </form>
            </div>
            <?php endif; ?>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-hover table-dark align-middle text-center text-light">
                    <thead style="background-color: #1a1a1a; color: #f8f9fa;" class="text-uppercase small">
                        <tr>
                            <th>Donor Name</th>
                            <th>Bereavement Case</th>
                            <th>Amount</th>
                            <th>Type</th>
                            <th>Proof</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $donations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $donation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($donation->user->name ?? 'N/A'); ?></td>
                            <td><?php echo e($donation->bereavementCase->title ?? 'N/A'); ?></td>
                            <td>
                                <?php if($donation->type === 'Money'): ?>
                                    <span class="fw-semibold text-success">₱<?php echo e(number_format($donation->amount, 2)); ?></span>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge 
                                    <?php echo e($donation->type === 'Money' ? 'bg-success' : 'bg-warning text-dark'); ?>">
                                    <?php echo e($donation->type); ?>

                                </span>
                            </td>
                            <td>
                                <?php if($donation->proof): ?>
                                    <a href="<?php echo e(asset('storage/' . $donation->proof)); ?>" target="_blank" 
                                       class="btn btn-sm btn-outline-info fw-semibold">
                                        View Proof
                                    </a>
                                <?php else: ?>
                                    <span class="text-light fst-italic">No proof</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if(auth()->user()->role === 'admin'): ?>
                                <form action="<?php echo e(route('donations.destroy', $donation->id)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-outline-danger btn-sm rounded-pill px-3"
                                            onclick="return confirm('Are you sure you want to delete this donation?')">
                                        <i class="bi bi-trash me-1"></i> Delete
                                    </button>
                                </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                    No donations found.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-outline-info rounded-pill px-4">
                    ← Back to Dashboard
                </a>
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

<script>
function confirmDeleteAll() {
    const donationCount = <?php echo e($donations->count()); ?>;
    return confirm(`Are you sure you want to delete ALL ${donationCount} donations? This action cannot be undone!`);
}
</script>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pundohub\resources\views/donations/index.blade.php ENDPATH**/ ?>