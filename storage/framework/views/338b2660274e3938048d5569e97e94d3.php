<?php $__env->startSection('content'); ?>
<div class="container my-5">
    <div class="card border-0 shadow-lg rounded-4 text-light"
         style="background: rgba(20, 20, 20, 0.9); backdrop-filter: blur(10px);">
        <div class="card-body p-5">
            <h2 class="mb-4 text-info text-center">
                <i class="bi bi-file-earmark-medical me-2"></i> Death Reports
            </h2>

            
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show rounded-3">
                    <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="table-responsive mt-4">
                <table class="table table-dark table-hover align-middle rounded-3 overflow-hidden">
                    <thead>
                        <tr class="bg-info text-dark">
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
                                <td><?php echo e($report->notes ?? '—'); ?></td>
                                <td class="text-center">
                                    <?php if($report->death_certificate): ?>
                                        <?php
                                            $fileExt = strtolower(pathinfo($report->death_certificate, PATHINFO_EXTENSION));
                                            $fileUrl = asset('storage/' . $report->death_certificate);
                                        ?>

                                        <?php if(in_array($fileExt, ['jpg', 'jpeg', 'png'])): ?>
                                            <a href="<?php echo e($fileUrl); ?>" target="_blank">
                                                <img src="<?php echo e($fileUrl); ?>" alt="Certificate"
                                                     class="img-thumbnail rounded-3 border border-secondary"
                                                     width="70">
                                            </a>
                                        <?php elseif($fileExt === 'pdf'): ?>
                                            <a href="<?php echo e($fileUrl); ?>" target="_blank"
                                               class="btn btn-outline-info btn-sm rounded-3">
                                                <i class="bi bi-file-earmark-pdf"></i> View PDF
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
                                        <span class="badge bg-success px-3 py-2">Verified</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary px-3 py-2">Pending</span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center">
                                    <?php if(!$report->is_verified): ?>
                                        <form action="<?php echo e(route('admin.death-reports.approve', $report->id)); ?>"
                                              method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit"
                                                    class="btn btn-outline-success btn-sm rounded-3 fw-semibold">
                                                <i class="bi bi-check-circle me-1"></i> Verify
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <form action="<?php echo e(route('admin.death-reports.unverify', $report->id)); ?>"
                                              method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit"
                                                    class="btn btn-outline-danger btn-sm rounded-3 fw-semibold">
                                                <i class="bi bi-x-circle me-1"></i> Unverify
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    No death reports yet.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<style>
.table tbody tr:hover {
    background-color: rgba(0, 255, 255, 0.05);
    transition: background-color 0.2s ease-in-out;
}

.badge {
    font-size: 0.85rem;
}

.btn-outline-success:hover {
    background-color: rgba(25, 135, 84, 0.2);
    box-shadow: 0 0 10px rgba(25, 135, 84, 0.4);
}

.btn-outline-danger:hover {
    background-color: rgba(220, 53, 69, 0.2);
    box-shadow: 0 0 10px rgba(220, 53, 69, 0.4);
}

.btn-outline-info:hover {
    background-color: rgba(13, 202, 240, 0.2);
    box-shadow: 0 0 10px rgba(13, 202, 240, 0.4);
}

.alert-success {
    background-color: rgba(25, 135, 84, 0.2);
    color: #a6ffcb;
    border: 1px solid rgba(25, 135, 84, 0.4);
}

.table-hover tbody tr:hover {
    transform: translateY(-2px);
    transition: transform 0.15s ease;
    box-shadow: 0 4px 12px rgba(0, 255, 255, 0.2);
}

</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pundohub\resources\views/admin/death-reports/index.blade.php ENDPATH**/ ?>