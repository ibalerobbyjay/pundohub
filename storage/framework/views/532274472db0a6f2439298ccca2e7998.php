<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <h2 class="mb-4 text-white">Edit Profile</h2>

    <!-- Success Message -->
    <div id="successMessage" class="alert alert-success d-none"></div>

    <form id="profileForm" method="POST" action="<?php echo e(route('profile.update')); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PATCH'); ?>

        <div class="mb-3">
            <label class="form-label text-light">Name</label>
            <input type="text" name="name" class="form-control bg-dark text-light border-secondary" 
                   value="<?php echo e($user->name); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label text-light">Email</label>
            <input type="email" name="email" class="form-control bg-dark text-light border-secondary" 
                   value="<?php echo e($user->email); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label text-light">Password (leave blank to keep current)</label>
            <input type="password" name="password" class="form-control bg-dark text-light border-secondary">
        </div>

        <div class="mb-3">
            <label class="form-label text-light">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control bg-dark text-light border-secondary">
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <!-- Cancel Button -->
            <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-outline-secondary">
                <i class="bi bi-x-circle me-1"></i> Cancel
            </a>

            <!-- Save Button -->
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save2 me-1"></i> Save Changes
            </button>
        </div>
    </form>
</div>

<script>
document.getElementById('profileForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    let form = this;
    let formData = new FormData(form);

    try {
        let response = await fetch(form.action, {
            method: "POST", // Laravel will handle _method=PATCH
            headers: { "X-CSRF-TOKEN": formData.get("_token") },
            body: formData
        });

        if (response.ok) {
            let msgBox = document.getElementById('successMessage');
            msgBox.textContent = "Profile updated successfully!";
            msgBox.classList.remove("d-none");

            setTimeout(() => msgBox.classList.add("d-none"), 3000);
        } else {
            alert("Error updating profile.");
        }
    } catch (err) {
        console.error(err);
        alert("Something went wrong.");
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pundohub\resources\views/profile/edit.blade.php ENDPATH**/ ?>