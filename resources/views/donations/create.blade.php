@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-primary fw-bold">Add Donation</h2>

    {{-- Success message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @php
        $recentCase = $cases->sortByDesc('created_at')->first();
        $userHasRecentCase = $recentCase && $recentCase->user_id === auth()->id();
        $latestCases = $cases->sortByDesc('created_at')->take(5);
    @endphp

    <form action="{{ route('donations.store') }}" method="POST" enctype="multipart/form-data" class="card p-4 shadow-lg bg-light rounded">
        @csrf

        <!-- Donor -->
        <div class="mb-3">
            <label class="form-label fw-semibold">Donor</label>
            <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
        </div>

        <!-- Donation Type -->
        <div class="mb-3">
            <label for="type" class="form-label fw-semibold">Donation Type</label>
            <select name="type" id="type" class="form-select" {{ $userHasRecentCase ? 'disabled' : '' }} required>
                <option value="" disabled selected>Select donation type</option>
                <option value="Firewood">Firewood</option>
                <option value="Rice">Rice</option>
                <option value="Money">Money</option>
            </select>
        </div>

        <!-- Amount (only required for Money) -->
        <div class="mb-3">
            <label for="amount" class="form-label fw-semibold">Amount (₱)</label>
            <input type="number" name="amount" id="amount" class="form-control" step="0.01" min="100" 
                   {{ $userHasRecentCase ? 'disabled' : '' }} placeholder="Enter amount (only for Money)">
        </div>

        <!-- Bereavement Case -->
        <div class="mb-3">
            <label for="bereavement_case_id" class="form-label fw-semibold text-danger">Bereavement Case *</label>
            <select name="bereavement_case_id" id="bereavement_case_id" class="form-select" 
                    {{ $userHasRecentCase ? 'disabled' : '' }} required>
                <option value="" disabled selected>Select a bereavement case</option>
                @foreach ($latestCases as $case)
                    <option value="{{ $case->id }}">
                        {{ $case->title }} ({{ $case->user->name ?? 'Unknown Member' }})
                    </option>
                @endforeach
            </select>
            <small class="text-muted">Showing the 5 latest bereavement cases.</small>
        </div>

        <!-- Proof of Donation -->
        <div class="mb-3">
            <label for="proof" class="form-label fw-semibold">Proof of Donation (Photo or Receipt)</label>
            <input type="file" name="proof" id="proof" class="form-control" accept="image/*" required>
            <small class="text-muted">Upload a clear photo (JPG, PNG, max 2MB).</small>

            <div class="mt-3 text-center">
                <img id="proofPreview" src="#" alt="Preview" 
                     class="img-thumbnail d-none" 
                     style="max-width: 200px; height: auto;">
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 fw-bold" {{ $userHasRecentCase ? 'disabled' : '' }}>
            Save Donation
        </button>
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

    // Validate Bereavement Case selection
    form.addEventListener('submit', function(e) {
        if (!caseSelect.value) {
            e.preventDefault();
            alert('Please select a Bereavement Case.');
            caseSelect.focus();
        }
    });
});
</script>
@endsection
