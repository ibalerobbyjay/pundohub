@extends('layouts.app') 
@section('content')
<div class="max-w-md mx-auto mt-10 p-8 bg-white rounded-xl shadow-lg border border-gray-200">

    <h2 class="text-2xl font-semibold mb-6 text-gray-800">Report a Death</h2>

    <!-- Success Alert -->
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" 
         x-init="setTimeout(() => show = false, 3000)" 
         class="mb-5 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg flex justify-between items-center transition-all duration-500">
        <span>{{ session('success') }}</span>
        <button @click="show = false" class="text-green-700 font-bold">&times;</button>
    </div>
    @endif

    <form action="{{ route('report.death.store') }}" method="POST" class="space-y-5">
        @csrf

        <div>
            <label class="block text-gray-700 font-medium mb-2">Name of Deceased</label>
            <input type="text" name="name_of_deceased" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>

        <div>
            <label class="block text-gray-700 font-medium mb-2">Date of Death</label>
            <input type="date" name="date_of_death"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>

        <div>
            <label class="block text-gray-700 font-medium mb-2">Notes</label>
            <textarea name="notes" rows="4"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400"></textarea>
        </div>

        <button type="submit"
                class="w-full bg-orange-500 text-white py-2 rounded-lg font-semibold hover:bg-orange-600 transition">
            Submit Report
        </button>
    </form>
</div>
@endsection

<!-- Include Alpine.js for alert functionality if not already in your layout -->
@push('scripts')
<script src="//unpkg.com/alpinejs" defer></script>
@endpush
