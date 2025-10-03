

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <h3 class="mb-4">Notifications (<?php echo e($unread->count()); ?> unread)</h3>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <?php if($notifications->isEmpty()): ?>
        <div class="card">
            <div class="card-body text-center text-muted">
                No notifications found.
            </div>
        </div>
    <?php else: ?>
        <div class="row">
            <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-6 mb-4">
                    <div class="card <?php if(is_null($notification->read_at)): ?> border-primary <?php endif; ?>">
                        <div class="card-body d-flex justify-content-between align-items-start">
                            
                            <div>
                                <p class="mb-1 <?php echo e(is_null($notification->read_at) ? 'fw-bold' : ''); ?>">
                                    <?php echo e($notification->data['message'] ?? 'No message'); ?>

                                </p>
                                <small class="text-muted">
                                    <?php echo e($notification->created_at->diffForHumans()); ?>

                                </small>
                            </div>

                            <div class="ms-3 text-nowrap">
                                
                                <?php if(is_null($notification->read_at)): ?>
                                    <form action="<?php echo e(route('notifications.read', $notification->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-success mb-1">
                                            ✓
                                        </button>
                                    </form>
                                <?php endif; ?>

                                
                                <form action="<?php echo e(route('notifications.destroy', $notification->id)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pundohub\resources\views/notifications/index.blade.php ENDPATH**/ ?>