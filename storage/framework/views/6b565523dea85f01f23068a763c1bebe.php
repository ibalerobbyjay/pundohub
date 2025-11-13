<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        
        <div class="col-md-9 col-lg-10 p-4">
            <h2 class="mb-4 text-light fw-bold">Dashboard Overview</h2>

            
            <?php if(auth()->user()->role !== 'admin'): ?>
                <div class="row mb-4">
                    
                    <?php if(auth()->user()->role === 'member'): ?>
                    <div class="col-md-4 mb-3">
                        <a href="<?php echo e(route('donations.history')); ?>" class="text-decoration-none">
                            <div class="card p-4 bg-white text-dark shadow-sm rounded-3 hover-card border-0">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="bg-primary bg-opacity-10 p-2 rounded me-3">
                                        <i class="bi bi-wallet2 text-primary fs-5"></i>
                                    </div>
                                    <h5 class="text-dark mb-0">Total Fund</h5>
                                </div>
                                <p class="fs-4 fw-bold text-primary mb-0">₱ <?php echo e(number_format($userTotalDonations, 2)); ?></p>
                                <small class="text-muted">Your total contributions</small>
                            </div>
                        </a>
                    </div>
                    <?php endif; ?>
      
                    
<?php
    $userPenalties = \App\Models\Penalty::with('user')
        ->where('user_id', auth()->id())
        ->get();
?>

<?php if($userPenalties->count() > 0): ?>
    <div class="col-md-4 mb-3">
        <div class="card p-4 bg-white text-dark shadow-sm rounded-3 hover-card border-0 position-relative"
             data-bs-toggle="modal" data-bs-target="#memberPenaltyModal" style="cursor:pointer;">
            <div class="d-flex align-items-center mb-2">
                <div class="bg-danger bg-opacity-10 p-2 rounded me-3">
                    <i class="bi bi-exclamation-triangle-fill text-danger fs-5"></i>
                </div>
                <h5 class="text-dark mb-0">Penalties</h5>
            </div>
            <p class="fs-4 fw-bold text-danger mb-1">
                ₱ <?php echo e(number_format($userPenalties->where('paid', false)->sum('amount'), 2)); ?>

            </p>
            <small class="text-muted">Unpaid penalties</small>

            <?php if($userPenalties->where('paid', false)->count() > 0): ?>
                <span class="badge bg-danger position-absolute top-0 end-0 m-3 px-3 py-2 rounded-pill">
                    <?php echo e($userPenalties->where('paid', false)->count()); ?> Unpaid
                </span>
            <?php else: ?>
                <span class="badge bg-success position-absolute top-0 end-0 m-3 px-3 py-2 rounded-pill">All Paid</span>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

<!-- Penalty Modal -->
<div class="modal fade" id="memberPenaltyModal" tabindex="-1" aria-labelledby="memberPenaltyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered custom-wide-modal">
        <div class="modal-content bg-white text-dark border-0 rounded-3 shadow-lg">
            <div class="modal-header border-bottom">
                <h5 class="modal-title text-dark" id="memberPenaltyModalLabel">
                    <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>
                    Your Penalties
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <?php if($userPenalties->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-4 py-3">Amount (₱)</th>
                                    <th class="px-4 py-3">Reason</th>
                                    <th class="px-4 py-3">Date Applied</th>
                                    <th class="px-4 py-3">Due Date</th>
                                    <th class="px-4 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $userPenalties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $penalty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="<?php echo e($penalty->paid ? '' : 'table-warning'); ?>">
                                        <td class="fw-bold text-dark">₱<?php echo e(number_format($penalty->amount, 2)); ?></td>
                                        <td><?php echo e($penalty->reason); ?></td>
                                        <td><?php echo e(\Carbon\Carbon::parse($penalty->applied_at)->format('M d, Y')); ?></td>
                                        <td>
                                            <?php if($penalty->due_date): ?>
                                                <?php echo e(\Carbon\Carbon::parse($penalty->due_date)->format('M d, Y')); ?>

                                            <?php else: ?>
                                                <span class="text-muted">No due date</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($penalty->paid): ?>
                                                <span class="badge bg-success px-3 py-2 rounded-pill">Paid</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning px-3 py-2 rounded-pill text-dark">Unpaid</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
                        <h5 class="mt-3 text-muted">You have no penalties 🎉</h5>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

                    
                    <div class="col-md-4 mb-3">
                        <a href="<?php echo e(route('donations.index')); ?>" class="text-decoration-none">
                            <div class="card p-4 bg-white text-dark shadow-sm rounded-3 hover-card border-0">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="bg-success bg-opacity-10 p-2 rounded me-3">
                                        <i class="bi bi-cash-coin text-success fs-5"></i>
                                    </div>
                                    <h5 class="text-dark mb-0">Total Donations</h5>
                                </div>
                                <p class="fs-4 fw-bold text-success mb-0">₱ <?php echo e(number_format($totalDonations, 2)); ?></p>
                                <small class="text-muted">All members combined</small>
                            </div>
                        </a>
                    </div>

                    
                    <div class="col-md-4 mb-3">
                        <a href="<?php echo e(route('monthlyfunds.index')); ?>" class="text-decoration-none">
                            <div class="card p-4 bg-white text-dark shadow-sm rounded-3 hover-card border-0 position-relative">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="bg-info bg-opacity-10 p-2 rounded me-3">
                                        <i class="bi bi-calendar-check text-info fs-5"></i>
                                    </div>
                                    <h5 class="text-dark mb-0">Monthly Funds</h5>
                                </div>
                                <p class="fs-4 fw-bold text-info mb-0">₱ 50 / month</p>
                                <small class="text-muted">Monthly contribution</small>

                                <?php
                                    $hasPaidThisMonth = auth()->user()
                                        ->monthlyFunds()
                                        ->where('month_year', now()->startOfMonth())
                                        ->exists();
                                ?>

                                <?php if($hasPaidThisMonth): ?>
                                    <span class="badge bg-success position-absolute top-0 end-0 m-3 px-3 py-2 rounded-pill">Paid</span>
                                <?php else: ?>
                                    <span class="badge bg-danger position-absolute top-0 end-0 m-3 px-3 py-2 rounded-pill">Unpaid</span>
                                <?php endif; ?>
                            </div>
                        </a>
                    </div>
                </div>

                
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="text-dark mb-0">Recent Notifications</h4>
                            <?php if($notifications->where('read_at', null)->count() > 0): ?>
                                <form method="POST" action="<?php echo e(route('notifications.markAllRead')); ?>" class="mb-0">
                                    <?php echo csrf_field(); ?>
                                    <button class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                                        <i class="bi bi-check-all me-1"></i>Mark All as Read
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            <?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php
                                    $isUnread = is_null($notification->read_at);
                                    $bgClass = $isUnread ? 'bg-light-blue' : 'bg-white';

                                    // Determine the case link for staff
                                    if(isset($notification->data['job_type']) && isset($notification->data['case_id'])) {
                                        $caseLink = route('bereavement-cases.show', $notification->data['case_id']);
                                    } else {
                                        $caseLink = $notification->data['link'] ?? '#';
                                    }
                                ?>

                                <div class="list-group-item d-flex justify-content-between align-items-start p-3 <?php echo e($bgClass); ?> hover-notification border-0">
                                    <div class="flex-grow-1">
                                        
                                        <?php if(isset($notification->data['job_type'])): ?>
                                            <span class="badge bg-warning text-dark me-2 rounded-pill">
                                                <?php echo e(ucfirst($notification->data['job_type'])); ?> Task
                                            </span>
                                            <div class="fw-medium">You have a new task in bereavement case:</div>
                                            <strong class="text-primary"><?php echo e($notification->data['case_title'] ?? 'N/A'); ?></strong>
                                            <div class="text-muted small mt-1"><?php echo e($notification->created_at->diffForHumans()); ?></div>

                                        
                                        <?php elseif(isset($notification->data['user_name'])): ?>
                                            <div class="fw-medium text-dark"><?php echo e($notification->data['user_name']); ?></div>
                                            <div class="text-muted"><?php echo e($notification->data['title'] ?? 'No title'); ?></div>
                                            <div class="small">
                                                <span class="text-muted">Date of Death: <?php echo e($notification->data['date_of_death'] ?? 'N/A'); ?></span>
                                            </div>
                                            <div class="text-muted small mt-1"><?php echo e($notification->created_at->diffForHumans()); ?></div>

                                        
                                        <?php else: ?>
                                            <div class="text-dark"><?php echo e($notification->data['message'] ?? 'No message'); ?></div>
                                            <div class="text-muted small mt-1"><?php echo e($notification->created_at->diffForHumans()); ?></div>
                                        <?php endif; ?>
                                    </div>

                                    
                                    <a href="<?php echo e($caseLink); ?>" class="btn btn-outline-primary btn-sm align-self-center ms-3 rounded-pill">
                                        View Case
                                    </a>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="text-center py-4">
                                    <i class="bi bi-bell-slash text-muted fs-1"></i>
                                    <p class="text-muted mt-2 mb-0">No notifications yet.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            
            <?php if(auth()->user()->role === 'admin'): ?>
                <div class="row mt-4">
                    
                    <div class="col-md-3 mb-3">
                        <a href="<?php echo e(route('donations.index')); ?>" class="text-decoration-none">
                            <div class="card p-4 bg-white text-dark shadow-sm rounded-3 hover-card border-0">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="bg-success bg-opacity-10 p-2 rounded me-3">
                                        <i class="bi bi-cash-coin text-success fs-5"></i>
                                    </div>
                                    <h5 class="text-dark mb-0">Total Donations</h5>
                                </div>
                                <p class="fs-4 fw-bold text-success mb-0">₱ <?php echo e(number_format($totalDonations, 2)); ?></p>
                                <small class="text-muted">All donations</small>
                            </div>
                        </a>
                    </div>

                    
                    <div class="col-md-3 mb-3">
                        <a href="<?php echo e(route('members.index')); ?>" class="text-decoration-none">
                            <div class="card p-4 bg-white text-dark shadow-sm rounded-3 hover-card border-0">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="bg-primary bg-opacity-10 p-2 rounded me-3">
                                        <i class="bi bi-people text-primary fs-5"></i>
                                    </div>
                                    <h5 class="text-dark mb-0">Users</h5>
                                </div>
                                <p class="fs-4 fw-bold text-primary mb-0"><?php echo e($totalUsersCount ?? \App\Models\User::count()); ?></p>
                                <small class="text-muted">Total members</small>
                            </div>
                        </a>
                    </div>

                    
                    <div class="col-md-3 mb-3">
                        <a href="<?php echo e(route('bereavement-cases.index')); ?>" class="text-decoration-none">
                            <div class="card p-4 bg-white text-dark shadow-sm rounded-3 hover-card border-0">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="bg-warning bg-opacity-10 p-2 rounded me-3">
                                        <i class="bi bi-folder2-open text-warning fs-5"></i>
                                    </div>
                                    <h5 class="text-dark mb-0">Cases</h5>
                                </div>
                                <p class="fs-4 fw-bold text-warning mb-0"><?php echo e($totalCases); ?></p>
                                <small class="text-muted">Active cases</small>
                            </div>
                        </a>
                    </div>

                    
                    <div class="col-md-3 mb-3">
                        <a href="<?php echo e(route('monthlyfunds.index')); ?>" class="text-decoration-none">
                            <div class="card p-4 bg-white text-dark shadow-sm rounded-3 hover-card border-0">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="bg-info bg-opacity-10 p-2 rounded me-3">
                                        <i class="bi bi-calendar-month text-info fs-5"></i>
                                    </div>
                                    <h5 class="text-dark mb-0">Monthly Fund</h5>
                                </div>
                                <p class="fs-4 fw-bold text-info mb-0">
                                    ₱ <?php echo e(number_format(\App\Models\MonthlyFund::where('month_year', now()->startOfMonth())->sum('amount'), 2)); ?>

                                </p>
                                <small class="text-muted">This month</small>
                            </div>
                        </a>
                    </div>
                </div>

               
<div class="card border-0 shadow-sm rounded-3 mt-4">
    <div class="card-header bg-white border-0 py-3">
        <h4 class="text-dark mb-0">Recent Bereavement Cases</h4>
    </div>
    <div class="card-body p-0">
        <?php if(isset($recentCases) && $recentCases->count() > 0): ?>
            <div class="list-group list-group-flush">
                <?php $__currentLoopData = $recentCases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $case): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="list-group-item d-flex justify-content-between align-items-start p-4 bg-white border-bottom hover-notification">
                        <div class="w-100">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <strong class="fs-5 text-primary"><?php echo e($case->title ?? 'No title'); ?></strong>
                                <span class="badge bg-secondary rounded-pill">Case #<?php echo e($case->id); ?></span>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <strong class="text-muted">Member:</strong> 
                                        <span class="text-dark"><?php echo e($case->user->name ?? 'N/A'); ?></span>
                                    </div>
                                    <div class="mb-2">
                                        <strong class="text-muted">Date of Death:</strong> 
                                        <span class="text-dark"><?php echo e($case->date_of_death?->format('F j, Y') ?? 'N/A'); ?></span>
                                    </div>
                                    <div class="mb-2">
                                        <strong class="text-muted">Deceased Name:</strong> 
                                        <span class="text-dark"><?php echo e($case->description_name ?? 'N/A'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <strong class="text-muted">Service Type:</strong> 
                                        <span class="text-dark"><?php echo e($case->description_what ?? 'N/A'); ?></span>
                                    </div>
                                    <div class="mb-2">
                                        <strong class="text-muted">Service Date & Time:</strong> 
                                        <span class="text-dark">
                                            <?php if($case->description_when): ?>
                                                <?php echo e(\Carbon\Carbon::parse($case->description_when)->format('M j, Y g:i A')); ?>

                                            <?php else: ?>
                                                N/A
                                            <?php endif; ?>
                                        </span>
                                    </div>
                                    <div class="mb-2">
                                        <strong class="text-muted">Location:</strong> 
                                        <span class="text-dark"><?php echo e($case->description_where ?? 'N/A'); ?></span>
                                    </div>
                                </div>
                            </div>
                            
                            <?php if($case->description_notes): ?>
                                <div class="mt-3 p-3 bg-light rounded">
                                    <strong class="text-muted">Additional Notes:</strong> 
                                    <span class="text-dark"><?php echo e(Str::limit($case->description_notes, 150)); ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <div class="mt-3 text-muted small">
                                <i class="bi bi-clock me-1"></i>Created: <?php echo e($case->created_at->diffForHumans()); ?>

                            </div>
                        </div>
                        <a href="<?php echo e(route('bereavement-cases.edit', $case->id)); ?>" 
                           class="btn btn-outline-primary btn-sm align-self-center ms-3 rounded-pill">
                           View / Edit
                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-folder-x text-muted fs-1"></i>
                <p class="text-muted mt-2 mb-0">No recent bereavement cases.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
            <?php endif; ?>

        </div> 
    </div> 
</div> 

<style>
:root {
    --light-blue: #f0f8ff;
    --primary-color: #2c80ff;
    --success-color: #28a745;
    --warning-color: #ffc107;
    --danger-color: #dc3545;
}

.hover-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    border: 1px solid #f0f0f0 !important;
}

.hover-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
    border-color: var(--primary-color) !important;
}

.hover-notification {
    transition: background-color 0.2s ease, box-shadow 0.2s ease;
    cursor: pointer;
}

.hover-notification:hover {
    background-color: var(--light-blue) !important;
}

.bg-light-blue {
    background-color: var(--light-blue) !important;
}

/* Custom extra-wide modal */
.custom-wide-modal {
    max-width: 95vw !important;
    width: 95vw !important;
}

.modal-content {
    border: 1px solid #e0e0e0;
}

table.table th, table.table td {
    padding: 1rem !important;
    border-color: #f0f0f0;
}

.card {
    border: 1px solid #f0f0f0;
}

.list-group-item {
    border-color: #f8f9fa;
}

.badge {
    font-weight: 500;
}

.btn {
    font-weight: 500;
}

.text-muted {
    color: #6c757d !important;
}

.bg-white {
    background-color: #ffffff !important;
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pundohub\resources\views/dashboard.blade.php ENDPATH**/ ?>