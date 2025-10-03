@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Add Donation</h1>

    <!-- Success Message -->
    <div id="successMessage" class="alert alert-success d-none"></div>

    <form id="donationForm" action="{{ route('donations.store') }}" method="POST">
        @csrf

        <!-- Donor -->
        <div class="mb-3">
            <label for="member_id" class="form-label">Donor Name</label>
            <select name="member_id" id="member_id" class="form-control" required>
                <option value="">Select a member</option>
                @foreach($members as $member)
                    <option value="{{ $member->id }}">{{ $member->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Bereavement Case -->
        <div class="mb-3">
            <label for="bereavement_case_id" class="form-label">Bereavement Case (Optional)</label>
            <select name="bereavement_case_id" id="bereavement_case_id" class="form-control">
                <option value="">None</option>
                @foreach($cases as $case)
                    <option value="{{ $case->id }}">{{ $case->title }}</option>
                @endforeach
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
@endsection
