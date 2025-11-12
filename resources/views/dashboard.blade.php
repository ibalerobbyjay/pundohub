@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">

        
        {{-- Main Content --}}
        <div class="col-md-9 col-lg-10 p-4">

            <h2 class="mb-4 text-white fw-bold">Dashboard</h2>

            {{-- Regular User Dashboard --}}
            @if(auth()->user()->role !== 'admin')
                <div class="row mb-4">
                    {{-- Total Fund (only for members) --}}
                    @if(auth()->user()->role === 'member')
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('donations.history') }}" class="text-decoration-none">
                            <div class="card p-4 bg-dark text-light shadow rounded-4 hover-card">
                                <h5 class="text-info">Total Fund</h5>
                                <p class="fs-5 fw-bold">₱ {{ number_format($userTotalDonations, 2) }}</p>
                            </div>
                        </a>
                    </div>
                    @endif
      
                    {{-- Member Penalties --}}
@php
    $userPenalties = \App\Models\Penalty::with('user')
        ->where('user_id', auth()->id())
        ->get();
@endphp

@if($userPenalties->count() > 0)
    <div class="col-md-4 mb-3">
        <div class="card p-4 bg-dark text-light shadow rounded-4 hover-card position-relative border border-danger"
             data-bs-toggle="modal" data-bs-target="#memberPenaltyModal" style="cursor:pointer;">
            <h5 class="text-danger">
                <i class="bi bi-exclamation-triangle-fill me-1"></i> Penalties
            </h5>
            <p class="fs-5 fw-bold text-danger mb-1">
                ₱ {{ number_format($userPenalties->where('paid', false)->sum('amount'), 2) }}
            </p>
            <small class="text-muted">Unpaid penalties</small>

            @if($userPenalties->where('paid', false)->count() > 0)
                <span class="badge bg-danger position-absolute top-0 end-0 m-3 px-3 py-2">
                    {{ $userPenalties->where('paid', false)->count() }} Unpaid
                </span>
            @else
                <span class="badge bg-success position-absolute top-0 end-0 m-3 px-3 py-2">All Paid</span>
            @endif
        </div>
    </div>
@endif

<!-- Penalty Modal -->
<div class="modal fade" id="memberPenaltyModal" tabindex="-1" aria-labelledby="memberPenaltyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered custom-wide-modal"> <!-- custom class -->
        <div class="modal-content bg-dark text-light border-secondary rounded-4 shadow-lg">
            <div class="modal-header border-secondary">
                <h5 class="modal-title" id="memberPenaltyModalLabel">
                    <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>
                    Your Penalties
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                @if($userPenalties->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-dark table-hover align-middle mb-0">
                            <thead class="table-light text-dark">
                                <tr>
                                    <th class="px-4 py-3">Amount (₱)</th>
                                    <th class="px-4 py-3">Reason</th>
                                    <th class="px-4 py-3">Date Applied</th>
                                    <th class="px-4 py-3">Due Date</th>
                                    <th class="px-4 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($userPenalties as $penalty)
                                    <tr class="{{ $penalty->paid ? '' : 'table-danger' }}">
                                        <td class="fw-bold">₱{{ number_format($penalty->amount, 2) }}</td>
                                        <td>{{ $penalty->reason }}</td>
                                        <td>{{ \Carbon\Carbon::parse($penalty->applied_at)->format('M d, Y') }}</td>
                                        <td>
                                            @if($penalty->due_date)
                                                {{ \Carbon\Carbon::parse($penalty->due_date)->format('M d, Y') }}
                                            @else
                                                <span class="text-muted">No due date</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($penalty->paid)
                                                <span class="badge bg-success px-3 py-2">Paid</span>
                                            @else
                                                <span class="badge bg-danger px-3 py-2">Unpaid</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
                        <h5 class="mt-3 text-muted">You have no penalties 🎉</h5>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

                    {{-- Total Donations (All Members) --}}
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('donations.index') }}" class="text-decoration-none">
                            <div class="card p-4 bg-dark text-light shadow rounded-4 hover-card">
                                <h5 class="text-info">Total Donations (All Members)</h5>
                                <p class="fs-5 fw-bold">₱ {{ number_format($totalDonations, 2) }}</p>
                            </div>
                        </a>
                    </div>

                    {{-- Monthly Funds --}}
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('monthlyfunds.index') }}" class="text-decoration-none">
                            <div class="card p-4 bg-dark text-light shadow rounded-4 hover-card position-relative">
                                <h5 class="text-info">Monthly Funds</h5>
                                <p class="fs-5 fw-bold">₱ 50 / month</p>

                                @php
                                    $hasPaidThisMonth = auth()->user()
                                        ->monthlyFunds()
                                        ->where('month_year', now()->startOfMonth())
                                        ->exists();
                                @endphp

                                @if($hasPaidThisMonth)
                                    <span class="badge bg-success position-absolute top-0 end-0 m-3 px-3 py-2">Paid</span>
                                @else
                                    <span class="badge bg-danger position-absolute top-0 end-0 m-3 px-3 py-2">Unpaid</span>
                                @endif
                            </div>
                        </a>
                    </div>
                </div>

                {{-- Recent Notifications --}}
                <h4 class="text-white mt-4">Recent Notifications</h4>

                {{-- Mark all as read --}}
                @if($notifications->where('read_at', null)->count() > 0)
                    <form method="POST" action="{{ route('notifications.markAllRead') }}" class="mb-3">
                        @csrf
                        <button class="btn btn-sm btn-secondary rounded-pill px-3">Mark All as Read</button>
                    </form>
                @endif

                <ul class="list-group mb-3 shadow-sm rounded-4">
                    @forelse($notifications as $notification)
                        @php
                            $isUnread = is_null($notification->read_at);
                            $bgClass = $isUnread ? 'bg-info text-dark fw-bold' : 'bg-dark text-light';

                            // Determine the case link for staff
                            if(isset($notification->data['job_type']) && isset($notification->data['case_id'])) {
                                $caseLink = route('bereavement-cases.show', $notification->data['case_id']);
                            } else {
                                $caseLink = $notification->data['link'] ?? '#';
                            }
                        @endphp

                        <li class="list-group-item d-flex justify-content-between align-items-start {{ $bgClass }} hover-notification">
                            <div>
                                {{-- STAFF notification --}}
                                @if(isset($notification->data['job_type']))
                                    <span class="badge bg-warning text-dark me-2">
                                        {{ ucfirst($notification->data['job_type']) }} Task
                                    </span>
                                    You have a new task in bereavement case: 
                                    <strong>{{ $notification->data['case_title'] ?? 'N/A' }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>

                                {{-- MEMBER notification --}}
                                @elseif(isset($notification->data['user_name']))
                                    <strong>{{ $notification->data['user_name'] }}</strong> - 
                                    {{ $notification->data['title'] ?? 'No title' }} <br>
                                    Date of Death: {{ $notification->data['date_of_death'] ?? 'N/A' }} <br>
                                    Description: {{ $notification->data['description'] ?? 'N/A' }}
                                    <br><small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>

                                {{-- Fallback --}}
                                @else
                                    {{ $notification->data['message'] ?? 'No message' }}
                                    <br><small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                @endif
                            </div>

                            {{-- Link to case --}}
                            <a href="{{ $caseLink }}" class="btn btn-sm btn-primary align-self-center ms-3">
                                View Case
                            </a>
                        </li>
                    @empty
                        <li class="list-group-item bg-dark text-light text-center">No notifications yet.</li>
                    @endforelse
                </ul>
            @endif

            {{-- Admin Dashboard --}}
            @if(auth()->user()->role === 'admin')
                <div class="row mt-4">
                    {{-- Total Donations --}}
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('donations.index') }}" class="text-decoration-none">
                            <div class="card p-4 bg-dark text-light shadow rounded-4 hover-card">
                                <h5 class="text-info">Total Donations(All)</h5>
                                <p class="fs-5 fw-bold">₱ {{ number_format($totalDonations, 2) }}</p>
                            </div>
                        </a>
                    </div>

                    {{-- Number of Users --}}
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('members.index') }}" class="text-decoration-none">
                            <div class="card p-4 bg-dark text-light shadow rounded-4 hover-card">
                                <h5 class="text-info">Number of Users</h5>
                                <p class="fs-5 fw-bold">{{ $totalUsersCount ?? \App\Models\User::count() }}</p>
                            </div>
                        </a>
                    </div>
                    

                    {{-- Total Bereavement Cases --}}
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('bereavement-cases.index') }}" class="text-decoration-none">
                            <div class="card p-4 bg-dark text-light shadow rounded-4 hover-card">
                                <h5 class="text-info">Bereavement Cases</h5>
                                <p class="fs-5 fw-bold">{{ $totalCases }}</p>
                            </div>
                        </a>
                    </div>

                    {{-- Monthly Funds --}}
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('monthlyfunds.index') }}" class="text-decoration-none">
                            <div class="card p-4 bg-dark text-light shadow rounded-4 hover-card">
                                <h5 class="text-info">Monthly Fund (All Members)</h5>
                                <p class="fs-5 fw-bold">
                                    ₱ {{ number_format(\App\Models\MonthlyFund::where('month_year', now()->startOfMonth())->sum('amount'), 2) }}
                                </p>
                            </div>
                        </a>
                    </div>
                </div>

               {{-- Recent Bereavement Cases --}}
<div class="mt-4">
    <h4 class="text-white">Recent Bereavement Cases</h4>
    @if(isset($recentCases) && $recentCases->count() > 0)
        <ul class="list-group shadow-sm rounded-4">
            @foreach($recentCases as $case)
                <li class="list-group-item d-flex justify-content-between align-items-start
                           bg-dark text-light mb-2 rounded-3 hover-notification">
                    <div class="w-100">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <strong class="fs-5 text-info">{{ $case->title ?? 'No title' }}</strong>
                            <span class="badge bg-secondary">Case #{{ $case->id }}</span>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Member:</strong> {{ $case->user->name ?? 'N/A' }} <br>
                                <strong>Date of Death:</strong> {{ $case->date_of_death?->format('F j, Y') ?? 'N/A' }} <br>
                                <strong>Deceased Name:</strong> {{ $case->description_name ?? 'N/A' }}
                            </div>
                            <div class="col-md-6">
                                <strong>Service Type:</strong> {{ $case->description_what ?? 'N/A' }} <br>
                                <strong>Service Date & Time:</strong> 
                                    @if($case->description_when)
                                        {{ \Carbon\Carbon::parse($case->description_when)->format('M j, Y g:i A') }}
                                    @else
                                        N/A
                                    @endif
                                <br>
                                <strong>Location:</strong> {{ $case->description_where ?? 'N/A' }}
                            </div>
                        </div>
                        
                        @if($case->description_notes)
                            <div class="mt-2">
                                <strong>Additional Notes:</strong> 
                                <span class="text-muted">{{ Str::limit($case->description_notes, 150) }}</span>
                            </div>
                        @endif
                        
                        <div class="mt-2 text-muted small">
                            Created: {{ $case->created_at->diffForHumans() }}
                        </div>
                    </div>
                    <a href="{{ route('bereavement-cases.edit', $case->id) }}" 
                       class="btn btn-sm btn-outline-primary align-self-center ms-3">
                       View / Edit
                    </a>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-muted">No recent bereavement cases.</p>
    @endif
</div>
            @endif

        </div> {{-- End Main Content --}}
    </div> {{-- End Row --}}
</div> {{-- End Container --}}

{{-- Hover effects --}}
<style>
.hover-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0 20px rgba(0, 255, 255, 0.3);
}
.hover-notification {
    transition: background-color 0.2s ease, box-shadow 0.2s ease;
    cursor: pointer;
}
.hover-notification:hover {
    background-color: rgba(0, 255, 255, 0.1);
    box-shadow: 0 0 10px rgba(0, 255, 255, 0.2);
}
 /* Custom extra-wide modal */
.custom-wide-modal {
    max-width: 95vw !important; /* almost full width */
    width: 95vw !important;
}

.modal-content {
    background: rgba(20, 20, 20, 0.95);
    backdrop-filter: blur(12px);
}

table.table th, table.table td {
    padding: 1rem !important;
}
</style>
@endsection