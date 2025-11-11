<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-12">

            <div class="card border-0 shadow-lg rounded-4 bg-dark text-light" 
                 style="background: rgba(20,20,20,0.85); backdrop-filter: blur(10px);">
                 
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                    <h2 class="mb-0 fw-bold text-info">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>Penalties Dashboard
                    </h2>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#addPenaltyModal">
                            <i class="bi bi-plus-circle me-1"></i> Add Penalty
                        </button>
                        <button class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#penaltyStatsModal">
                            <i class="bi bi-graph-up me-1"></i> Statistics
                        </button>
                    </div>
                </div>

                <!-- Summary Cards -->
                <div class="row p-4 border-bottom border-secondary">
                    <div class="col-md-3 mb-3">
                        <div class="card bg-primary text-white rounded-3">
                            <div class="card-body text-center py-3">
                                <h5 class="card-title mb-1">Total Penalties</h5>
                                <h3 class="mb-0"><?php echo e($penalties->count()); ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card bg-warning text-dark rounded-3">
                            <div class="card-body text-center py-3">
                                <h5 class="card-title mb-1">Unpaid</h5>
                                <h3 class="mb-0"><?php echo e($penalties->where('paid', false)->count()); ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card bg-success text-white rounded-3">
                            <div class="card-body text-center py-3">
                                <h5 class="card-title mb-1">Paid</h5>
                                <h3 class="mb-0"><?php echo e($penalties->where('paid', true)->count()); ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card bg-info text-white rounded-3">
                            <div class="card-body text-center py-3">
                                <h5 class="card-title mb-1">Total Amount</h5>
                                <h3 class="mb-0">₱<?php echo e(number_format($penalties->sum('amount'), 2)); ?></h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <?php if($penalties->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-dark table-hover align-middle">
                                <thead class="table-light text-dark">
                                    <tr>
                                        <th>User</th>
                                        <th>Amount (₱)</th>
                                        <th>Reason</th>
                                        <th>Date Applied</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $penalties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $penalty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="<?php echo e($penalty->is_overdue ? 'table-danger' : ''); ?>">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <?php if($penalty->user->profile_picture ?? false): ?>
                                                        <img src="<?php echo e(asset('storage/' . $penalty->user->profile_picture)); ?>" 
                                                             alt="<?php echo e($penalty->user->name); ?>" 
                                                             class="rounded-circle me-2"
                                                             style="width: 35px; height: 35px; object-fit: cover;">
                                                    <?php else: ?>
                                                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center me-2"
                                                             style="width: 35px; height: 35px;">
                                                            <i class="bi bi-person-fill text-light"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div>
                                                        <div class="fw-semibold"><?php echo e($penalty->user->name ?? 'Unknown'); ?></div>
                                                        <small class="text-muted"><?php echo e($penalty->user->email ?? ''); ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="fw-bold">₱<?php echo e(number_format($penalty->amount, 2)); ?></td>
                                            <td>
                                                <span class="d-inline-block text-truncate" style="max-width: 200px;" 
                                                      title="<?php echo e($penalty->reason); ?>">
                                                    <?php echo e($penalty->reason); ?>

                                                </span>
                                            </td>
                                            <td><?php echo e(\Carbon\Carbon::parse($penalty->applied_at)->format('M d, Y')); ?></td>
                                            <td>
                                                <?php if($penalty->due_date): ?>
                                                    <?php if($penalty->is_overdue): ?>
                                                        <span class="badge bg-danger">
                                                            <i class="bi bi-clock-history me-1"></i>
                                                            <?php echo e(\Carbon\Carbon::parse($penalty->due_date)->format('M d, Y')); ?>

                                                        </span>
                                                    <?php else: ?>
                                                        <span class="badge bg-warning text-dark">
                                                            <?php echo e(\Carbon\Carbon::parse($penalty->due_date)->format('M d, Y')); ?>

                                                        </span>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <span class="text-muted">No due date</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($penalty->paid): ?>
                                                    <span class="badge bg-success">
                                                        <i class="bi bi-check-circle me-1"></i>Paid
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning text-dark">
                                                        <i class="bi bi-clock me-1"></i>Unpaid
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <?php if(!$penalty->paid): ?>
                                                        <form action="<?php echo e(route('penalties.markPaid', $penalty->id)); ?>" method="POST" class="d-inline">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('PATCH'); ?>
                                                            <button type="submit" class="btn btn-sm btn-success" 
                                                                    title="Mark as Paid">
                                                                <i class="bi bi-check-lg"></i>
                                                            </button>
                                                        </form>
                                                    <?php endif; ?>
                                                    <button class="btn btn-sm btn-info view-penalty" 
                                                            data-penalty-id="<?php echo e($penalty->id); ?>"
                                                            title="View Details">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <form action="<?php echo e(route('penalties.destroy', $penalty->id)); ?>" method="POST" class="d-inline">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                                onclick="return confirm('Are you sure you want to delete this penalty?')"
                                                                title="Delete Penalty">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-3">
                            <?php echo e($penalties->links('pagination::bootstrap-5')); ?>

                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
                            <h4 class="text-muted mt-3">No penalties recorded yet</h4>
                            <p class="text-muted">All members are in good standing!</p>
                            <button class="btn btn-info mt-2" data-bs-toggle="modal" data-bs-target="#addPenaltyModal">
                                <i class="bi bi-plus-circle me-1"></i> Add First Penalty
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Add Penalty Modal -->
<div class="modal fade" id="addPenaltyModal" tabindex="-1" aria-labelledby="addPenaltyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header border-secondary">
                <h5 class="modal-title" id="addPenaltyModalLabel">
                    <i class="bi bi-plus-circle me-2"></i>Add New Penalty
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('penalties.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Select Member</label>
                        <select name="user_id" id="user_id" class="form-select bg-dark text-light border-secondary" required>
                            <option value="">Choose a member...</option>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?> (<?php echo e($user->email); ?>)</option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount (₱)</label>
                        <input type="number" name="amount" id="amount" class="form-control bg-dark text-light border-secondary" 
                               step="0.01" min="1" required placeholder="Enter penalty amount">
                    </div>
                    <div class="mb-3">
                        <label for="reason" class="form-label">Reason</label>
                        <textarea name="reason" id="reason" class="form-control bg-dark text-light border-secondary" 
                                  rows="3" required placeholder="Enter penalty reason"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="due_date" class="form-label">Due Date (Optional)</label>
                        <input type="date" name="due_date" id="due_date" class="form-control bg-dark text-light border-secondary">
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Penalty</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Penalty Statistics Modal -->
<div class="modal fade" id="penaltyStatsModal" tabindex="-1" aria-labelledby="penaltyStatsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header border-secondary">
                <h5 class="modal-title" id="penaltyStatsModalLabel">
                    <i class="bi bi-graph-up me-2"></i>Penalty Statistics
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card bg-secondary mb-3">
                            <div class="card-body">
                                <h6>Total Collection</h6>
                                <h3>₱<?php echo e(number_format($penalties->where('paid', true)->sum('amount'), 2)); ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-warning text-dark mb-3">
                            <div class="card-body">
                                <h6>Pending Collection</h6>
                                <h3>₱<?php echo e(number_format($penalties->where('paid', false)->sum('amount'), 2)); ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <h6>Top Penalized Members</h6>
                    <div class="list-group">
                        <?php $__currentLoopData = $topPenalizedUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="list-group-item bg-dark text-light d-flex justify-content-between">
                                <span><?php echo e($user->name); ?></span>
                                <span class="badge bg-primary"><?php echo e($user->penalties_count); ?> penalties</span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<style>
.table-hover tbody tr:hover {
    transform: translateY(-2px);
    transition: transform 0.15s ease;
    box-shadow: 0 4px 12px rgba(0, 255, 255, 0.2);
}
.card {
    transition: transform 0.2s ease;
}
.card:hover {
    transform: translateY(-2px);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add loading state to forms
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            const button = this.querySelector('button[type="submit"]');
            if (button) {
                button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Processing...';
                button.disabled = true;
            }
        });
    });
});
</script>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pundohub\resources\views/admin/penalties.blade.php ENDPATH**/ ?>