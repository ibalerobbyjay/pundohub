

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <h2 class="mb-4">Members</h2>

    <a href="<?php echo e(route('members.create')); ?>" class="btn btn-primary mb-3">Add Member</a>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Household</th>
                    <th scope="col">Contact</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($member->name); ?></td>
                        <td><?php echo e($member->household); ?></td>
                        <td><?php echo e($member->contact); ?></td>
                        <td>
                            <a href="<?php echo e(route('members.show', $member->id)); ?>" class="btn btn-info btn-sm me-1">View</a>
                            <a href="<?php echo e(route('members.edit', $member->id)); ?>" class="btn btn-warning btn-sm me-1">Edit</a>
                            <form action="<?php echo e(route('members.destroy', $member->id)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this member?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pundohub\resources\views/members/index.blade.php ENDPATH**/ ?>