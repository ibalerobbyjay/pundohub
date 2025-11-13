

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" 
                 style="width: 50px; height: 50px;">
                <i class="bi bi-person-badge text-white fs-5"></i>
            </div>
            <div>
                <h2 class="text-light fw-bold mb-0">Member Details</h2>
                <p class="text-light mb-0">Complete profile information for <?php echo e($member->name); ?></p>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="<?php echo e(route('members.edit', $member->id)); ?>" class="btn btn-outline-warning rounded-3 px-4">
                <i class="bi bi-pencil-square me-2"></i> Edit Profile
            </a>
            <a href="<?php echo e(route('members.index')); ?>" class="btn btn-outline-secondary rounded-3 px-4">
                <i class="bi bi-arrow-left me-2"></i> Back to Members
            </a>
        </div>
    </div>

    <div class="row">
        
        <div class="col-lg-8">
            
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-light border-0 py-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-info rounded p-2 me-3">
                            <i class="bi bi-person-lines-fill text-white"></i>
                        </div>
                        <h5 class="mb-0 text-dark fw-bold">Profile Information</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        
                        <div class="col-md-6">
                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="bg-primary bg-opacity-10 rounded p-2 me-3">
                                        <i class="bi bi-person text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-semibold text-dark mb-0">Full Name</h6>
                                        <p class="text-muted mb-0"><?php echo e($member->name); ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="bg-success bg-opacity-10 rounded p-2 me-3">
                                        <i class="bi bi-envelope text-success"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-semibold text-dark mb-0">Email Address</h6>
                                        <p class="text-muted mb-0"><?php echo e($member->email); ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="bg-warning bg-opacity-10 rounded p-2 me-3">
                                        <i class="bi bi-house text-warning"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-semibold text-dark mb-0">Household</h6>
                                        <p class="text-muted mb-0"><?php echo e($member->household ?? 'Not specified'); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <div class="col-md-6">
                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="bg-info bg-opacity-10 rounded p-2 me-3">
                                        <i class="bi bi-telephone text-info"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-semibold text-dark mb-0">Contact Number</h6>
                                        <p class="text-muted mb-0"><?php echo e($member->contact ?? 'Not provided'); ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="bg-danger bg-opacity-10 rounded p-2 me-3">
                                        <i class="bi bi-shield-check text-danger"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-semibold text-dark mb-0">Account Status</h6>
                                        <span class="badge <?php echo e($member->is_verified ? 'bg-success' : 'bg-warning text-dark'); ?> rounded-pill px-3 py-2">
                                            <i class="bi <?php echo e($member->is_verified ? 'bi-check-circle' : 'bi-clock'); ?> me-1"></i>
                                            <?php echo e($member->is_verified ? 'Verified' : 'Pending Verification'); ?>

                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="bg-secondary bg-opacity-10 rounded p-2 me-3">
                                        <i class="bi bi-person-badge text-secondary"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-semibold text-dark mb-0">Member Role</h6>
                                        <span class="badge <?php echo e($member->role === 'admin' ? 'bg-danger' : 'bg-primary'); ?> rounded-pill px-3 py-2">
                                            <i class="bi <?php echo e($member->role === 'admin' ? 'bi-shield-check' : 'bi-person-check'); ?> me-1"></i>
                                            <?php echo e(ucfirst($member->role)); ?>

                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <?php if($member->role === 'member'): ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="bg-warning bg-opacity-10 rounded p-2 me-3">
                                        <i class="bi bi-briefcase text-warning"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-semibold text-dark mb-0">Assigned Job Type</h6>
                                        <?php if($member->job_type && $member->job_type !== 'none'): ?>
                                            <span class="badge bg-warning text-dark rounded-pill px-3 py-2">
                                                <i class="bi 
                                                    <?php echo e($member->job_type === 'cook' ? 'bi-egg-fried' : 
                                                       ($member->job_type === 'dishwasher' ? 'bi-droplet' : 
                                                       ($member->job_type === 'cleaner' ? 'bi-broom' : 
                                                       ($member->job_type === 'setup_crew' ? 'bi-wrench' : 
                                                       ($member->job_type === 'logistics' ? 'bi-truck' : 
                                                       ($member->job_type === 'coordinator' ? 'bi-diagram-3' : 
                                                       ($member->job_type === 'finance' ? 'bi-cash-coin' : 'bi-dash-circle'))))))); ?> 
                                                    me-1">
                                                </i>
                                                <?php echo e(ucfirst(str_replace('_', ' ', $member->job_type))); ?>

                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-light text-muted border rounded-pill px-3 py-2">
                                                <i class="bi bi-dash-circle me-1"></i>
                                                No specific job assigned
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-light border-0 py-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-success rounded p-2 me-3">
                            <i class="bi bi-graph-up text-white"></i>
                        </div>
                        <h5 class="mb-0 text-dark fw-bold">Account Statistics</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4 mb-3">
                            <div class="card bg-light border-0 rounded-4">
                                <div class="card-body py-4">
                                    <i class="bi bi-calendar-check text-primary display-6 mb-2"></i>
                                    <h4 class="fw-bold text-dark mb-1"><?php echo e($member->created_at->format('M d, Y')); ?></h4>
                                    <p class="text-muted mb-0">Member Since</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card bg-light border-0 rounded-4">
                                <div class="card-body py-4">
                                    <i class="bi bi-clock-history text-info display-6 mb-2"></i>
                                    <h4 class="fw-bold text-dark mb-1"><?php echo e($member->updated_at->diffForHumans()); ?></h4>
                                    <p class="text-muted mb-0">Last Updated</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card bg-light border-0 rounded-4">
                                <div class="card-body py-4">
                                    <i class="bi bi-person-check text-success display-6 mb-2"></i>
                                    <h4 class="fw-bold text-dark mb-1">#<?php echo e($member->id); ?></h4>
                                    <p class="text-muted mb-0">Member ID</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-lg-4">
            
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body text-center py-5">
                    <?php if($member->profile_picture): ?>
                        <img src="<?php echo e(asset('storage/' . $member->profile_picture)); ?>" 
                             alt="<?php echo e($member->name); ?>" 
                             class="rounded-circle mb-3 shadow"
                             style="width: 120px; height: 120px; object-fit: cover;">
                    <?php else: ?>
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                             style="width: 120px; height: 120px;">
                            <i class="bi bi-person-fill text-primary" style="font-size: 3rem;"></i>
                        </div>
                    <?php endif; ?>
                    <h5 class="text-dark fw-bold mb-1"><?php echo e($member->name); ?></h5>
                    <p class="text-muted mb-3"><?php echo e(ucfirst($member->role)); ?></p>
                    
                    <?php if(!$member->profile_picture): ?>
                        <div class="alert alert-info border-0 rounded-3">
                            <i class="bi bi-info-circle me-2"></i>
                            No profile picture uploaded
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-light border-0 py-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning rounded p-2 me-3">
                            <i class="bi bi-lightning-charge text-white"></i>
                        </div>
                        <h5 class="mb-0 text-dark fw-bold">Quick Actions</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="<?php echo e(route('members.edit', $member->id)); ?>" class="btn btn-warning text-white rounded-3 py-2">
                            <i class="bi bi-pencil-square me-2"></i> Edit Profile
                        </a>
                        <?php if($member->contact): ?>
                            <a href="tel:<?php echo e($member->contact); ?>" class="btn btn-outline-success rounded-3 py-2">
                                <i class="bi bi-telephone me-2"></i> Call Member
                            </a>
                        <?php endif; ?>
                        <?php if($member->email): ?>
                            <a href="mailto:<?php echo e($member->email); ?>" class="btn btn-outline-primary rounded-3 py-2">
                                <i class="bi bi-envelope me-2"></i> Send Email
                            </a>
                        <?php endif; ?>
                        <form action="<?php echo e(route('members.destroy', $member->id)); ?>" method="POST" class="d-grid">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" 
                                    class="btn btn-outline-danger rounded-3 py-2"
                                    onclick="return confirm('Are you sure you want to delete this member? This action cannot be undone.')">
                                <i class="bi bi-trash me-2"></i> Delete Account
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
    }

    .btn {
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .btn-warning {
        background: linear-gradient(135deg, #ffc107, #e0a800);
        border: none;
    }

    .btn-warning:hover {
        background: linear-gradient(135deg, #e0a800, #d39e00);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 193, 7, 0.4);
        color: white !important;
    }

    .btn-outline-secondary:hover {
        background-color: #6c757d;
        border-color: #6c757d;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
    }

    .btn-outline-success:hover {
        background-color: #198754;
        border-color: #198754;
        transform: translateY(-2px);
    }

    .btn-outline-primary:hover {
        background-color: #0d6efd;
        border-color: #0d6efd;
        transform: translateY(-2px);
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        border-color: #dc3545;
        transform: translateY(-2px);
    }

    .badge {
        font-size: 0.75rem;
        transition: all 0.3s ease;
    }

    .badge:hover {
        transform: scale(1.05);
    }

    .alert-info {
        background: linear-gradient(135deg, #cff4fc, #b6effb);
        border: none;
        color: #055160;
    }

    /* Animation for cards */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card {
        animation: fadeInUp 0.6s ease-out;
    }

    .card:nth-child(1) { animation-delay: 0.1s; }
    .card:nth-child(2) { animation-delay: 0.2s; }
    .card:nth-child(3) { animation-delay: 0.3s; }
    .card:nth-child(4) { animation-delay: 0.4s; }
</style>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add confirmation for delete action with SweetAlert2 if available
        const deleteForm = document.querySelector('form[action*="/members/"]');
        if (deleteForm) {
            const deleteButton = deleteForm.querySelector('button[type="submit"]');
            if (deleteButton) {
                deleteButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const memberName = "<?php echo e($member->name); ?>";
                    
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: 'Delete Member?',
                            html: `
                                <div class="text-center">
                                    <i class="bi bi-exclamation-triangle display-1 text-danger mb-3"></i>
                                    <p class="mb-3">You are about to permanently delete:</p>
                                    <p class="fw-bold text-dark">${memberName}</p>
                                    <p class="text-danger fw-bold">This action cannot be undone!</p>
                                    <p class="text-muted small">All associated data will be lost.</p>
                                </div>
                            `,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#dc3545',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: 'Yes, delete permanently!',
                            cancelButtonText: 'Cancel',
                            background: '#fff',
                            backdrop: 'rgba(0,0,0,0.4)'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                deleteForm.submit();
                            }
                        });
                    } else {
                        // Fallback to native confirm
                        if (confirm(`Are you sure you want to permanently delete ${memberName}? This action cannot be undone!`)) {
                            deleteForm.submit();
                        }
                    }
                });
            }
        }
    });
</script>



<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pundohub\resources\views/members/show.blade.php ENDPATH**/ ?>