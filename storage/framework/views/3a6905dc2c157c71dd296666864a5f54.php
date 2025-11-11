

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <div class="card shadow-lg rounded-4 border-0 bg-dark text-light"
         style="background: rgba(20,20,20,0.85); backdrop-filter: blur(12px);">
        
        <div class="card-body p-4">
            <h2 class="mb-4 text-info text-center fw-bold">
                <i class="bi bi-person-fill-gear me-2 text-warning"></i> Edit Member
            </h2>

            
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm">
                    <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form id="memberForm" action="<?php echo e(route('members.update', $member->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                
                <div class="mb-3">
                    <label class="form-label text-light">Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" 
                           class="form-control bg-dark text-light border-secondary rounded-3 shadow-sm" 
                           placeholder="Enter member name" value="<?php echo e(old('name', $member->name)); ?>" required>
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <small class="text-danger"><?php echo e($message); ?></small>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div class="mb-3">
                    <label class="form-label text-light">Email Address <span class="text-danger">*</span></label>
                    <input type="email" name="email" 
                           class="form-control bg-dark text-light border-secondary rounded-3 shadow-sm" 
                           placeholder="Enter email address" value="<?php echo e(old('email', $member->email)); ?>" required>
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <small class="text-danger"><?php echo e($message); ?></small>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div class="mb-3">
                    <label class="form-label text-light">Household</label>
                    <select name="household" class="form-select bg-dark text-light border-secondary rounded-3 shadow-sm">
                        <option value="" disabled>Select Purok</option>
                        <?php for($i = 1; $i <= 7; $i++): ?>
                            <option value="Purok <?php echo e($i); ?>" <?php echo e(old('household', $member->household) == "Purok $i" ? 'selected' : ''); ?>>
                                Purok <?php echo e($i); ?>

                            </option>
                        <?php endfor; ?>
                    </select>
                    <?php $__errorArgs = ['household'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <small class="text-danger"><?php echo e($message); ?></small>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div class="mb-3">
                    <label class="form-label text-light">Contact Number</label>
                    <input type="text" name="contact" id="contact" 
                           class="form-control bg-dark text-light border-secondary rounded-3 shadow-sm" 
                           placeholder="09XXXXXXXXX" maxlength="11" pattern="09\d{9}" 
                           title="Enter an 11-digit Philippine mobile number starting with 09" 
                           value="<?php echo e(old('contact', $member->contact)); ?>">
                    <?php $__errorArgs = ['contact'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <small class="text-danger"><?php echo e($message); ?></small>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-light">Role <span class="text-danger">*</span></label>
                        <select name="role" id="role" class="form-select bg-dark text-light border-secondary rounded-3 shadow-sm" required>
                            <option value="" disabled>Select Role</option>
                            <option value="member" <?php echo e(old('role', $member->role) == 'member' ? 'selected' : ''); ?>>Member</option>
                            <option value="admin" <?php echo e(old('role', $member->role) == 'admin' ? 'selected' : ''); ?>>Admin</option>
                        </select>
                        <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <small class="text-danger"><?php echo e($message); ?></small>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-6 mb-3" id="jobTypeDiv" style="display: <?php echo e(old('role', $member->role) == 'member' ? 'block' : 'none'); ?>;">
                        <label class="form-label text-light">Member Job Type <span class="text-danger">*</span></label>
                        <select name="job_type" class="form-select bg-dark text-light border-secondary rounded-3 shadow-sm" <?php echo e(old('role', $member->role) == 'member' ? 'required' : ''); ?>>
                            <option value="" disabled>Select Job Type</option>
                            <option value="cook" <?php echo e(old('job_type', $member->job_type) == 'cook' ? 'selected' : ''); ?>>Cook</option>
                            <option value="dishwasher" <?php echo e(old('job_type', $member->job_type) == 'dishwasher' ? 'selected' : ''); ?>>Dishwasher</option>
                            <option value="cleaner" <?php echo e(old('job_type', $member->job_type) == 'cleaner' ? 'selected' : ''); ?>>Cleaner</option>
                            <option value="setup_crew" <?php echo e(old('job_type', $member->job_type) == 'setup_crew' ? 'selected' : ''); ?>>Setup Crew</option>
                            <option value="logistics" <?php echo e(old('job_type', $member->job_type) == 'logistics' ? 'selected' : ''); ?>>Logistics</option>
                            <option value="coordinator" <?php echo e(old('job_type', $member->job_type) == 'coordinator' ? 'selected' : ''); ?>>Coordinator</option>
                            <option value="finance" <?php echo e(old('job_type', $member->job_type) == 'finance' ? 'selected' : ''); ?>>Finance</option>
                            <option value="none" <?php echo e(old('job_type', $member->job_type) == 'none' ? 'selected' : ''); ?>>No Specific Job</option>
                        </select>
                        <?php $__errorArgs = ['job_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <small class="text-danger"><?php echo e($message); ?></small>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="<?php echo e(route('members.index')); ?>" 
                       class="btn btn-outline-secondary rounded-pill px-4 shadow-sm">
                        <i class="bi bi-arrow-left-circle me-1"></i> Back
                    </a>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                        <i class="bi bi-save2 me-1"></i> Update Member
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    const contactInput = document.getElementById('contact');

    contactInput.addEventListener('input', function () {
        this.value = this.value.replace(/\D/g, '');
        if (!this.value.startsWith('09')) this.value = '09';
        if (this.value.length > 11) this.value = this.value.slice(0, 11);
    });

    document.getElementById('memberForm').addEventListener('submit', function(e) {
        const contactValue = contactInput.value;
        if (contactValue && !/^09\d{9}$/.test(contactValue)) {
            e.preventDefault();
            alert("Please enter a valid 11-digit number starting with 09.");
            return;
        }
        if(contactValue) contactInput.value = '+63' + contactValue.substring(1);
    });

    const roleSelect = document.getElementById('role');
    const jobTypeDiv = document.getElementById('jobTypeDiv');
    const jobTypeSelect = jobTypeDiv.querySelector('select');

    roleSelect.addEventListener('change', function() {
        if(this.value === 'member') {
            jobTypeDiv.style.display = 'block';
            jobTypeSelect.setAttribute('required', 'required');
        } else {
            jobTypeDiv.style.display = 'none';
            jobTypeSelect.removeAttribute('required');
        }
    });

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        if(roleSelect.value === 'member') {
            jobTypeDiv.style.display = 'block';
            jobTypeSelect.setAttribute('required', 'required');
        } else {
            jobTypeDiv.style.display = 'none';
            jobTypeSelect.removeAttribute('required');
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pundohub\resources\views/members/edit.blade.php ENDPATH**/ ?>