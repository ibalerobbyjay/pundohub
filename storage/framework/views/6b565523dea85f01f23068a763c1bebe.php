<?php $__env->startSection('content'); ?>
<h2 class="mb-4 text-white">Dashboard</h2>

<?php if(auth()->user()->role !== 'admin'): ?>
    
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card p-3 bg-dark text-light shadow">
                <h5 class="text-info">Your Total Donations</h5>
                <p class="fs-5 fw-bold">₱ <?php echo e(number_format($userTotalDonations, 2)); ?></p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 bg-dark text-light shadow">
                <h5 class="text-info">Total Donations (All Members)</h5>
                <p class="fs-5 fw-bold">₱ <?php echo e(number_format($totalDonations, 2)); ?></p>
            </div>
        </div>
    </div>

    <h4 class="text-white">Recent Notifications</h4>

    
    <?php if(auth()->user()->unreadNotifications->count() > 0): ?>
    <form method="POST" action="<?php echo e(route('notifications.markAllRead')); ?>" class="mb-2">
        <?php echo csrf_field(); ?>
        <button class="btn btn-sm btn-secondary">Mark All as Read</button>
    </form>
    <?php endif; ?>

    <ul class="list-group mb-3">
        <?php $__empty_1 = true; $__currentLoopData = auth()->user()->notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <li class="list-group-item <?php echo e($notification->read_at ? '' : 'bg-light'); ?>">
                <strong><?php echo e($notification->data['user_name'] ?? 'N/A'); ?></strong> 
                - <?php echo e($notification->data['title'] ?? 'No title'); ?> <br>
                Date of Death: <?php echo e($notification->data['date_of_death'] ?? 'N/A'); ?> <br>
                Description: <?php echo e($notification->data['description'] ?? 'N/A'); ?>

                <a href="<?php echo e($notification->data['link'] ?? '#'); ?>" class="btn btn-sm btn-primary float-end">View Case</a>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <li class="list-group-item">No notifications yet.</li>
        <?php endif; ?>
    </ul>
<?php endif; ?>

<?php if(auth()->user()->role === 'admin'): ?>
<div class="row mt-4">
    <div class="col-md-4">
        <div class="card p-3 bg-dark text-light shadow">
            <h5 class="text-info">Total Donations (All Members)</h5>
            <p class="fs-5 fw-bold">₱ <?php echo e(number_format($totalDonations, 2)); ?></p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3 bg-dark text-light shadow">
            <h5 class="text-info">Total Number of Donations</h5>
            <p class="fs-5 fw-bold"><?php echo e($totalDonationCount); ?></p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3 bg-dark text-light shadow">
            <h5 class="text-info">Total Bereavement Cases</h5>
            <p class="fs-5 fw-bold"><?php echo e($totalCases); ?></p>
        </div>
    </div>
</div>


<div class="mt-4">
    <h4 class="text-white">Recent Bereavement Cases</h4>
    <?php if(isset($recentCases) && $recentCases->count() > 0): ?>
        <ul class="list-group">
            <?php $__currentLoopData = $recentCases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $case): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="list-group-item">
                    <strong><?php echo e($case->title ?? 'No title'); ?></strong><br>
                    Member: <?php echo e($case->user->name ?? 'N/A'); ?> <br>
                    Date of Death: <?php echo e($case->date_of_death?->format('F j, Y') ?? 'N/A'); ?> <br>
                    Description: <?php echo e($case->description ?? 'N/A'); ?>

                    <a href="<?php echo e(route('bereavement-cases.edit', $case->id)); ?>" class="btn btn-sm btn-outline-primary float-end">
                        View / Edit
                    </a>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    <?php else: ?>
        <p class="text-muted">No recent bereavement cases.</p>
    <?php endif; ?>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pundohub\resources\views/dashboard.blade.php ENDPATH**/ ?>