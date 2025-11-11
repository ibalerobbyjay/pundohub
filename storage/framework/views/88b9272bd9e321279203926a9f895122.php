

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <h2 class="mb-4 text-info text-center fw-bold">
        <i class="bi bi-file-earmark-medical-fill me-2 text-danger"></i> Report a Death
    </h2>

    <!-- Success Message -->
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Validation Errors -->
    <?php if($errors->any()): ?>
        <div class="alert alert-danger rounded-3 shadow-sm">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card bg-dark text-light border-secondary shadow-lg rounded-4">
        <div class="card-body p-4">
            <form action="<?php echo e(route('report.death.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                <!-- Name of Deceased -->
                <div class="mb-3">
                    <label for="name_of_deceased" class="form-label fw-semibold">Name of Deceased <span class="text-danger">*</span></label>
                    <input 
                        type="text" 
                        id="name_of_deceased" 
                        name="name_of_deceased" 
                        value="<?php echo e(old('name_of_deceased')); ?>"
                        class="form-control bg-dark text-light border-secondary rounded-3" 
                        placeholder="Enter the full name"
                        required
                    >
                </div>

                <!-- Date of Death -->
                <div class="mb-3">
                    <label for="date_of_death" class="form-label fw-semibold">Date of Death <span class="text-danger">*</span></label>
                    <input 
                        type="date" 
                        id="date_of_death" 
                        name="date_of_death" 
                        value="<?php echo e(old('date_of_death')); ?>"
                        class="form-control bg-dark text-light border-secondary rounded-3"
                        required
                    >
                </div>

                <!-- Cause of Death -->
                <div class="mb-3">
                    <label for="cause_of_death" class="form-label fw-semibold">Cause of Death <span class="text-danger">*</span></label>
                    <select 
                        id="cause_of_death" 
                        name="cause_of_death" 
                        class="form-select bg-dark text-light border-secondary rounded-3"
                        required
                    >
                        <option value="">Select cause of death</option>
                        <option value="Natural Causes" <?php echo e(old('cause_of_death') == 'Natural Causes' ? 'selected' : ''); ?>>Natural Causes</option>
                        <option value="Illness" <?php echo e(old('cause_of_death') == 'Illness' ? 'selected' : ''); ?>>Illness</option>
                        <option value="Accident" <?php echo e(old('cause_of_death') == 'Accident' ? 'selected' : ''); ?>>Accident</option>
                        <option value="Old Age" <?php echo e(old('cause_of_death') == 'Old Age' ? 'selected' : ''); ?>>Old Age</option>
                        <option value="Cardiac Arrest" <?php echo e(old('cause_of_death') == 'Cardiac Arrest' ? 'selected' : ''); ?>>Cardiac Arrest</option>
                        <option value="Respiratory Failure" <?php echo e(old('cause_of_death') == 'Respiratory Failure' ? 'selected' : ''); ?>>Respiratory Failure</option>
                        <option value="Other" <?php echo e(old('cause_of_death') == 'Other' ? 'selected' : ''); ?>>Other</option>
                    </select>
                </div>

                <!-- If Other is selected, show additional field -->
                <div class="mb-3" id="other_cause_field" style="display: <?php echo e(old('cause_of_death') == 'Other' ? 'block' : 'none'); ?>;">
                    <label for="other_cause" class="form-label fw-semibold">Specify Cause</label>
                    <input 
                        type="text" 
                        id="other_cause" 
                        name="other_cause" 
                        value="<?php echo e(old('other_cause')); ?>"
                        class="form-control bg-dark text-light border-secondary rounded-3" 
                        placeholder="Please specify the cause of death"
                    >
                </div>

                <!-- Location of Death -->
                <div class="mb-3">
                    <label for="location_of_death" class="form-label fw-semibold">Location of Death <span class="text-danger">*</span></label>
                    <input 
                        type="text" 
                        id="location_of_death" 
                        name="location_of_death" 
                        value="<?php echo e(old('location_of_death')); ?>"
                        class="form-control bg-dark text-light border-secondary rounded-3" 
                        placeholder="e.g., Hospital, Home, Nursing Home, etc."
                        required
                    >
                </div>

                <!-- Notes -->
                <div class="mb-3">
                    <label for="notes" class="form-label fw-semibold">Additional Notes</label>
                    <textarea 
                        id="notes" 
                        name="notes" 
                        rows="4" 
                        class="form-control bg-dark text-light border-secondary rounded-3"
                        placeholder="Optional: add any other relevant details..."><?php echo e(old('notes')); ?></textarea>
                </div>

                <!-- Death Certificate Upload -->
                <div class="mb-4">
                    <label for="death_certificate" class="form-label fw-semibold">Upload Death Certificate <span class="text-danger">*</span></label>
                    <input 
                        type="file" 
                        id="death_certificate" 
                        name="death_certificate" 
                        class="form-control bg-dark text-light border-secondary rounded-3" 
                        accept=".jpg,.jpeg,.png,.pdf" 
                        required
                        onchange="previewFile(event)"
                    >
                    <small class="text-muted d-block mt-1">Accepted formats: JPG, PNG, or PDF (max 2MB)</small>

                    <!-- Preview Area -->
                    <div id="filePreview" class="mt-3"></div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary w-100 rounded-pill py-2">
                    <i class="bi bi-send me-1"></i> Submit Report
                </button>
            </form>
        </div>
    </div>
</div>

<!-- File Preview Script -->
<script>
    function previewFile(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('filePreview');
        preview.innerHTML = ''; // clear previous

        if (!file) return;

        if (file.type.includes('image')) {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.classList.add('img-thumbnail', 'mt-2', 'shadow-sm');
            img.style.maxWidth = '200px';
            img.style.borderRadius = '8px';
            preview.appendChild(img);
        } else if (file.type === 'application/pdf') {
            preview.innerHTML = '<p class="text-info mt-2"><i class="bi bi-file-earmark-pdf"></i> PDF file selected: ' + file.name + '</p>';
        } else {
            preview.innerHTML = '<p class="text-warning mt-2">Unsupported file type selected.</p>';
        }
    }

    // Show/hide other cause field
    document.getElementById('cause_of_death').addEventListener('change', function() {
        const otherCauseField = document.getElementById('other_cause_field');
        if (this.value === 'Other') {
            otherCauseField.style.display = 'block';
        } else {
            otherCauseField.style.display = 'none';
            document.getElementById('other_cause').value = '';
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pundohub\resources\views/death-reports/create.blade.php ENDPATH**/ ?>