

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <h2 class="mb-4 text-white fw-bold">Monthly Fund Contributions</h2>

    
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    
    <?php if(auth()->user()->role === 'admin' && $funds->count() > 0): ?>
    <div class="mb-3 text-end">
        <form action="<?php echo e(route('monthlyfunds.deleteAll')); ?>" method="POST" class="d-inline" 
              onsubmit="return confirmDeleteAll()">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button type="submit" class="btn btn-danger rounded-pill px-4">
                <i class="bi bi-arrow-clockwise me-2"></i>Reset All Records
            </button>
        </form>
    </div>
    <?php endif; ?>

    
    <?php if(auth()->user()->role !== 'admin'): ?>
        <?php
            $hasPaidThisMonth = auth()->user()
                ->monthlyFunds()
                ->where('month_year', now()->startOfMonth())
                ->exists();
        ?>

        <?php if($hasPaidThisMonth): ?>
            <button class="btn btn-secondary mb-3" disabled>
                You have already paid ₱50 for <?php echo e(now()->format('F Y')); ?>

            </button>
        <?php else: ?>
           <form action="<?php echo e(route('monthlyfunds.pay')); ?>" method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <div class="mb-3">
        <label class="form-label text-white">Upload Proof of Payment (JPG/PNG)</label>
        <input type="file" name="proof_of_payment" class="form-control" accept="image/*" required>
    </div>
    <button type="submit" class="btn btn-success mb-3">
        Pay ₱50 for <?php echo e(now()->format('F Y')); ?>

    </button>
</form>

        <?php endif; ?>
    <?php endif; ?>

    
    <div class="card bg-dark text-light shadow-lg border-0 rounded-4">
        <div class="card-body">
            <table class="table table-dark table-hover mb-0">
               <thead>
    <tr>
        <th>Member</th>
        <th>Amount</th>
        <th>Month</th>
        <th>Date Paid</th>
        <th>Proof</th>
    </tr>
</thead>
<tbody>
    <?php $__empty_1 = true; $__currentLoopData = $funds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fund): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td><?php echo e($fund->user->name); ?></td>
            <td>₱<?php echo e(number_format($fund->amount, 2)); ?></td>
            <td><?php echo e(\Carbon\Carbon::parse($fund->month_year)->format('F Y')); ?></td>
            <td><?php echo e($fund->created_at->format('M d, Y')); ?></td>
            <td>
                <?php if($fund->proof_of_payment): ?>
                    <a href="<?php echo e(asset('storage/' . $fund->proof_of_payment)); ?>" target="_blank" class="btn btn-sm btn-outline-info">
                        View Proof
                    </a>
                <?php else: ?>
                    <span class="text-muted">No proof</span>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
            <td colspan="5" class="text-center text-muted">No monthly fund records yet.</td>
        </tr>
    <?php endif; ?>
</tbody>

            </table>
        </div>
    </div>
</div>

            <div class=" mt-4">
                <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-outline-info rounded-pill px-4">
                    ← Back to Dashboard
                </a>
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
    const recordCount = <?php echo e($funds->count()); ?>;
    return confirm(`⚠️ WARNING: Are you sure you want to delete ALL ${recordCount} monthly fund records?\n\nThis action will permanently remove all payment history and cannot be undone!`);
}
</script>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pundohub\resources\views/monthly_funds/index.blade.php ENDPATH**/ ?>