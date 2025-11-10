<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">

        
        
        <div class="col-md-9 col-lg-10 p-4">

            <h2 class="mb-4 text-white fw-bold">Dashboard</h2>

            
            <?php if(auth()->user()->role !== 'admin'): ?>
                <div class="row mb-4">
                    
                    <?php if(auth()->user()->role === 'member'): ?>
                    <div class="col-md-4 mb-3">
                        <a href="<?php echo e(route('donations.history')); ?>" class="text-decoration-none">
                            <div class="card p-4 bg-dark text-light shadow rounded-4 hover-card">
                                <h5 class="text-info">Total Fund</h5>
                                <p class="fs-5 fw-bold">₱ <?php echo e(number_format($userTotalDonations, 2)); ?></p>
                            </div>
                        </a>
                    </div>
                    <?php endif; ?>

                    
                    <div class="col-md-4 mb-3">
                        <a href="<?php echo e(route('donations.index')); ?>" class="text-decoration-none">
                            <div class="card p-4 bg-dark text-light shadow rounded-4 hover-card">
                                <h5 class="text-info">Total Donations (All Members)</h5>
                                <p class="fs-5 fw-bold">₱ <?php echo e(number_format($totalDonations, 2)); ?></p>
                            </div>
                        </a>
                    </div>

                    
                    <div class="col-md-4 mb-3">
                        <a href="<?php echo e(route('monthlyfunds.index')); ?>" class="text-decoration-none">
                            <div class="card p-4 bg-dark text-light shadow rounded-4 hover-card position-relative">
                                <h5 class="text-info">Monthly Funds</h5>
                                <p class="fs-5 fw-bold">₱ 50 / month</p>

                                <?php
                                    $hasPaidThisMonth = auth()->user()
                                        ->monthlyFunds()
                                        ->where('month_year', now()->startOfMonth())
                                        ->exists();
                                ?>

                                <?php if($hasPaidThisMonth): ?>
                                    <span class="badge bg-success position-absolute top-0 end-0 m-3 px-3 py-2">Paid</span>
                                <?php else: ?>
                                    <span class="badge bg-danger position-absolute top-0 end-0 m-3 px-3 py-2">Unpaid</span>
                                <?php endif; ?>
                            </div>
                        </a>
                    </div>
                </div>

                
                <h4 class="text-white mt-4">Recent Notifications</h4>

                
                <?php if($notifications->where('read_at', null)->count() > 0): ?>
                    <form method="POST" action="<?php echo e(route('notifications.markAllRead')); ?>" class="mb-3">
                        <?php echo csrf_field(); ?>
                        <button class="btn btn-sm btn-secondary rounded-pill px-3">Mark All as Read</button>
                    </form>
                <?php endif; ?>

                <ul class="list-group mb-3 shadow-sm rounded-4">
                    <?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $isUnread = is_null($notification->read_at);
                            $bgClass = $isUnread ? 'bg-info text-dark fw-bold' : 'bg-dark text-light';

                            // Determine the case link for staff
                            if(isset($notification->data['job_type']) && isset($notification->data['case_id'])) {
                                $caseLink = route('bereavement-cases.show', $notification->data['case_id']);
                            } else {
                                $caseLink = $notification->data['link'] ?? '#';
                            }
                        ?>

                        <li class="list-group-item d-flex justify-content-between align-items-start <?php echo e($bgClass); ?> hover-notification">
                            <div>
                                
                                <?php if(isset($notification->data['job_type'])): ?>
                                    <span class="badge bg-warning text-dark me-2">
                                        <?php echo e(ucfirst($notification->data['job_type'])); ?> Task
                                    </span>
                                    You have a new task in bereavement case: 
                                    <strong><?php echo e($notification->data['case_title'] ?? 'N/A'); ?></strong>
                                    <br>
                                    <small class="text-muted"><?php echo e($notification->created_at->diffForHumans()); ?></small>

                                
                                <?php elseif(isset($notification->data['user_name'])): ?>
                                    <strong><?php echo e($notification->data['user_name']); ?></strong> - 
                                    <?php echo e($notification->data['title'] ?? 'No title'); ?> <br>
                                    Date of Death: <?php echo e($notification->data['date_of_death'] ?? 'N/A'); ?> <br>
                                    Description: <?php echo e($notification->data['description'] ?? 'N/A'); ?>

                                    <br><small class="text-muted"><?php echo e($notification->created_at->diffForHumans()); ?></small>

                                
                                <?php else: ?>
                                    <?php echo e($notification->data['message'] ?? 'No message'); ?>

                                    <br><small class="text-muted"><?php echo e($notification->created_at->diffForHumans()); ?></small>
                                <?php endif; ?>
                            </div>

                            
                            <a href="<?php echo e($caseLink); ?>" class="btn btn-sm btn-primary align-self-center ms-3">
                                View Case
                            </a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <li class="list-group-item bg-dark text-light text-center">No notifications yet.</li>
                    <?php endif; ?>
                </ul>
            <?php endif; ?>

            
            <?php if(auth()->user()->role === 'admin'): ?>
                <div class="row mt-4">
                    
                    <div class="col-md-3 mb-3">
                        <a href="<?php echo e(route('donations.index')); ?>" class="text-decoration-none">
                            <div class="card p-4 bg-dark text-light shadow rounded-4 hover-card">
                                <h5 class="text-info">Total Donations</h5>
                                <p class="fs-5 fw-bold">₱ <?php echo e(number_format($totalDonations, 2)); ?></p>
                            </div>
                        </a>
                    </div>

                    
                    <div class="col-md-3 mb-3">
                        <a href="<?php echo e(route('donations.index')); ?>" class="text-decoration-none">
                            <div class="card p-4 bg-dark text-light shadow rounded-4 hover-card">
                                <h5 class="text-info">Number of Donations</h5>
                                <p class="fs-5 fw-bold"><?php echo e($totalDonationCount); ?></p>
                            </div>
                        </a>
                    </div>

                    
                    <div class="col-md-3 mb-3">
                        <a href="<?php echo e(route('bereavement-cases.index')); ?>" class="text-decoration-none">
                            <div class="card p-4 bg-dark text-light shadow rounded-4 hover-card">
                                <h5 class="text-info">Bereavement Cases</h5>
                                <p class="fs-5 fw-bold"><?php echo e($totalCases); ?></p>
                            </div>
                        </a>
                    </div>

                    
                    <div class="col-md-3 mb-3">
                        <a href="<?php echo e(route('monthlyfunds.index')); ?>" class="text-decoration-none">
                            <div class="card p-4 bg-dark text-light shadow rounded-4 hover-card">
                                <h5 class="text-info">Monthly Fund (All Members)</h5>
                                <p class="fs-5 fw-bold">
                                    ₱ <?php echo e(number_format(\App\Models\MonthlyFund::where('month_year', now()->startOfMonth())->sum('amount'), 2)); ?>

                                </p>
                            </div>
                        </a>
                    </div>
                </div>

                
                <div class="mt-4">
                    <h4 class="text-white">Recent Bereavement Cases</h4>
                    <?php if(isset($recentCases) && $recentCases->count() > 0): ?>
                        <ul class="list-group shadow-sm rounded-4">
                            <?php $__currentLoopData = $recentCases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $case): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="list-group-item d-flex justify-content-between align-items-start
                                           bg-dark text-light mb-2 rounded-3 hover-notification">
                                    <div>
                                        <strong><?php echo e($case->title ?? 'No title'); ?></strong><br>
                                        Member: <?php echo e($case->user->name ?? 'N/A'); ?> <br>
                                        Date of Death: <?php echo e($case->date_of_death?->format('F j, Y') ?? 'N/A'); ?> <br>
                                        Description: <?php echo e($case->description ?? 'N/A'); ?>

                                    </div>
                                    <a href="<?php echo e(route('bereavement-cases.edit', $case->id)); ?>" 
                                       class="btn btn-sm btn-outline-primary align-self-center">
                                       View / Edit
                                    </a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-muted">No recent bereavement cases.</p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        </div> 
    </div> 
</div> 


<style>
.hover-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0 20px rgba(0, 255, 255, 0.3);
}
.hover-notification {
    transition: background-color 0.2s ease, box-shadow 0.2s ease;
    cursor: pointer;
}
.hover-notification:hover {
    background-color: rgba(0, 255, 255, 0.1);
    box-shadow: 0 0 10px rgba(0, 255, 255, 0.2);
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pundohub\resources\views/dashboard.blade.php ENDPATH**/ ?>