@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-info fw-bold text-center">
        <i class="bi bi-gift-fill me-2 text-warning"></i> Add Donation
    </h2>

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

    <form action="{{ route('donations.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card p-4 shadow-lg rounded-4 bg-dark text-light" 
             style="background: rgba(25,25,25,0.85); backdrop-filter: blur(12px);">

            <!-- Donor -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Donor</label>
                <input type="text" class="form-control bg-dark text-light border-secondary" value="{{ Auth::user()->name }}" readonly>
            </div>

            <!-- Donation Type -->
            <div class="mb-3">
                <label for="type" class="form-label fw-semibold">Donation Type</label>
                <select name="type" id="type" class="form-select bg-dark text-light border-secondary" {{ $userHasRecentCase ? 'disabled' : '' }} required>
                    <option value="" disabled selected>Select donation type</option>
                    <option value="Rice,Firewood,Money">Rice, Firewood, Money</option>
                    <option value="Money">Money</option>
                    <option value="Rice,Firewood">Rice, Firewood</option>
                </select>
            </div>

            <!-- Amount (only for Money-containing types) -->
            <div class="mb-3" id="amountField">
                <label for="amount" class="form-label fw-semibold">Amount (₱)</label>
                <input type="number" name="amount" id="amount" class="form-control bg-dark text-light border-secondary" step="0.01" min="100" 
                       {{ $userHasRecentCase ? 'disabled' : '' }} placeholder="Enter amount">
                <div class="form-text text-muted" id="amountHelp">
                    Amount field is required for donations that include Money
                </div>
            </div>

            <!-- Bereavement Case -->
            <div class="mb-3">
                <label for="bereavement_case_id" class="form-label fw-semibold text-danger">Bereavement Case *</label>
                <select name="bereavement_case_id" id="bereavement_case_id" class="form-select bg-dark text-light border-secondary" 
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
                <input type="file" name="proof" id="proof" class="form-control bg-dark text-light border-secondary" accept="image/*" required>
                <small class="text-muted">Upload a clear photo (JPG, PNG, max 2MB).</small>
                <div class="mt-3 text-center">
                    <img id="proofPreview" src="#" alt="Preview" 
                         class="img-thumbnail d-none" 
                         style="max-width: 200px; height: auto;">
                </div>
            </div>

            <button type="submit" class="btn btn-info w-100 fw-bold mt-3" {{ $userHasRecentCase ? 'disabled' : '' }}>
                <i class="bi bi-check-circle me-1"></i> Save Donation
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const typeSelect = document.getElementById('type');
    const amountInput = document.getElementById('amount');
    const amountHelp = document.getElementById('amountHelp');
    const proofInput = document.getElementById('proof');
    const proofPreview = document.getElementById('proofPreview');

    // Toggle amount field based on donation type
    function toggleAmount() {
        const selectedType = typeSelect.value;
        
        // Enable amount for types that include Money
        if (selectedType === 'Money' || selectedType === 'Rice,Firewood,Money') {
            amountInput.removeAttribute('disabled');
            amountInput.required = true;
            amountHelp.textContent = "Amount field is required for donations that include Money";
            amountHelp.className = "form-text text-info";
        } 
        // Disable amount for Rice,Firewood only
        else if (selectedType === 'Rice,Firewood') {
            amountInput.value = '';
            amountInput.setAttribute('disabled', 'disabled');
            amountInput.required = false;
            amountHelp.textContent = "Amount field is not required for Rice and Firewood donations";
            amountHelp.className = "form-text text-muted";
        }
        // Default state
        else {
            amountInput.setAttribute('disabled', 'disabled');
            amountInput.required = false;
            amountHelp.textContent = "Please select a donation type first";
            amountHelp.className = "form-text text-muted";
        }
    }

    typeSelect.addEventListener('change', toggleAmount);
    toggleAmount(); // Initialize on page load

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
@endsection