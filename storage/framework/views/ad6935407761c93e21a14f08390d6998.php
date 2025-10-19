

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <h2 class="mb-4 text-white">Add New Member</h2>

    <!-- Success Message -->
    <?php if(session('success')): ?>
        <div id="successMessage" class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <form id="memberForm" action="<?php echo e(route('members.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <div class="mb-3">
            <label class="form-label text-light">Full Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control bg-dark text-light border-secondary" 
                   placeholder="Enter member name" required>
        </div>

        <div class="mb-3">
            <label class="form-label text-light">Email Address <span class="text-danger">*</span></label>
            <input type="email" name="email" class="form-control bg-dark text-light border-secondary" 
                   placeholder="Enter email address" required>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label text-light">Password <span class="text-danger">*</span></label>
                <input type="password" name="password" class="form-control bg-dark text-light border-secondary" 
                       placeholder="Enter password" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label text-light">Confirm Password <span class="text-danger">*</span></label>
                <input type="password" name="password_confirmation" class="form-control bg-dark text-light border-secondary" 
                       placeholder="Confirm password" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label text-light">Household</label>
            <input type="text" name="household" class="form-control bg-dark text-light border-secondary" 
                   placeholder="Enter household (optional)">
        </div>

        <div class="mb-3">
            <label class="form-label text-light">Contact Number</label>
            <input type="text" name="contact" class="form-control bg-dark text-light border-secondary" 
                   placeholder="Enter contact number">
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="<?php echo e(route('members.index')); ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left-circle me-1"></i> Back
            </a>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save2 me-1"></i> Save Member
            </button>
        </div>
    </form>
</div>

<script>
document.getElementById('memberForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    let form = this;
    let formData = new FormData(form);

    try {
        let response = await fetch(form.action, {
            method: "POST",
            headers: { "X-CSRF-TOKEN": formData.get("_token") },
            body: formData
        });

        if (response.ok) {
            let msgBox = document.getElementById('successMessage');
            msgBox.textContent = "Member added successfully!";
            msgBox.classList.remove("d-none");

            setTimeout(() => msgBox.classList.add("d-none"), 3000);
            form.reset();
        } else {
            alert("Error adding member.");
        }
    } catch (err) {
        console.error(err);
        alert("Something went wrong.");
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pundohub\resources\views/members/create.blade.php ENDPATH**/ ?>