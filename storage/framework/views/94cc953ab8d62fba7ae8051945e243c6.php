<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    
    <div class="text-center mb-5">
        <div class="bg-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
             style="width: 70px; height: 70px;">
            <i class="bi bi-gift-fill text-white" style="font-size: 1.8rem;"></i>
        </div>
        <h2 class="text-light fw-bold mb-2">Add Donation</h2>
        <p class="text-light">Contribute to support bereavement cases</p>
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

    <?php
        $recentCase = $cases->sortByDesc('created_at')->first();
        $userHasRecentCase = $recentCase && $recentCase->user_id === auth()->id();
        $latestCases = $cases->sortByDesc('created_at')->take(5);
    ?>

    
    <div class="card border-0 shadow-lg rounded-4">
        <div class="card-body p-5">
            <form action="<?php echo e(route('donations.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                <div class="row">
                    
                    <div class="col-lg-6">
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">
                                <i class="bi bi-person-fill text-primary me-2"></i>Donor Information
                            </label>
                            <div class="card bg-light border-0 rounded-3">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                            <i class="bi bi-person-check text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold text-dark mb-0"><?php echo e(Auth::user()->name); ?></h6>
                                            <small class="text-muted"><?php echo e(ucfirst(Auth::user()->role)); ?></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <div class="mb-4">
                            <label for="type" class="form-label fw-semibold text-dark">
                                <i class="bi bi-tags-fill text-warning me-2"></i>Donation Type <span class="text-danger">*</span>
                            </label>
                            <select name="type" id="type" class="form-select border-0 rounded-3 bg-light" <?php echo e($userHasRecentCase ? 'disabled' : ''); ?> required>
                                <option value="" disabled selected>Select donation type</option>
                                <option value="Firewood">Firewood</option>
                                <option value="Rice">Rice</option>
                                <option value="Money">Money</option>
                            </select>
                        </div>

                        
                        <div class="mb-4">
                            <label for="amount" class="form-label fw-semibold text-dark">
                                <i class="bi bi-currency-exchange text-success me-2"></i>Amount (₱)
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0">₱</span>
                                <input type="number" name="amount" id="amount" class="form-control border-0 rounded-3 bg-light" 
                                       step="0.01" min="100" <?php echo e($userHasRecentCase ? 'disabled' : ''); ?> 
                                       placeholder="Enter amount (only for Money donations)">
                            </div>
                            <div class="form-text text-muted">
                                Minimum amount: ₱100.00
                            </div>
                        </div>
                    </div>

                    
                    <div class="col-lg-6">
                        
                        <div class="mb-4">
                            <label for="bereavement_case_id" class="form-label fw-semibold text-dark">
                                <i class="bi bi-heartbreak-fill text-danger me-2"></i>Bereavement Case <span class="text-danger">*</span>
                            </label>
                            <select name="bereavement_case_id" id="bereavement_case_id" class="form-select border-0 rounded-3 bg-light" 
                                    <?php echo e($userHasRecentCase ? 'disabled' : ''); ?> required>
                                <option value="" disabled selected>Select a bereavement case</option>
                                <?php $__currentLoopData = $latestCases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $case): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($case->id); ?>">
                                        <?php echo e($case->title); ?> (<?php echo e($case->user->name ?? 'Unknown Member'); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div class="form-text text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Showing the 5 latest bereavement cases
                            </div>
                        </div>

                        
                        <div class="mb-4">
                            <label for="proof" class="form-label fw-semibold text-dark">
                                <i class="bi bi-camera-fill text-info me-2"></i>Proof of Donation <span class="text-danger">*</span>
                            </label>
                            <div class="card bg-light border-0 rounded-3">
                                <div class="card-body">
                                    <input type="file" name="proof" id="proof" 
                                           class="form-control border-0 rounded-3 bg-white" 
                                           accept="image/*" required
                                           onchange="previewImage(event)">
                                    <div class="form-text text-muted mt-2">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Upload a clear photo or receipt (JPG, PNG, max 2MB)
                                    </div>

                                    
                                    <div id="imagePreview" class="mt-3 text-center"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="d-flex justify-content-between align-items-center pt-4 border-top">
                    <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-outline-secondary rounded-3 px-4">
                        <i class="bi bi-arrow-left me-2"></i> Back to Dashboard
                    </a>
                    
                    <?php if($userHasRecentCase): ?>
                        <div class="alert alert-warning border-0 rounded-3 mb-0">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <div>
                                    <strong>Notice:</strong> You cannot donate to your own recent bereavement case.
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <button type="submit" class="btn btn-warning text-white fw-bold rounded-3 px-4 py-2">
                            <i class="bi bi-check-circle me-2"></i> Submit Donation
                        </button>
                    <?php endif; ?>
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
        box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.15);
        border-color: #ffc107;
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

    .btn-warning {
        background: linear-gradient(135deg, #ffc107, #e0a800);
        border: none;
    }

    .btn-warning:hover {
        background: linear-gradient(135deg, #e0a800, #d39e00);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 193, 7, 0.4);
        color: white !important;
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

    .alert-warning {
        background: linear-gradient(135deg, #fff3cd, #ffeaa7);
        border: none;
        color: #856404;
    }

    .img-thumbnail {
        border: 3px solid #ffc107;
        transition: all 0.3s ease;
    }

    .img-thumbnail:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);
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

    /* Custom scrollbar for select */
    .form-select::-webkit-scrollbar {
        width: 6px;
    }

    .form-select::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .form-select::-webkit-scrollbar-thumb {
        background: #ffc107;
        border-radius: 10px;
    }

    .form-select::-webkit-scrollbar-thumb:hover {
        background: #e0a800;
    }
</style>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const typeSelect = document.getElementById('type');
        const amountInput = document.getElementById('amount');
        const bereavementCaseSelect = document.getElementById('bereavement_case_id');
        const form = document.querySelector('form');

        // Toggle amount field for Money type
        function toggleAmount() {
            if (typeSelect.value === 'Money') {
                amountInput.removeAttribute('disabled');
                amountInput.required = true;
                amountInput.parentElement.classList.add('focused');
            } else {
                amountInput.value = '';
                amountInput.setAttribute('disabled', 'disabled');
                amountInput.required = false;
                amountInput.parentElement.classList.remove('focused');
            }
        }

        // Initialize amount field state
        typeSelect.addEventListener('change', toggleAmount);
        toggleAmount();

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

        // Real-time validation for amount
        if (amountInput) {
            amountInput.addEventListener('input', function() {
                const value = parseFloat(this.value);
                if (value < 100 && this.value !== '') {
                    this.setCustomValidity('Minimum donation amount is ₱100.00');
                } else {
                    this.setCustomValidity('');
                }
            });
        }
    });

    // Image Preview Function
    function previewImage(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = ''; // clear previous preview

        if (!file) return;

        // Validate file type
        const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!validTypes.includes(file.type)) {
            preview.innerHTML = `
                <div class="alert alert-danger border-0 rounded-3 mt-2">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Please select a valid image file (JPG or PNG)
                </div>
            `;
            event.target.value = ''; // clear the file input
            return;
        }

        // Validate file size (2MB)
        const maxSize = 2 * 1024 * 1024; // 2MB in bytes
        if (file.size > maxSize) {
            preview.innerHTML = `
                <div class="alert alert-danger border-0 rounded-3 mt-2">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    File size must be less than 2MB
                </div>
            `;
            event.target.value = ''; // clear the file input
            return;
        }

        // Create and display image preview
        const imgContainer = document.createElement('div');
        imgContainer.className = 'd-flex flex-column align-items-center';
        
        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        img.classList.add('img-thumbnail', 'mt-2', 'shadow-sm');
        img.style.maxWidth = '250px';
        img.style.maxHeight = '250px';
        img.style.borderRadius = '12px';
        img.style.objectFit = 'cover';
        
        // Add file info
        const fileInfo = document.createElement('div');
        fileInfo.className = 'mt-2 text-center';
        fileInfo.innerHTML = `
            <small class="text-muted">
                <i class="bi bi-check-circle-fill text-success me-1"></i>
                File ready for upload<br>
                Size: ${(file.size / 1024 / 1024).toFixed(2)} MB
            </small>
        `;
        
        imgContainer.appendChild(img);
        imgContainer.appendChild(fileInfo);
        preview.appendChild(imgContainer);

        // Clean up URL when image is loaded
        img.onload = function() {
            URL.revokeObjectURL(img.src);
        }
    }

    // Enhanced file validation
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('proof');
        if (fileInput) {
            fileInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    // Additional validation on change
                    const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                    const maxSize = 2 * 1024 * 1024;
                    
                    if (!validTypes.includes(file.type)) {
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Invalid File Type',
                                text: 'Please select only image files (JPG or PNG)',
                                confirmButtonColor: '#dc3545'
                            });
                        } else {
                            alert('Please select only image files (JPG or PNG)');
                        }
                        event.target.value = '';
                        return;
                    }
                    
                    if (file.size > maxSize) {
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'error',
                                title: 'File Too Large',
                                text: 'File size must be less than 2MB',
                                confirmButtonColor: '#dc3545'
                            });
                        } else {
                            alert('File size must be less than 2MB');
                        }
                        event.target.value = '';
                        return;
                    }
                }
            });
        }
    });
</script>



<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pundohub\resources\views/donations/create.blade.php ENDPATH**/ ?>