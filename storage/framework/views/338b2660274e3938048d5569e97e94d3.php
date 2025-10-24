

<?php $__env->startSection('content'); ?>
<div class="container my-5">
    <div class="card p-4 shadow-lg rounded-4">
        <h2 class="mb-4 text-gray-800">Death Reports</h2>

        <!-- ✅ Success Alert -->
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>Date of Death</th>
                        <th>Notes</th>
                        <th>Certificate</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($report->name_of_deceased); ?></td>
                            <td><?php echo e(\Carbon\Carbon::parse($report->date_of_death)->format('M d, Y')); ?></td>
                            <td><?php echo e($report->notes ?? '-'); ?></td>
                            <td class="text-center">
                                <?php if($report->death_certificate): ?>
                                    <?php
                                        $fileExt = strtolower(pathinfo($report->death_certificate, PATHINFO_EXTENSION));
                                        $fileUrl = asset('storage/' . $report->death_certificate);
                                    ?>

                                    <?php if(in_array($fileExt, ['jpg', 'jpeg', 'png'])): ?>
                                        <a href="<?php echo e($fileUrl); ?>" target="_blank">
                                            <img src="<?php echo e($fileUrl); ?>" alt="Certificate" class="img-thumbnail" width="70">
                                        </a>
                                    <?php elseif($fileExt === 'pdf'): ?>
                                        <a href="<?php echo e($fileUrl); ?>" target="_blank" class="btn btn-outline-primary btn-sm">
                                            View PDF
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">Unsupported File</span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="text-muted">No File</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if($report->is_verified): ?>
                                    <span class="badge bg-success">Verified</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Pending</span>
                                <?php endif; ?>
                            </td>

                            <td class="text-center">
                                <?php if(!$report->is_verified): ?>
                                    <form action="<?php echo e(route('admin.death-reports.approve', $report->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="bi bi-check-circle me-1"></i> Verify
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <form action="<?php echo e(route('admin.death-reports.unverify', $report->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-x-circle me-1"></i> Unverify
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">No death reports yet.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pundohub\resources\views/admin/death-reports/index.blade.php ENDPATH**/ ?>