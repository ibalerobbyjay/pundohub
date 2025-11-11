<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <h2 class="mb-4 text-info fw-bold text-center">
        <i class="bi bi-gift-fill me-2 text-warning"></i> Add Donation
    </h2>

    
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php
        $recentCase = $cases->sortByDesc('created_at')->first();
        $userHasRecentCase = $recentCase && $recentCase->user_id === auth()->id();
        $latestCases = $cases->sortByDesc('created_at')->take(5);
    ?>

    <form action="<?php echo e(route('donations.store')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>

        <div class="card p-4 shadow-lg rounded-4 bg-dark text-light" 
             style="background: rgba(25,25,25,0.85); backdrop-filter: blur(12px);">

            <!-- Donor -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Donor</label>
                <input type="text" class="form-control bg-dark text-light border-secondary" value="<?php echo e(Auth::user()->name); ?>" readonly>
            </div>

            <!-- Donation Type -->
            <div class="mb-3">
                <label for="type" class="form-label fw-semibold">Donation Type</label>
                <select name="type" id="type" class="form-select bg-dark text-light border-secondary" <?php echo e($userHasRecentCase ? 'disabled' : ''); ?> required>
                    <option value="" disabled selected>Select donation type</option>
                    <option value="Firewood">Firewood</option>
                    <option value="Rice">Rice</option>
                    <option value="Money">Money</option>
                </select>
            </div>

            <!-- Amount (only for Money) -->
            <div class="mb-3">
                <label for="amount" class="form-label fw-semibold">Amount (₱)</label>
                <input type="number" name="amount" id="amount" class="form-control bg-dark text-light border-secondary" step="0.01" min="100" 
                       <?php echo e($userHasRecentCase ? 'disabled' : ''); ?> placeholder="Enter amount (only for Money)">
            </div>

            <!-- Bereavement Case -->
            <div class="mb-3">
                <label for="bereavement_case_id" class="form-label fw-semibold text-danger">Bereavement Case *</label>
                <select name="bereavement_case_id" id="bereavement_case_id" class="form-select bg-dark text-light border-secondary" 
                        <?php echo e($userHasRecentCase ? 'disabled' : ''); ?> required>
                    <option value="" disabled selected>Select a bereavement case</option>
                    <?php $__currentLoopData = $latestCases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $case): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($case->id); ?>">
                            <?php echo e($case->title); ?> (<?php echo e($case->user->name ?? 'Unknown Member'); ?>)
                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <small class="text-muted">Showing the 5 latest bereavement cases.</small>
            </div>

            <!-- Proof of Donation -->
            <div class="mb-3">
                <label for="proof" class="form-label fw-semibold">Proof of Donation (Photo or Receipt)</label>
                <input type="file" name="proof" id="proof" class="form-control bg-dark text-light border-secondary" accept="image/*" required>
                <small class="text-muted">Upload a clear photo (JPG, PNG, max 2MB).</small>
                <div class="mt-3 text-center">
                    <img id="proofPreview" src="#" alt="Preview" 
                         class="img-thumbnail d-none" 
                         style="max-width: 200px; height: auto;">
                </div>
            </div>

            <button type="submit" class="btn btn-info w-100 fw-bold mt-3" <?php echo e($userHasRecentCase ? 'disabled' : ''); ?>>
                <i class="bi bi-check-circle me-1"></i> Save Donation
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const typeSelect = document.getElementById('type');
    const amountInput = document.getElementById('amount');
    const proofInput = document.getElementById('proof');
    const proofPreview = document.getElementById('proofPreview');
    const form = document.querySelector('form');
    const caseSelect = document.getElementById('bereavement_case_id');

    // Toggle amount field for Money type
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

    // Image preview
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