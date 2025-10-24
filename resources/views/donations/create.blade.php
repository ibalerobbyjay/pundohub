@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Add Donation</h2>

    {{-- ✅ Success message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @php
        $recentCase = $cases->sortByDesc('created_at')->first();
        $userHasRecentCase = $recentCase && $recentCase->user_id === auth()->id();
    @endphp

    {{-- ✅ enctype added to allow file upload --}}
    <form action="{{ route('donations.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Donor -->
        <div class="mb-3">
            <label class="form-label">Donor</label>
            <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
        </div>

        <!-- Donation Type -->
        <div class="mb-3">
            <label for="type" class="form-label">Donation Type</label>
            <select name="type" id="type" class="form-select" {{ $userHasRecentCase ? 'disabled' : '' }} required>
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
                   {{ $userHasRecentCase ? 'disabled' : '' }} placeholder="Enter amount (only for Money)">
        </div>

        <!-- Bereavement Case -->
        <div class="mb-3">
            <label for="bereavement_case_id" class="form-label">Bereavement Case (optional)</label>
            <select name="bereavement_case_id" id="bereavement_case_id" class="form-select" {{ $userHasRecentCase ? 'disabled' : '' }}>
                <option value="">None</option>
                @foreach ($cases as $case)
                    <option value="{{ $case->id }}">
                        {{ $case->title }} ({{ $case->user->name ?? 'Unknown Member' }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- ✅ Proof of Donation -->
        <div class="mb-3">
            <label for="proof" class="form-label">Proof of Donation (Photo or Receipt)</label>
            <input type="file" name="proof" id="proof" class="form-control" accept="image/*" required>
            <small class="text-muted">Upload a clear photo of your proof (JPG, PNG, max 2MB).</small>

            {{-- ✅ Preview container --}}
            <div class="mt-3 text-center">
                <img id="proofPreview" src="#" alt="Preview" 
                     class="img-thumbnail d-none" 
                     style="max-width: 200px; height: auto;">
            </div>
        </div>

        <button type="submit" class="btn btn-primary" {{ $userHasRecentCase ? 'disabled' : '' }}>Save Donation</button>
    </form>
</div>

{{-- ✅ Scripts --}}
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
@endsection
