@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-info">Notifications ({{ $unread->count() }} unread)</h3>

        @if($unread->count() > 0)
        <form action="{{ route('notifications.markAllRead') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-sm btn-primary rounded-pill">
                Mark All as Read
            </button>
        </form>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($notifications->isEmpty())
        <div class="text-center text-muted py-5">
            No notifications found.
        </div>
    @else
        <ul class="list-group">
            @foreach($notifications as $notification)
                @php
                    $data = $notification->data;
                    $isUnread = is_null($notification->read_at);
                    $bgClass = $isUnread ? 'bg-primary text-white fw-bold' : 'bg-dark text-light';
                    
                    // Get user for profile picture - IMPROVED LOGIC
                    $user = null;
                    
                    // For donation notifications - find donor
                    if (isset($data['type']) && $data['type'] === 'donation' && isset($data['donor_name'])) {
                        $user = \App\Models\User::where('name', $data['donor_name'])->first();
                    }
                    // For death reports - find reporter
                    elseif (isset($data['reporter_name'])) {
                        $user = \App\Models\User::where('name', $data['reporter_name'])->first();
                    }
                    // For profile updates - find the user who updated profile
                    elseif (isset($data['user_name'])) {
                        $user = \App\Models\User::where('name', $data['user_name'])->first();
                    }
                    // For payment notifications - find payer
                    elseif (isset($data['payer_name'])) {
                        $user = \App\Models\User::where('name', $data['payer_name'])->first();
                    }
                    // For bereavement cases - find case creator
                    elseif (isset($data['case_creator_name'])) {
                        $user = \App\Models\User::where('name', $data['case_creator_name'])->first();
                    }
                @endphp

                <li class="list-group-item d-flex justify-content-between align-items-start {{ $bgClass }} border-secondary rounded-3 mb-2 shadow-sm notification-item">
                    <div class="d-flex align-items-start w-100">
                        <!-- Profile Picture -->
                        <div class="me-3 flex-shrink-0">
                            @if($user && $user->profile_picture)
                                <img src="{{ asset('storage/' . $user->profile_picture) }}" 
                                     alt="{{ $user->name }}" 
                                     class="rounded-circle"
                                     style="width: 45px; height: 45px; object-fit: cover; border: 2px solid #0dcaf0;">
                            @else
                                <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center"
                                     style="width: 45px; height: 45px;">
                                    <i class="bi bi-person-fill text-light"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Notification Content -->
                        <div class="flex-grow-1">
                            {{-- Death Report Notification --}}
                            @if(isset($data['reporter_name']) && isset($data['deceased_name']))
                                <div class="d-flex align-items-center mb-1">
                                    <span class="badge bg-warning text-dark">Death Report</span>
                                </div>
                                <div>
                                    <strong>{{ $data['reporter_name'] }}</strong> reported death of <strong>{{ $data['deceased_name'] }}</strong>
                                    @if(isset($data['cause_of_death']))
                                        <br><small>Cause: {{ $data['cause_of_death'] }}</small>
                                    @endif
                                    @if(isset($data['location_of_death']))
                                        <br><small>Location: {{ $data['location_of_death'] }}</small>
                                    @endif
                                </div>

                            {{-- Donation Notification --}}
                            @elseif(isset($data['type']) && $data['type'] === 'donation')
                                <div class="d-flex align-items-center mb-1">
                                    <span class="badge bg-success">Donation</span>
                                </div>
                                <div>
                                    <strong>{{ $data['donor_name'] }}</strong> donated 
                                    <strong>{{ $data['amount_display'] ?? ($data['currency'] ?? '₱') . number_format($data['amount'], 2) }}</strong>
                                    @if(isset($data['message']) && $data['message'])
                                        <br><small>"{{ $data['message'] }}"</small>
                                    @endif
                                </div>

                            {{-- Payment Notification --}}
                            @elseif(isset($data['type']) && $data['type'] === 'payment')
                                <div class="d-flex align-items-center mb-1">
                                    <span class="badge bg-info">Payment</span>
                                </div>
                                <div>
                                    <strong>{{ $data['payer_name'] }}</strong> paid monthly funds of 
                                    <strong>{{ $data['currency'] ?? '₱' }}{{ number_format($data['amount'], 2) }}</strong>
                                    @if(isset($data['month']))
                                        <br><small>For: {{ $data['month'] }}</small>
                                    @endif
                                </div>

                            {{-- Profile Update Notification --}}
                            @elseif(isset($data['user_name']) && isset($data['title']) && $data['title'] === 'Profile Updated')
                                <div class="d-flex align-items-center mb-1">
                                    <span class="badge bg-primary">Profile Update</span>
                                </div>
                                <div>
                                    <strong>{{ $data['user_name'] }}</strong> updated their profile
                                </div>

                            {{-- Job Assignment Notification --}}
                            @elseif(isset($data['case_title']) && isset($data['job_type']))
                                <div class="d-flex align-items-center mb-1">
                                    <span class="badge bg-info">{{ ucfirst($data['job_type']) }} Assignment</span>
                                </div>
                                <div>
                                    You have a new <strong>{{ $data['job_type'] }}</strong> assignment
                                    <br>
                                    <small>Case: {{ $data['case_title'] }}</small>
                                </div>

                            {{-- Bereavement Case Notification --}}
                            @elseif(isset($data['case_title']) && isset($data['type']) && $data['type'] === 'bereavement')
                                <div class="d-flex align-items-center mb-1">
                                    <span class="badge bg-danger">Bereavement Case</span>
                                </div>
                                <div>
                                    New bereavement case: <strong>{{ $data['case_title'] }}</strong>
                                    @if(isset($data['case_creator_name']))
                                        <br><small>Created by: {{ $data['case_creator_name'] }}</small>
                                    @endif
                                </div>

                            {{-- General Message --}}
                            @elseif(isset($data['message']))
                                <div>
                                    {{ $data['message'] }}
                                </div>

                            {{-- Fallback --}}
                            @else
                                <div>No message content</div>
                            @endif

                            <!-- Timestamp -->
                            <small class="{{ $isUnread ? 'text-light-50' : 'text-muted' }}">
                                {{ $notification->created_at->diffForHumans() }}
                            </small>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="ms-3 text-nowrap flex-shrink-0">
                        {{-- Mark as Read --}}
                        @if($isUnread)
                        <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success mb-1 rounded-pill">Mark as read</button>
                        </form>
                        @endif

                        {{-- View Button for Relevant Notifications --}}
                        @if(isset($data['case_id']))
                            <a href="{{ route('bereavement-cases.show', $data['case_id']) }}" 
                               class="btn btn-sm btn-outline-info rounded-pill">
                                View Case
                            </a>
                        @elseif(isset($data['report_id']))
                            <a href="{{ route('admin.death-reports.index') }}" 
                               class="btn btn-sm btn-outline-info rounded-pill">
                                View Reports
                            </a>
                        @elseif(isset($data['donation_id']))
                            <a href="{{ route('donations.show', $data['donation_id']) }}" 
                               class="btn btn-sm btn-outline-info rounded-pill">
                                View Donation
                            </a>
                        @elseif(isset($data['payment_id']))
                            <a href="{{ route('payments.show', $data['payment_id']) }}" 
                               class="btn btn-sm btn-outline-info rounded-pill">
                                View Payment
                            </a>
                        @endif
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>

<style>
.notification-item {
    transition: all 0.2s ease-in-out;
    cursor: pointer;
}

.notification-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.3);
}

.notification-item.bg-dark:hover {
    background-color: #c5c7ca !important;
    color: #000 !important;
}

.notification-item.bg-primary:hover {
    background-color: #0d6efd !important;
}

/* Profile picture hover effect */
.rounded-circle {
    transition: transform 0.2s ease;
}

.rounded-circle:hover {
    transform: scale(1.1);
}
</style>
@endsection