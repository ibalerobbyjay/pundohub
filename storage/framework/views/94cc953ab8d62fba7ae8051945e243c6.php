<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <h2 class="mb-4">Add Donation</h2>

    
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php
        $recentCase = $cases->sortByDesc('created_at')->first();
        $userHasRecentCase = $recentCase && $recentCase->user_id === auth()->id();
    ?>

    
    <form action="<?php echo e(route('donations.store')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>

        <!-- Donor -->
        <div class="mb-3">
            <label class="form-label">Donor</label>
            <input type="text" class="form-control" value="<?php echo e(Auth::user()->name); ?>" readonly>
        </div>

        <!-- Donation Type -->
        <div class="mb-3">
            <label for="type" class="form-label">Donation Type</label>
            <select name="type" id="type" class="form-select" <?php echo e($userHasRecentCase ? 'disabled' : ''); ?> required>
                <option value="">Select type</option>
                <option value="Firewood">Firewood</option>
                <option value="Rice">Rice</option>
                <option value="Money">Money</option>
            </select>
        </div>

        <!-- Amount (only required for Money) -->
        <div class="mb-3">
            <label for="amount" class="form-label">Amount (₱)</label>
            <input type="number" name="amount" id="amount" class="form-control" step="0.01" min="100" 
                   <?php echo e($userHasRecentCase ? 'disabled' : ''); ?> placeholder="Enter amount (only for Money)">
        </div>

        <!-- Bereavement Case -->
        <div class="mb-3">
            <label for="bereavement_case_id" class="form-label">Bereavement Case (optional)</label>
            <select name="bereavement_case_id" id="bereavement_case_id" class="form-select" <?php echo e($userHasRecentCase ? 'disabled' : ''); ?>>
                <option value="">None</option>
                <?php $__currentLoopData = $cases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $case): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($case->id); ?>">
                        <?php echo e($case->title); ?> (<?php echo e($case->user->name ?? 'Unknown Member'); ?>)
                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <!-- ✅ Proof of Donation -->
        <div class="mb-3">
            <label for="proof" class="form-label">Proof of Donation (Photo or Receipt)</label>
            <input type="file" name="proof" id="proof" class="form-control" accept="image/*" required>
            <small class="text-muted">Upload a clear photo of your proof (JPG, PNG, max 2MB).</small>

            
            <div class="mt-3 text-center">
                <img id="proofPreview" src="#" alt="Preview" 
                     class="img-thumbnail d-none" 
                     style="max-width: 200px; height: auto;">
            </div>
        </div>

        <button type="submit" class="btn btn-primary" <?php echo e($userHasRecentCase ? 'disabled' : ''); ?>>Save Donation</button>
    </form>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const typeSelect = document.getElementById('type');
    const amountInput = document.getElementById('amount');
    const proofInput = document.getElementById('proof');
    const proofPreview = document.getElementById('proofPreview');

    // Toggle amount field
    function toggleAmount() {
        if (typeSelect.value === 'Money') {
            amountInput.removeAttribute('disabled');
            amountInput.required = true;
        } else {
            amountInput.value = '';
            amountInput.setAttribute('disabled', 'disabled');
            amountInput.required = false;
        }
    }

    typeSelect.addEventListener('change', toggleAmount);
    toggleAmount();

    // ✅ Show image preview when selected
    proofInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                proofPreview.src = e.target.result;
                proofPreview.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        } else {
            proofPreview.classList.add('d-none');
            proofPreview.src = '#';
        }
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pundohub\resources\views/donations/create.blade.php ENDPATH**/ ?>