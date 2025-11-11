<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg rounded-4 text-light"
                 style="background: rgba(20, 20, 20, 0.9); backdrop-filter: blur(10px);">
                <div class="card-body p-5">
                    <h2 class="mb-4 text-info text-center">
                        <i class="bi bi-pencil-square me-2"></i> Edit Bereavement Case
                    </h2>

                    
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i> <?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    
                    <form action="<?php echo e(route('bereavement-cases.update', $case->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="mb-4">
                            <label for="title" class="form-label fw-semibold text-light">
                                Title <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="title" 
                                   id="title" 
                                   class="form-control bg-dark text-light border-secondary rounded-3"
                                   value="<?php echo e(old('title', $case->title)); ?>" required
                                   placeholder="Enter case title">
                        </div>

                        <div class="mb-4">
                            <label for="user_id" class="form-label fw-semibold text-light">
                                Select Member <span class="text-danger">*</span>
                            </label>
                            <select name="user_id" id="user_id" 
                                    class="form-select bg-dark text-light border-secondary rounded-3" required>
                                <option value="">-- Select Member --</option>
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($user->id); ?>" <?php echo e($user->id == $case->user_id ? 'selected' : ''); ?>>
                                        <?php echo e($user->name); ?> (<?php echo e(ucfirst($user->role)); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="date_of_death" class="form-label fw-semibold text-light">
                                Date of Death <span class="text-danger">*</span>
                            </label>
                            <input type="date" 
                                   name="date_of_death" 
                                   id="date_of_death" 
                                   class="form-control bg-dark text-light border-secondary rounded-3"
                                   value="<?php echo e(old('date_of_death', $case->date_of_death->format('Y-m-d'))); ?>" required>
                        </div>

                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-light">
                                Case Details <span class="text-danger">*</span>
                            </label>
                            <div class="card bg-dark border-secondary rounded-3">
                                <div class="card-body">
                                    
                                    <div class="mb-3">
                                        <label for="description_what" class="form-label text-light small">
                                            What (Type of Service/Event) <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" 
                                               name="description_what" 
                                               id="description_what" 
                                               class="form-control bg-dark text-light border-secondary rounded-3"
                                               value="<?php echo e(old('description_what', $case->description_what)); ?>" required
                                               placeholder="e.g., Wake Service, Funeral, Memorial Mass">
                                    </div>

                                    
                                    <div class="mb-3">
                                        <label for="description_when" class="form-label text-light small">
                                            When (Date & Time) <span class="text-danger">*</span>
                                        </label>
                                        <input type="datetime-local" 
                                               name="description_when" 
                                               id="description_when" 
                                               class="form-control bg-dark text-light border-secondary rounded-3"
                                               value="<?php echo e(old('description_when', $case->description_when ? \Carbon\Carbon::parse($case->description_when)->format('Y-m-d\TH:i') : '')); ?>" required
                                               placeholder="Select date and time">
                                    </div>

                                    
                                    <div class="mb-3">
                                        <label for="description_where" class="form-label text-light small">
                                            Where (Location) <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" 
                                               name="description_where" 
                                               id="description_where" 
                                               class="form-control bg-dark text-light border-secondary rounded-3"
                                               value="<?php echo e(old('description_where', $case->description_where)); ?>" required
                                               placeholder="e.g., St. Mary's Church, Family Residence">
                                    </div>

                                    
                                    <div class="mb-3">
                                        <label for="description_name" class="form-label text-light small">
                                            Name of Deceased <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" 
                                               name="description_name" 
                                               id="description_name" 
                                               class="form-control bg-dark text-light border-secondary rounded-3"
                                               value="<?php echo e(old('description_name', $case->description_name)); ?>" required
                                               placeholder="Full name of the deceased">
                                    </div>

                                    
                                    <div class="mb-3">
                                        <label for="description_notes" class="form-label text-light small">
                                            Additional Notes
                                        </label>
                                        <textarea name="description_notes" 
                                                  id="description_notes" 
                                                  class="form-control bg-dark text-light border-secondary rounded-3" 
                                                  rows="3"
                                                  placeholder="Any additional information about the case..."><?php echo e(old('description_notes', $case->description_notes)); ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <div class="mb-4">
                            <label for="remarks" class="form-label fw-semibold text-light">
                                Remarks
                            </label>
                            <textarea name="remarks" 
                                      id="remarks" 
                                      class="form-control bg-dark text-light border-secondary rounded-3" 
                                      rows="4"
                                      placeholder="Any additional remarks or updates..."><?php echo e(old('remarks', $case->remarks)); ?></textarea>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="<?php echo e(route('bereavement-cases.index')); ?>" class="btn btn-outline-light me-2 rounded-3">
                                <i class="bi bi-arrow-left"></i> Back to Cases
                            </a>
                            <button type="submit" class="btn btn-info text-dark fw-bold rounded-3 px-4">
                                <i class="bi bi-check-circle me-1"></i> Update Case
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 0.25rem rgba(0, 255, 255, 0.25);
        border-color: #17a2b8;
    }
    .btn-info:hover {
        background-color: #0dcaf0 !important;
        color: #000 !important;
        box-shadow: 0 0 10px rgba(13, 202, 240, 0.6);
    }
    .btn-outline-light:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\pundohub\resources\views/bereavement-cases/edit.blade.php ENDPATH**/ ?>