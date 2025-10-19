

<?php $__env->startSection('content'); ?>
<div class="container my-5">
    <div class="card p-4 shadow-lg rounded-4">
        <h2 class="mb-4 text-gray-800">Death Reports</h2>

        <!-- Success Alert -->
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
                            <td>
                                <?php if($report->death_certificate): ?>
                                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#certificateModal<?php echo e($report->id); ?>">
                                        View
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="certificateModal<?php echo e($report->id); ?>" tabindex="-1" aria-labelledby="certificateModalLabel<?php echo e($report->id); ?>" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-xl">

                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="certificateModalLabel<?php echo e($report->id); ?>">Death Certificate</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                               <div class="modal-body text-center">
    <?php
        $fileExt = pathinfo($report->death_certificate, PATHINFO_EXTENSION);
    ?>

    <?php if(in_array(strtolower($fileExt), ['jpg','jpeg','png'])): ?>
        <!-- Spinner while image loads -->
        <div class="d-flex justify-content-center align-items-center" id="loadingSpinner<?php echo e($report->id); ?>">
            <div class="spinner-border text-secondary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <!-- Image (hidden until loaded) -->
        <img src="<?php echo e(asset('storage/' . $report->death_certificate)); ?>"
             alt="Certificate"
             class="img-fluid rounded"
             style="display:none;"
             onload="this.style.display='block'; document.getElementById('loadingSpinner<?php echo e($report->id); ?>').style.display='none';">

    <?php elseif(strtolower($fileExt) === 'pdf'): ?>
        <iframe src="<?php echo e(asset('storage/' . $report->death_certificate)); ?>" width="100%" height="600px"></iframe>
    <?php else: ?>
        <p class="text-muted">Unsupported file format.</p>
    <?php endif; ?>
</div>

                                            </div>
                                        </div>
                                    </div>
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