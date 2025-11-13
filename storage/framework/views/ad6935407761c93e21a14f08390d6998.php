<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    
    <div class="text-center mb-5">
        <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
             style="width: 70px; height: 70px;">
            <i class="bi bi-person-plus-fill text-white" style="font-size: 1.8rem;"></i>
        </div>
        <h2 class="text-light fw-bold mb-2">Add New Member</h2>
        <p class="text-light">Register a new member to the system</p>
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

    
    <div class="card border-0 shadow-lg rounded-4">
        <div class="card-body p-5">
            <form id="memberForm" action="<?php echo e(route('members.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div class="row">
                    
                    <div class="col-lg-6">
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">
                                <i class="bi bi-person-fill text-primary me-2"></i>Full Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="name" 
                                   class="form-control border-0 rounded-3 bg-light" 
                                   placeholder="Enter member's full name" value="<?php echo e(old('name')); ?>" required>
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger mt-1"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">
                                <i class="bi bi-envelope-fill text-primary me-2"></i>Email Address <span class="text-danger">*</span>
                            </label>
                            <input type="email" name="email" 
                                   class="form-control border-0 rounded-3 bg-light" 
                                   placeholder="Enter email address" value="<?php echo e(old('email')); ?>" required>
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger mt-1"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">
                                <i class="bi bi-lock-fill text-warning me-2"></i>Password <span class="text-danger">*</span>
                            </label>
                            <input type="password" name="password" 
                                   class="form-control border-0 rounded-3 bg-light" 
                                   placeholder="Enter password" required>
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger mt-1"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <div class="form-text text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Minimum 8 characters with letters and numbers
                            </div>
                        </div>

                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">
                                <i class="bi bi-lock-fill text-warning me-2"></i>Confirm Password <span class="text-danger">*</span>
                            </label>
                            <input type="password" name="password_confirmation" 
                                   class="form-control border-0 rounded-3 bg-light" 
                                   placeholder="Confirm password" required>
                        </div>
                    </div>

                    
                    <div class="col-lg-6">
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">
                                <i class="bi bi-house-fill text-info me-2"></i>Household
                            </label>
                            <select name="household" class="form-select border-0 rounded-3 bg-light">
                                <option value="" selected disabled>Select Purok</option>
                                <?php for($i = 1; $i <= 7; $i++): ?>
                                    <option value="Purok <?php echo e($i); ?>" <?php echo e(old('household') == "Purok $i" ? 'selected' : ''); ?>>
                                        Purok <?php echo e($i); ?>

                                    </option>
                                <?php endfor; ?>
                            </select>
                            <?php $__errorArgs = ['household'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger mt-1"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">
                                <i class="bi bi-telephone-fill text-success me-2"></i>Contact Number
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0">+63</span>
                                <input type="text" name="contact" id="contact" 
                                       class="form-control border-0 rounded-3 bg-light" 
                                       placeholder="9XXXXXXXXX" maxlength="10" pattern="9\d{9}" 
                                       title="Enter a 10-digit Philippine mobile number starting with 9" 
                                       value="<?php echo e(old('contact')); ?>">
                            </div>
                            <?php $__errorArgs = ['contact'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger mt-1"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <div class="form-text text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Format: 9XXXXXXXXX (10 digits)
                            </div>
                        </div>

                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">
                                <i class="bi bi-person-badge-fill text-danger me-2"></i>Role <span class="text-danger">*</span>
                            </label>
                            <select name="role" id="role" class="form-select border-0 rounded-3 bg-light" required>
                                <option value="" selected disabled>Select Role</option>
                                <option value="member" <?php echo e(old('role') == 'member' ? 'selected' : ''); ?>>Member</option>
                                <option value="admin" <?php echo e(old('role') == 'admin' ? 'selected' : ''); ?>>Admin</option>
                            </select>
                            <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger mt-1"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="mb-4" id="jobTypeDiv">
                            <label class="form-label fw-semibold text-dark">
                                <i class="bi bi-briefcase-fill text-warning me-2"></i>Member Job Type <span class="text-danger">*</span>
                            </label>
                            <select name="job_type" class="form-select border-0 rounded-3 bg-light">
                                <option value="" selected disabled>Select Job Type</option>
                                <option value="cook" <?php echo e(old('job_type') == 'cook' ? 'selected' : ''); ?>>Cook</option>
                                <option value="dishwasher" <?php echo e(old('job_type') == 'dishwasher' ? 'selected' : ''); ?>>Dishwasher</option>
                                <option value="cleaner" <?php echo e(old('job_type') == 'cleaner' ? 'selected' : ''); ?>>Cleaner</option>
                                <option value="setup_crew" <?php echo e(old('job_type') == 'setup_crew' ? 'selected' : ''); ?>>Setup Crew</option>
                                <option value="logistics" <?php echo e(old('job_type') == 'logistics' ? 'selected' : ''); ?>>Logistics</option>
                                <option value="coordinator" <?php echo e(old('job_type') == 'coordinator' ? 'selected' : ''); ?>>Coordinator</option>
                                <option value="finance" <?php echo e(old('job_type') == 'finance' ? 'selected' : ''); ?>>Finance</option>
                                <option value="none" <?php echo e(old('job_type') == 'none' ? 'selected' : ''); ?>>No Specific Job</option>
                            </select>
                            <?php $__errorArgs = ['job_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger mt-1"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                
                <div class="d-flex justify-content-between align-items-center pt-4 border-top mt-4">
                    <a href="<?php echo e(route('members.index')); ?>" 
                       class="btn btn-outline-secondary rounded-3 px-4">
                        <i class="bi bi-arrow-left me-2"></i> Back to Members
                    </a>
                    <button type="submit" class="btn btn-primary rounded-3 px-4 py-2">
                        <i class="bi bi-save me-2"></i> Save Member
                    </button>
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

    .form-control, .form-select {
        transition: all 0.3s ease;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
    }

    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        border-color: #0d6efd;
        background-color: #ffffff;
        transform: translateY(-2px);
    }

    .form-control::placeholder {
        color: #6c757d;
        opacity: 0.7;
    }

    .btn {
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .btn-primary {
        background: linear-gradient(135deg, #0d6efd, #0b5ed7);
        border: none;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #0b5ed7, #0a58ca);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(13, 110, 253, 0.4);
    }

    .btn-outline-secondary {
        border: 2px solid #6c757d;
        transition: all 0.3s ease;
    }

    .btn-outline-secondary:hover {
        background-color: #6c757d;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
    }

    .alert-success {
        background: linear-gradient(135deg, #d1e7dd, #badbcc);
        border: none;
        color: #0f5132;
    }

    .input-group-text {
        background-color: #f8f9fa;
        border: none;
        font-weight: 600;
        color: #495057;
    }

    /* Animation for form elements */
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

    .form-control, .form-select, .btn {
        animation: fadeInUp 0.6s ease-out;
    }

    /* Staggered animation for form groups */
    .mb-4 {
        animation-duration: 0.6s;
        animation-fill-mode: both;
    }

    .mb-4:nth-child(1) { animation-delay: 0.1s; }
    .mb-4:nth-child(2) { animation-delay: 0.2s; }
    .mb-4:nth-child(3) { animation-delay: 0.3s; }
    .mb-4:nth-child(4) { animation-delay: 0.4s; }
    .mb-4:nth-child(5) { animation-delay: 0.5s; }
    .mb-4:nth-child(6) { animation-delay: 0.6s; }
    .mb-4:nth-child(7) { animation-delay: 0.7s; }

    /* Custom scrollbar for select */
    .form-select::-webkit-scrollbar {
        width: 6px;
    }

    .form-select::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .form-select::-webkit-scrollbar-thumb {
        background: #0d6efd;
        border-radius: 10px;
    }

    .form-select::-webkit-scrollbar-thumb:hover {
        background: #0b5ed7;
    }
</style>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('role');
        const jobTypeDiv = document.getElementById('jobTypeDiv');
        const jobTypeSelect = jobTypeDiv.querySelector('select');
        const contactInput = document.getElementById('contact');

        // Show/hide job type based on role selection
        function toggleJobType() {
            if (roleSelect.value === 'member') {
                jobTypeDiv.style.display = 'block';
                jobTypeSelect.setAttribute('required', 'required');
            } else {
                jobTypeDiv.style.display = 'none';
                jobTypeSelect.removeAttribute('required');
                jobTypeSelect.value = '';
            }
        }

        // Initialize on page load
        toggleJobType();

        // Add event listener for role change
        roleSelect.addEventListener('change', toggleJobType);

        // Contact number validation
        contactInput.addEventListener('input', function () {
            // Remove any non-digit characters
            this.value = this.value.replace(/\D/g, '');
            
            // Ensure it starts with 9 and is exactly 10 digits
            if (this.value.length > 0 && !this.value.startsWith('9')) {
                this.value = '9' + this.value;
            }
            if (this.value.length > 10) {
                this.value = this.value.slice(0, 10);
            }
        });

        // Form validation
        document.getElementById('memberForm').addEventListener('submit', function(e) {
            const contactValue = contactInput.value;
            
            // Validate contact number if provided
            if (contactValue && !/^9\d{9}$/.test(contactValue)) {
                e.preventDefault();
                alert("Please enter a valid 10-digit Philippine mobile number starting with 9.");
                contactInput.focus();
                return;
            }

            // Validate password strength
            const password = document.querySelector('input[name="password"]').value;
            if (password.length < 8) {
                e.preventDefault();
                alert("Password must be at least 8 characters long.");
                return;
            }

            // Add +63 prefix to contact number before submission
            if (contactValue) {
                contactInput.value = '+63' + contactValue;
            }
        });

        // Add focus effects to form elements
        const formElements = document.querySelectorAll('.form-control, .form-select');
        
        formElements.forEach(element => {
            element.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            element.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
        });

        // Real-time password strength indicator
        const passwordInput = document.querySelector('input[name="password"]');
        const passwordHelp = document.createElement('div');
        passwordHelp.className = 'form-text mt-1';
        passwordInput.parentNode.appendChild(passwordHelp);

        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 'Weak';
            let color = 'text-danger';

            if (password.length >= 8) {
                if (/[A-Z]/.test(password) && /[0-9]/.test(password) && /[^A-Za-z0-9]/.test(password)) {
                    strength = 'Strong';
                    color = 'text-success';
                } else if (/[A-Z]/.test(password) || /[0-9]/.test(password)) {
                    strength = 'Medium';
                    color = 'text-warning';
                }
            }

            passwordHelp.innerHTML = `<span class="${color}"><i class="bi bi-shield-check me-1"></i>Password strength: ${strength}</span>`;
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pundohub\resources\views/members/create.blade.php ENDPATH**/ ?>