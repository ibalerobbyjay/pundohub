

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <h1 class="mb-4">Add Donation</h1>

    <!-- Success Message -->
    <div id="successMessage" class="alert alert-success d-none"></div>

    <form id="donationForm" action="<?php echo e(route('donations.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <!-- Donor -->
        <div class="mb-3">
            <label for="member_id" class="form-label">Donor Name</label>
            <select name="member_id" id="member_id" class="form-control" required>
                <option value="">Select a member</option>
                <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($member->id); ?>"><?php echo e($member->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <!-- Bereavement Case -->
        <div class="mb-3">
            <label for="bereavement_case_id" class="form-label">Bereavement Case (Optional)</label>
            <select name="bereavement_case_id" id="bereavement_case_id" class="form-control">
                <option value="">None</option>
                <?php $__currentLoopData = $cases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $case): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($case->id); ?>"><?php echo e($case->title); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <!-- Amount -->
        <div class="mb-3">
            <label for="amount" class="form-label">Amount</label>
            <input type="number" name="amount" id="amount" class="form-control" required>
        </div>

        <!-- Type -->
        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <input type="text" name="type" id="type" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Save Donation</button>
    </form>
</div>

<script>
document.getElementById('donationForm').addEventListener('submit', async function(e) {
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
            // Clear all fields
            form.reset();

            // Show success message
            let msgBox = document.getElementById('successMessage');
            msgBox.textContent = "Donation saved successfully!";
            msgBox.classList.remove("d-none");

            // Hide after 3 seconds
            setTimeout(() => msgBox.classList.add("d-none"), 3000);
        } else {
            alert("Error saving donation.");
        }
    } catch (err) {
        console.error(err);
        alert("Something went wrong.");
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pundohub\resources\views/donations/create.blade.php ENDPATH**/ ?>