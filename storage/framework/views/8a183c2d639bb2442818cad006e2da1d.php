<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <h2 class="mb-4">All Donations</h2>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th scope="col">Donor Name</th>
                    <th scope="col">Bereavement Case</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Type</th>
                    <th scope="col">Proof</th> 
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $donations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $donation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="text-center">
                    <td><?php echo e($donation->user->name ?? 'N/A'); ?></td>
                    <td><?php echo e($donation->bereavementCase->title ?? 'N/A'); ?></td>
                    <td><?php echo e($donation->type === 'Money' ? number_format($donation->amount, 2) : '—'); ?></td>
                    <td><?php echo e($donation->type); ?></td>

                    
                    <td>
                        <?php if($donation->proof): ?>
                            <a href="<?php echo e(asset('storage/' . $donation->proof)); ?>" target="_blank">
                                <img src="<?php echo e(asset('storage/' . $donation->proof)); ?>" 
                                     alt="Proof" 
                                     class="img-thumbnail" 
                                     style="width: 60px; height: 60px; object-fit: cover;">
                            </a>
                        <?php else: ?>
                            <span class="text-muted">No proof</span>
                        <?php endif; ?>
                    </td>

                    
                    <td>
                        <form action="<?php echo e(route('donations.destroy', $donation->id)); ?>" method="POST" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this donation?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pundohub\resources\views/donations/index.blade.php ENDPATH**/ ?>