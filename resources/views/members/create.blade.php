@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-white">Add New Member</h2>

    <!-- Success Message -->
    <div id="successMessage" class="alert alert-success d-none">
        Member added successfully!
    </div>

    <form id="memberForm" action="{{ route('members.store') }}" method="POST">
        @csrf

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
            <select name="household" class="form-select bg-dark text-light border-secondary">
                <option value="" selected disabled>Select Purok</option>
                @for ($i = 1; $i <= 7; $i++)
                    <option value="Purok {{ $i }}">Purok {{ $i }}</option>
                @endfor
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label text-light">Contact Number</label>
            <input type="text" 
                   name="contact" 
                   id="contact" 
                   class="form-control bg-dark text-light border-secondary" 
                   placeholder="09XXXXXXXXX" 
                   maxlength="11" 
                   pattern="09\d{9}" 
                   title="Enter an 11-digit Philippine mobile number starting with 09" 
                   required>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('members.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left-circle me-1"></i> Back
            </a>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save2 me-1"></i> Save Member
            </button>
        </div>
    </form>
</div>

<script>
// ✅ Restrict contact number input
const contactInput = document.getElementById('contact');

contactInput.addEventListener('input', function () {
    // Remove non-digit characters
    this.value = this.value.replace(/\D/g, '');

    // Force start with 09
    if (!this.value.startsWith('09')) {
        this.value = '09';
    }

    // Limit to 11 digits
    if (this.value.length > 11) {
        this.value = this.value.slice(0, 11);
    }
});

// ✅ Handle form submission with +63 conversion
document.getElementById('memberForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    let form = this;
    let formData = new FormData(form);
    let contactValue = document.getElementById('contact').value;

    // Validate final format
    if (!/^09\d{9}$/.test(contactValue)) {
        alert("Please enter a valid 11-digit number starting with 09.");
        return;
    }

    // Convert to +63 format
    formData.set('contact', '+63' + contactValue.substring(1));

    try {
        let response = await fetch(form.action, {
            method: "POST",
            headers: { "X-CSRF-TOKEN": formData.get("_token") },
            body: formData
        });

        if (response.ok) {
            // Show success message
            let msgBox = document.getElementById('successMessage');
            msgBox.classList.remove('d-none');

            // Hide after 3 seconds
            setTimeout(() => msgBox.classList.add('d-none'), 3000);

            // Clear the form
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
@endsection
