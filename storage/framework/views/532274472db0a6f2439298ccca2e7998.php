<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <div class="card shadow-lg rounded-4 bg-light text-dark">
        <div class="card-body p-4">
            <h2 class="mb-4 fw-bold text-primary text-center">
                <i class="bi bi-person-circle me-2 text-warning"></i> Edit Profile
            </h2>

            <!-- Success Message -->
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm">
                    <i class="bi bi-check-circle-fill me-1"></i> <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form id="profileForm" method="POST" action="<?php echo e(route('profile.update')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>

                <!-- Profile Picture Section -->
                <div class="row mb-4">
                    <div class="col-md-3 text-center">
                        <div class="mb-3">
                            <?php if($user->profile_picture): ?>
                                <img src="<?php echo e(asset('storage/' . $user->profile_picture)); ?>" 
                                     alt="Profile Picture" 
                                     class="img-thumbnail rounded-circle shadow-sm"
                                     style="width: 150px; height: 150px; object-fit: cover;">
                            <?php else: ?>
                                <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                     style="width: 150px; height: 150px;">
                                    <i class="bi bi-person-fill text-light" style="font-size: 3rem;"></i>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <input type="file" 
                                   name="profile_picture" 
                                   id="profile_picture" 
                                   class="form-control d-none"
                                   accept="image/*"
                                   onchange="previewImage(event)">
                            <label for="profile_picture" class="btn btn-outline-primary btn-sm rounded-pill w-100">
                                <i class="bi bi-camera me-1"></i> Change Photo
                            </label>
                            <?php $__errorArgs = ['profile_picture'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger d-block mt-1"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <?php if($user->profile_picture): ?>
                            <button type="button" 
                                    class="btn btn-outline-danger btn-sm rounded-pill w-100"
                                    onclick="removeProfilePicture()">
                                <i class="bi bi-trash me-1"></i> Remove
                            </button>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-9">
                        <div id="imagePreview" class="mb-3 text-center" style="display: none;">
                            <p class="text-primary small mb-2">New Profile Picture Preview:</p>
                            <img id="preview" class="img-thumbnail rounded-circle shadow-sm"
                                 style="width: 150px; height: 150px; object-fit: cover;">
                        </div>

                        <!-- Profile Info -->
                        <div class="mb-3">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="name" 
                                   class="form-control bg-white text-dark border-secondary rounded-3"
                                   value="<?php echo e(old('name', $user->name)); ?>" 
                                   required>
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
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" 
                                   name="email" 
                                   class="form-control bg-white text-dark border-secondary rounded-3"
                                   value="<?php echo e(old('email', $user->email)); ?>" 
                                   required>
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
                            <label class="form-label">Contact Number</label>
                            <input type="text" 
                                   name="contact" 
                                   class="form-control bg-white text-dark border-secondary rounded-3"
                                   value="<?php echo e(old('contact', $user->contact)); ?>"
                                   placeholder="09XXXXXXXXX">
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

                        <div class="mb-3">
                            <label class="form-label">Household</label>
                            <select name="household" class="form-select bg-white text-dark border-secondary rounded-3">
                                <option value="">Select Purok</option>
                                <?php for($i = 1; $i <= 7; $i++): ?>
                                    <option value="Purok <?php echo e($i); ?>" 
                                            <?php echo e(old('household', $user->household) == "Purok $i" ? 'selected' : ''); ?>>
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
                    </div>
                </div>

                <!-- Password Section -->
                <div class="card bg-white border-secondary rounded-3 mb-4">
                    <div class="card-body">
                        <h5 class="text-primary mb-3">
                            <i class="bi bi-shield-lock me-2"></i> Change Password
                        </h5>
                        <div class="mb-3">
                            <label class="form-label">Current Password</label>
                            <input type="password" 
                                   name="current_password" 
                                   class="form-control bg-white text-dark border-secondary rounded-3"
                                   placeholder="Enter current password">
                            <?php $__errorArgs = ['current_password'];
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
                            <label class="form-label">New Password (leave blank to keep current)</label>
                            <input type="password" 
                                   name="password" 
                                   class="form-control bg-white text-dark border-secondary rounded-3"
                                   placeholder="Enter new password">
                            <?php $__errorArgs = ['password'];
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
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" 
                                   name="password_confirmation" 
                                   class="form-control bg-white text-dark border-secondary rounded-3"
                                   placeholder="Confirm new password">
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="bi bi-x-circle me-1"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="bi bi-save2 me-1"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Preview image
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('imagePreview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// Remove profile picture
function removeProfilePicture() {
    if (confirm('Are you sure you want to remove your profile picture?')) {
        const form = document.getElementById('profileForm');
        const removeInput = document.createElement('input');
        removeInput.type = 'hidden';
        removeInput.name = 'remove_profile_picture';
        removeInput.value = '1';
        form.appendChild(removeInput);
        form.submit();
    }
}

// Password validation
document.getElementById('profileForm').addEventListener('submit', function(e) {
    const password = document.querySelector('input[name="password"]').value;
    const confirmPassword = document.querySelector('input[name="password_confirmation"]').value;
    
    if (password && password !== confirmPassword) {
        e.preventDefault();
        alert('Passwords do not match!');
        return false;
    }
});
</script>

<style>
.form-control:focus, .form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13,110,253,0.25);
}
.btn:hover {
    transform: translateY(-2px);
    transition: 0.2s;
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pundohub\resources\views/profile/edit.blade.php ENDPATH**/ ?>