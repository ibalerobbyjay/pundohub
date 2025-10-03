<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <h2>Edit Profile</h2>

    <!-- Success Message -->
    <div id="successMessage" class="alert alert-success d-none"></div>

    <form id="profileForm" method="POST" action="<?php echo e(route('profile.update')); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PATCH'); ?>

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo e($user->name); ?>" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo e($user->email); ?>" required>
        </div>

        <div class="mb-3">
            <label>Password (leave blank to keep current)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <button class="btn btn-primary">Save</button>
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
            // Clear form fields
            form.reset();

            // Show success message
            let msgBox = document.getElementById('successMessage');
            msgBox.textContent = "Profile updated successfully!";
            msgBox.classList.remove("d-none");

            // Hide after 3 seconds
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