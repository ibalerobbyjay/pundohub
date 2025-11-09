<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <h3 class="mb-4 text-info">Notifications (<?php echo e($unread->count()); ?> unread)</h3>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if($notifications->isEmpty()): ?>
        <div class="text-center text-muted py-5">
            No notifications found.
        </div>
    <?php else: ?>
        <ul class="list-group">
            <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="list-group-item d-flex justify-content-between align-items-start
           <?php echo e(is_null($notification->read_at) ? 'bg-primary text-white fw-bold' : 'bg-dark text-light'); ?>

           border-secondary rounded-3 mb-2 shadow-sm notification-item">
    
    <div>
        <?php echo e($notification->data['message'] ?? 'No message'); ?><br>
        <small class="<?php echo e(is_null($notification->read_at) ? 'text-light-50' : 'text-muted'); ?>">
            <?php echo e($notification->created_at->diffForHumans()); ?>

        </small>
    </div>

    <div class="ms-3 text-nowrap">
        <?php if(is_null($notification->read_at)): ?>
            <form action="<?php echo e(route('notifications.read', $notification->id)); ?>" method="POST" class="d-inline">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-sm btn-success mb-1 rounded-pill">✓</button>
            </form>
        <?php endif; ?>
    </div>
</li>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    <?php endif; ?>
</div>

<style>
/* Hover effect for notifications */
.notification-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.3);
    transition: all 0.2s ease-in-out;
    cursor: pointer;
}

.notification-item.bg-dark:hover {
    background-color: #c5c7ca !important; /* slightly lighter dark */
}

.notification-item.bg-primary:hover {
    background-color: #0d6efd !important; /* slightly brighter primary */
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pundohub\resources\views/notifications/index.blade.php ENDPATH**/ ?>