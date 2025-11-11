

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <h2 class="text-info mb-4">Your Donation History</h2>

    <!-- Total Donations Card -->
    <div class="card bg-gradient shadow-lg text-light rounded-4 mb-4 p-3 border-secondary">
        <h5 class="text-warning mb-2">Total Donations</h5>
        <p class="fs-4 fw-bold">₱ <?php echo e(number_format($total, 2)); ?></p>
    </div>

    <?php if($donations->count() > 0): ?>
        <div class="table-responsive">
            <table class="table table-dark table-striped table-bordered align-middle text-light rounded-3">
                <thead class="table-secondary text-dark">
                    <tr>
                        <th>Date</th>
                        <th>Bereavement Case</th>
                        <th>Amount (₱)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $donations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $donation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="donation-row">
                            <td><?php echo e($donation->created_at->format('F j, Y g:i A')); ?></td>
                            <td><?php echo e($donation->bereavementCase->title ?? 'N/A'); ?></td>
                            <td class="fw-semibold text-success">₱ <?php echo e(number_format($donation->amount, 2)); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-muted">You haven’t made any donations yet.</p>
    <?php endif; ?>

    <div class="mt-4">
        <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-outline-info rounded-pill px-4">
            ← Back to Dashboard
        </a>
    </div>
</div>

<style>
/* Hover effect for table rows */
.donation-row:hover {
    background-color: rgba(255, 255, 255, 0.1);
    transition: background-color 0.3s ease;
}

/* Rounded table borders */
.table {
    border-radius: 12px;
    overflow: hidden;
}

/* Card gradient */
.card.bg-gradient {
    background: linear-gradient(145deg, rgba(30,30,30,0.95), rgba(50,50,50,0.95));
}

/* Table header colors */
.table thead {
    background-color: rgba(255, 255, 255, 0.15);
}

/* Total Donations text emphasis */
.card h5 {
    letter-spacing: 0.5px;
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pundohub\resources\views/donations/history.blade.php ENDPATH**/ ?>