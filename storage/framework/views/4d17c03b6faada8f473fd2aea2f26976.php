<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-info">Notifications (<?php echo e($unread->count()); ?> unread)</h3>

        <?php if($unread->count() > 0): ?>
        <form action="<?php echo e(route('notifications.markAllRead')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-sm btn-primary rounded-pill">
                Mark All as Read
            </button>
        </form>
        <?php endif; ?>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if($notifications->isEmpty()): ?>
        <div class="text-center text-muted py-5">
            No notifications found.
        </div>
    <?php else: ?>
        <ul class="list-group">
            <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $data = $notification->data;
                    $isUnread = is_null($notification->read_at);
                    $bgClass = $isUnread ? 'bg-primary text-white fw-bold' : 'bg-dark text-light';
                    
                    // Get user for profile picture - IMPROVED LOGIC
                    $user = null;
                    
                    // For donation notifications - find donor
                    if (isset($data['type']) && $data['type'] === 'donation' && isset($data['donor_name'])) {
                        $user = \App\Models\User::where('name', $data['donor_name'])->first();
                    }
                    // For death reports - find reporter
                    elseif (isset($data['reporter_name'])) {
                        $user = \App\Models\User::where('name', $data['reporter_name'])->first();
                    }
                    // For profile updates - find the user who updated profile
                    elseif (isset($data['user_name'])) {
                        $user = \App\Models\User::where('name', $data['user_name'])->first();
                    }
                    // For payment notifications - find payer
                    elseif (isset($data['payer_name'])) {
                        $user = \App\Models\User::where('name', $data['payer_name'])->first();
                    }
                    // For bereavement cases - find case creator
                    elseif (isset($data['case_creator_name'])) {
                        $user = \App\Models\User::where('name', $data['case_creator_name'])->first();
                    }

                    // Determine the appropriate link for each notification type
                    $notificationLink = '#';
                    if (isset($data['case_id'])) {
                        $notificationLink = route('bereavement-cases.show', $data['case_id']) . '?notification_id=' . $notification->id;
                    } elseif (isset($data['report_id'])) {
                        $notificationLink = route('admin.death-reports.index') . '?notification_id=' . $notification->id;
                    } elseif (isset($data['donation_id'])) {
                        $notificationLink = route('donations.index') . '?notification_id=' . $notification->id;
                    } elseif (isset($data['payment_id'])) {
                        $notificationLink = route('payments.show', $data['payment_id']) . '?notification_id=' . $notification->id;
                    }
                ?>

                <li class="list-group-item d-flex justify-content-between align-items-start <?php echo e($bgClass); ?> border-secondary rounded-3 mb-2 shadow-sm notification-item"
                    data-notification-id="<?php echo e($notification->id); ?>"
                    data-is-unread="<?php echo e($isUnread ? 'true' : 'false'); ?>"
                    data-link="<?php echo e($notificationLink); ?>">
                    
                    <div class="d-flex align-items-start w-100">
                        <!-- Profile Picture -->
                        <div class="me-3 flex-shrink-0">
                            <?php if($user && $user->profile_picture): ?>
                                <img src="<?php echo e(asset('storage/' . $user->profile_picture)); ?>" 
                                     alt="<?php echo e($user->name); ?>" 
                                     class="rounded-circle"
                                     style="width: 45px; height: 45px; object-fit: cover; border: 2px solid #0dcaf0;">
                            <?php else: ?>
                                <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center"
                                     style="width: 45px; height: 45px;">
                                    <i class="bi bi-person-fill text-light"></i>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Notification Content -->
                        <div class="flex-grow-1">
                            
                            <?php if(isset($data['reporter_name']) && isset($data['deceased_name'])): ?>
                                <div class="d-flex align-items-center mb-1">
                                    <span class="badge bg-warning text-dark">Death Report</span>
                                </div>
                                <div>
                                    <strong><?php echo e($data['reporter_name']); ?></strong> reported death of <strong><?php echo e($data['deceased_name']); ?></strong>
                                    <?php if(isset($data['cause_of_death'])): ?>
                                        <br><small>Cause: <?php echo e($data['cause_of_death']); ?></small>
                                    <?php endif; ?>
                                    <?php if(isset($data['location_of_death'])): ?>
                                        <br><small>Location: <?php echo e($data['location_of_death']); ?></small>
                                    <?php endif; ?>
                                </div>

                            
                            <?php elseif(isset($data['type']) && $data['type'] === 'donation'): ?>
                                <div class="d-flex align-items-center mb-1">
                                    <span class="badge bg-success">Donation</span>
                                </div>
                                <div>
                                    <strong><?php echo e($data['donor_name']); ?></strong> donated 
                                    <strong><?php echo e($data['amount_display'] ?? ($data['currency'] ?? '₱') . number_format($data['amount'], 2)); ?></strong>
                                    <?php if(isset($data['message']) && $data['message']): ?>
                                        <br><small>"<?php echo e($data['message']); ?>"</small>
                                    <?php endif; ?>
                                </div>

                            
                            <?php elseif(isset($data['type']) && $data['type'] === 'payment'): ?>
                                <div class="d-flex align-items-center mb-1">
                                    <span class="badge bg-info">Payment</span>
                                </div>
                                <div>
                                    <strong><?php echo e($data['payer_name']); ?></strong> paid monthly funds of 
                                    <strong><?php echo e($data['currency'] ?? '₱'); ?><?php echo e(number_format($data['amount'], 2)); ?></strong>
                                    <?php if(isset($data['month'])): ?>
                                        <br><small>For: <?php echo e($data['month']); ?></small>
                                    <?php endif; ?>
                                </div>

                            
                            <?php elseif(isset($data['user_name']) && isset($data['title']) && $data['title'] === 'Profile Updated'): ?>
                                <div class="d-flex align-items-center mb-1">
                                    <span class="badge bg-primary">Profile Update</span>
                                </div>
                                <div>
                                    <strong><?php echo e($data['user_name']); ?></strong> updated their profile
                                </div>

                            
                            <?php elseif(isset($data['case_title']) && isset($data['job_type'])): ?>
                                <div class="d-flex align-items-center mb-1">
                                    <span class="badge bg-info"><?php echo e(ucfirst($data['job_type'])); ?> Assignment</span>
                                </div>
                                <div>
                                    You have a new <strong><?php echo e($data['job_type']); ?></strong> assignment
                                    <br>
                                    <small>Case: <?php echo e($data['case_title']); ?></small>
                                </div>

                            
                            <?php elseif(isset($data['case_title']) && isset($data['type']) && $data['type'] === 'bereavement'): ?>
                                <div class="d-flex align-items-center mb-1">
                                    <span class="badge bg-danger">Bereavement Case</span>
                                </div>
                                <div>
                                    New bereavement case: <strong><?php echo e($data['case_title']); ?></strong>
                                    <?php if(isset($data['case_creator_name'])): ?>
                                        <br><small>Created by: <?php echo e($data['case_creator_name']); ?></small>
                                    <?php endif; ?>
                                </div>

                            
                            <?php elseif(isset($data['message'])): ?>
                                <div>
                                    <?php echo e($data['message']); ?>

                                </div>

                            
                            <?php else: ?>
                                <div>No message content</div>
                            <?php endif; ?>

                            <!-- Timestamp -->
                            <small class="<?php echo e($isUnread ? 'text-light-50' : 'text-muted'); ?>">
                                <?php echo e($notification->created_at->diffForHumans()); ?>

                            </small>
                        </div>
                    </div>

                    <!-- Action Buttons - Removed Mark as Read button -->
                    <div class="ms-3 text-nowrap flex-shrink-0">
                        
                        <?php if(isset($data['case_id'])): ?>
                            <a href="<?php echo e(route('bereavement-cases.show', $data['case_id'])); ?>?notification_id=<?php echo e($notification->id); ?>" 
                               class="btn btn-sm btn-outline-info rounded-pill">
                                View Case
                            </a>
                        <?php elseif(isset($data['report_id'])): ?>
                            <a href="<?php echo e(route('admin.death-reports.index')); ?>?notification_id=<?php echo e($notification->id); ?>" 
                               class="btn btn-sm btn-outline-info rounded-pill">
                                View Reports
                            </a>
                        <?php elseif(isset($data['donation_id'])): ?>
                            <a href="<?php echo e(route('donations.index')); ?>?notification_id=<?php echo e($notification->id); ?>" 
                               class="btn btn-sm btn-outline-info rounded-pill">
                                View Donation
                            </a>
                        <?php elseif(isset($data['payment_id'])): ?>
                            <a href="<?php echo e(route('payments.show', $data['payment_id'])); ?>?notification_id=<?php echo e($notification->id); ?>" 
                               class="btn btn-sm btn-outline-info rounded-pill">
                                View Payment
                            </a>
                        <?php endif; ?>
                    </div>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    <?php endif; ?>
</div>

<style>
.notification-item {
    transition: all 0.2s ease-in-out;
    cursor: pointer;
}

.notification-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.3);
}

.notification-item.bg-dark:hover {
    background-color: #c5c7ca !important;
    color: #000 !important;
}

.notification-item.bg-primary:hover {
    background-color: #0d6efd !important;
}

/* Profile picture hover effect */
.rounded-circle {
    transition: transform 0.2s ease;
}

.rounded-circle:hover {
    transform: scale(1.1);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle notification clicks
    document.querySelectorAll('.notification-item').forEach(item => {
        item.addEventListener('click', function(e) {
            // Don't trigger if user clicked on a button or link inside the notification
            if (e.target.tagName === 'BUTTON' || e.target.tagName === 'A' || e.target.closest('button') || e.target.closest('a')) {
                return;
            }

            const notificationId = this.getAttribute('data-notification-id');
            const isUnread = this.getAttribute('data-is-unread') === 'true';
            const link = this.getAttribute('data-link');

            if (isUnread) {
                // Create a hidden form to submit via POST
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/notifications/${notificationId}/read`;
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '<?php echo e(csrf_token()); ?>';
                
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'POST';
                
                form.appendChild(csrfToken);
                form.appendChild(methodField);
                document.body.appendChild(form);
                
                // Submit the form
                form.submit();
            } else if (link && link !== '#') {
                // If already read, just navigate to the link
                window.location.href = link;
            }
        });
    });

    // Add loading state for "Mark All as Read" button
    const markAllForm = document.querySelector('form[action*="markAllRead"]');
    if (markAllForm) {
        markAllForm.addEventListener('submit', function(e) {
            const button = this.querySelector('button[type="submit"]');
            button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Marking...';
            button.disabled = true;
        });
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pundohub\resources\views/notifications/index.blade.php ENDPATH**/ ?>