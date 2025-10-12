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
                    <th scope="col">Actions</th>
                </tr>
            </thead>
         <tbody>
<?php $__currentLoopData = $donations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $donation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr class="text-center">
    <td><?php echo e($donation->user->name ?? 'N/A'); ?></td>
    <td><?php echo e($donation->bereavementCase->title ?? 'N/A'); ?></td>
    <td><?php echo e(number_format($donation->amount, 2)); ?></td>
    <td><?php echo e($donation->type); ?></td>
    <td>
        <a href="<?php echo e(route('donations.edit', $donation->id)); ?>" class="btn btn-sm btn-warning me-1">Edit</a>
        <form action="<?php echo e(route('donations.destroy', $donation->id)); ?>" method="POST" class="d-inline">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this donation?')">Delete</button>
        </form>
    </td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</tbody>

        </table>
        
    </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pundohub\resources\views/donations/index.blade.php ENDPATH**/ ?>