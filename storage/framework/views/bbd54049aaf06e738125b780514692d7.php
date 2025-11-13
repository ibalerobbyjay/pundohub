

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    
    <div class="text-center mb-5">
        <div class="bg-info rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
             style="width: 70px; height: 70px;">
            <i class="bi bi-file-earmark-text-fill text-white" style="font-size: 1.8rem;"></i>
        </div>
        <h2 class="text-light fw-bold mb-2">Bereavement Case Details</h2>
        <p class="text-light">Case #<?php echo e($case->id); ?> - <?php echo e($case->title); ?></p>
    </div>

    
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div class="fw-medium"><?php echo e(session('success')); ?></div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    
    <div class="card border-0 shadow-lg rounded-4 mb-4">
        <div class="card-header bg-light border-0 py-3">
            <div class="d-flex align-items-center">
                <div class="bg-info rounded p-2 me-3">
                    <i class="bi bi-info-circle text-white"></i>
                </div>
                <h5 class="mb-0 text-dark fw-bold">Case Information</h5>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="row">
                
                <div class="col-md-6">
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-primary bg-opacity-10 rounded p-2 me-3">
                                <i class="bi bi-tag text-primary"></i>
                            </div>
                            <div>
                                <h6 class="fw-semibold text-dark mb-0">Case Title</h6>
                                <p class="text-muted mb-0"><?php echo e($case->title); ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-success bg-opacity-10 rounded p-2 me-3">
                                <i class="bi bi-person text-success"></i>
                            </div>
                            <div>
                                <h6 class="fw-semibold text-dark mb-0">Assigned Member</h6>
                                <p class="text-muted mb-0"><?php echo e($case->user->name); ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-warning bg-opacity-10 rounded p-2 me-3">
                                <i class="bi bi-calendar-event text-warning"></i>
                            </div>
                            <div>
                                <h6 class="fw-semibold text-dark mb-0">Date of Death</h6>
                                <p class="text-muted mb-0"><?php echo e($case->date_of_death->format('F d, Y')); ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-info bg-opacity-10 rounded p-2 me-3">
                                <i class="bi bi-clock text-info"></i>
                            </div>
                            <div>
                                <h6 class="fw-semibold text-dark mb-0">Case Created</h6>
                                <p class="text-muted mb-0"><?php echo e($case->created_at->format('F d, Y g:i A')); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="col-md-6">
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-danger bg-opacity-10 rounded p-2 me-3">
                                <i class="bi bi-person-x text-danger"></i>
                            </div>
                            <div>
                                <h6 class="fw-semibold text-dark mb-0">Name of Deceased</h6>
                                <p class="text-muted mb-0"><?php echo e($case->description_name ?? 'N/A'); ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-purple bg-opacity-10 rounded p-2 me-3">
                                <i class="bi bi-heart text-purple"></i>
                            </div>
                            <div>
                                <h6 class="fw-semibold text-dark mb-0">Service Type</h6>
                                <p class="text-muted mb-0"><?php echo e($case->description_what ?? 'N/A'); ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-orange bg-opacity-10 rounded p-2 me-3">
                                <i class="bi bi-clock-history text-orange"></i>
                            </div>
                            <div>
                                <h6 class="fw-semibold text-dark mb-0">Service Date & Time</h6>
                                <p class="text-muted mb-0">
                                    <?php if($case->description_when): ?>
                                        <?php echo e(\Carbon\Carbon::parse($case->description_when)->format('F d, Y g:i A')); ?>

                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-teal bg-opacity-10 rounded p-2 me-3">
                                <i class="bi bi-geo-alt text-teal"></i>
                            </div>
                            <div>
                                <h6 class="fw-semibold text-dark mb-0">Location</h6>
                                <p class="text-muted mb-0"><?php echo e($case->description_where ?? 'N/A'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            
            <?php if($case->description_notes): ?>
                <div class="mt-4 pt-4 border-top">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-secondary bg-opacity-10 rounded p-2 me-3">
                            <i class="bi bi-sticky text-secondary"></i>
                        </div>
                        <h6 class="fw-semibold text-dark mb-0">Additional Notes</h6>
                    </div>
                    <div class="card bg-light border-0 rounded-3">
                        <div class="card-body">
                            <p class="mb-0 text-dark"><?php echo e($case->description_notes); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    
    <div class="card border-0 shadow-lg rounded-4">
        <div class="card-header bg-light border-0 py-3">
            <div class="d-flex align-items-center">
                <div class="bg-warning rounded p-2 me-3">
                    <i class="bi bi-chat-text text-white"></i>
                </div>
                <h5 class="mb-0 text-dark fw-bold">Case Remarks & Updates</h5>
            </div>
        </div>
        <div class="card-body p-4">
            
            <?php if($case->remarks): ?>
                <div class="mb-4 p-4 bg-light border-0 rounded-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6 class="fw-semibold text-dark mb-0">Current Remarks</h6>
                        <span class="badge bg-info rounded-pill">Last updated: <?php echo e($case->updated_at->diffForHumans()); ?></span>
                    </div>
                    <p class="text-dark mb-0"><?php echo e($case->remarks); ?></p>
                </div>
            <?php else: ?>
                <div class="mb-4 p-4 bg-light border-0 rounded-3 text-center">
                    <i class="bi bi-chat-dots display-4 text-muted mb-3"></i>
                    <p class="text-muted mb-0"><i>No remarks added yet.</i></p>
                </div>
            <?php endif; ?>

            
            <form action="<?php echo e(route('bereavement-cases.updateRemarks', $case->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="mb-4">
                    <label for="remarks" class="form-label fw-semibold text-dark">
                        <i class="bi bi-pencil-square me-2 text-info"></i>Update Remarks
                    </label>
                    <textarea name="remarks" id="remarks" 
                              class="form-control border-0 rounded-3 bg-light" 
                              rows="4" 
                              placeholder="Add any remarks or updates about this case..."><?php echo e(old('remarks', $case->remarks)); ?></textarea>
                    <div class="form-text text-end text-muted small mt-1">
                        <span id="remarks-counter">0</span>/1000 characters
                    </div>
                </div>

              <div class="d-flex justify-content-between align-items-center pt-4 border-top">
    <div class="d-flex gap-2">
        
        <?php if(auth()->user()->role !== 'member'): ?>
            <a href="<?php echo e(route('bereavement-cases.index')); ?>" class="btn btn-outline-secondary rounded-3 px-4">
                <i class="bi bi-list-ul me-2"></i> All Cases
            </a>
        <?php endif; ?>

        <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-outline-info rounded-3 px-4">
            <i class="bi bi-arrow-left-circle me-2"></i> Dashboard
        </a>
    </div>

    <div class="d-flex gap-2">
        
        <?php if(auth()->user()->role !== 'member'): ?>
            <a href="<?php echo e(route('bereavement-cases.edit', $case->id)); ?>" class="btn btn-outline-warning rounded-3 px-4">
                <i class="bi bi-pencil-square me-2"></i> Edit Case
            </a>
        <?php endif; ?>

        <button type="submit" class="btn btn-success rounded-3 px-4">
            <i class="bi bi-check-circle me-2"></i> Update Remarks
        </button>
    </div>
</div>

                </div>
            </form>
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

    .form-control {
        transition: all 0.3s ease;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
    }

    .form-control:focus {
        box-shadow: 0 0 0 0.25rem rgba(13, 202, 240, 0.15);
        border-color: #0dcaf0;
        background-color: #ffffff;
        transform: translateY(-2px);
    }

    .btn {
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .btn-success {
        background: linear-gradient(135deg, #198754, #157347);
        border: none;
    }

    .btn-success:hover {
        background: linear-gradient(135deg, #157347, #13653f);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(25, 135, 84, 0.3);
    }

    .btn-outline-secondary:hover {
        background-color: #6c757d;
        border-color: #6c757d;
        transform: translateY(-2px);
    }

    .btn-outline-info:hover {
        background-color: #0dcaf0;
        border-color: #0dcaf0;
        transform: translateY(-2px);
    }

    .btn-outline-warning:hover {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #000 !important;
        transform: translateY(-2px);
    }

    .alert-success {
        background: linear-gradient(135deg, #d1e7dd, #badbcc);
        border: none;
        color: #0f5132;
    }

    /* Custom colors for icons */
    .bg-purple {
        background-color: #6f42c1 !important;
    }
    
    .text-purple {
        color: #6f42c1 !important;
    }

    .bg-orange {
        background-color: #fd7e14 !important;
    }
    
    .text-orange {
        color: #fd7e14 !important;
    }

    .bg-teal {
        background-color: #20c997 !important;
    }
    
    .text-teal {
        color: #20c997 !important;
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

    .card:nth-child(1) {
        animation-delay: 0.1s;
    }

    .card:nth-child(2) {
        animation-delay: 0.2s;
    }

    /* Custom scrollbar for textarea */
    textarea::-webkit-scrollbar {
        width: 6px;
    }

    textarea::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    textarea::-webkit-scrollbar-thumb {
        background: #0dcaf0;
        border-radius: 10px;
    }

    textarea::-webkit-scrollbar-thumb:hover {
        background: #0ba8cc;
    }
</style>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Character counter for remarks textarea
        const remarksTextarea = document.getElementById('remarks');
        const remarksCounter = document.getElementById('remarks-counter');
        
        if (remarksTextarea && remarksCounter) {
            remarksTextarea.addEventListener('input', function() {
                const length = this.value.length;
                remarksCounter.textContent = length;
                
                if (length > 1000) {
                    remarksCounter.classList.add('text-danger');
                } else {
                    remarksCounter.classList.remove('text-danger');
                }
            });
            
            // Trigger input event to set initial count
            remarksTextarea.dispatchEvent(new Event('input'));
        }

        // Add focus effects to form elements
        const formElements = document.querySelectorAll('.form-control');
        
        formElements.forEach(element => {
            element.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            element.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
        });

        // Auto-resize textarea
        function autoResize(textarea) {
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';
        }

        if (remarksTextarea) {
            remarksTextarea.addEventListener('input', function() {
                autoResize(this);
            });
            
            // Initial resize
            autoResize(remarksTextarea);
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pundohub\resources\views/bereavement-cases/show.blade.php ENDPATH**/ ?>