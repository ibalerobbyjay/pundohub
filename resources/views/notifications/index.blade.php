@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-bg: #f8f9fa;
            --card-bg: #ffffff;
            --unread-bg: #e8f4fd;
            --read-bg: #f8f9fa;
            --border-color: #e0e0e0;
            --hover-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        body {
            background-color: var(--primary-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .notification-container {
            max-width: 900px;
            margin: 0 auto;
        }

        .notification-header {
           
            color: white;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
           
        }

        .notification-item {
            transition: all 0.3s ease;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            margin-bottom: 1rem;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
             color: #212529 !important;
        }

        .notification-item.unread {
            background-color: var(--unread-bg);
            border-left: 4px solid #2575fc;
            color: #212529 !important;
        }

        .notification-item.read {
            background-color: var(--card-bg);
            color: #212529 !important;
        }

        .notification-item:hover {
            transform: translateY(-3px);
            box-shadow: var(--hover-shadow);
            color: #212529 !important;
        }

        .notification-item.unread:hover {
            background-color: #d9edf7;
            color: #212529 !important;
        }

        .notification-item.read:hover {
            background-color: #f0f0f0;
            color: #212529 !important;
        }

        .profile-picture {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border: 2px solid #e0e0e0;
            transition: transform 0.2s ease;
        }

        .profile-picture:hover {
            transform: scale(1.05);
        }

        .badge {
            font-size: 0.7rem;
            padding: 0.35em 0.65em;
        }

        .btn-mark-all {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }

        .btn-mark-all:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        .empty-state {
            background-color: var(--card-bg);
            border-radius: 10px;
            padding: 3rem;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
        }

        .alert-success {
            border-radius: 8px;
            border-left: 4px solid #28a745;
        }

        .timestamp {
            font-size: 0.85rem;
        }
    </style>
</head>
<body>
    <div class="container mt-4 notification-container">
        <div class="notification-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-1"><i class="bi bi-bell-fill me-2"></i>Notifications</h3>
                    <p class="mb-0 opacity-75">{{ $unread->count() }} unread notifications</p>
                </div>
                
                @if($unread->count() > 0)
                <form action="{{ route('notifications.markAllRead') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-mark-all text-white rounded-pill">
                        <i class="bi bi-check-all me-1"></i> Mark All as Read
                    </button>
                </form>
                @endif
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <div>{{ session('success') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($notifications->isEmpty())
            <div class="empty-state">
                <i class="bi bi-bell-slash text-muted" style="font-size: 3rem;"></i>
                <h4 class="text-muted mt-3">No notifications</h4>
                <p class="text-muted">You're all caught up! New notifications will appear here.</p>
            </div>
        @else
            <div class="notification-list">
                @foreach($notifications as $notification)
                    @php
                        $data = $notification->data;
                        $isUnread = is_null($notification->read_at);
                        
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

                        // Determine the appropriate link for each notification type
                        $notificationLink = '#';
                        if (isset($data['case_id'])) {
                            $notificationLink = route('bereavement-cases.show', $data['case_id']) . '?notification_id=' . $notification->id;
                        } elseif (isset($data['report_id'])) {
                            $notificationLink = route('admin.death-reports.index') . '?notification_id=' . $notification->id;
                        } elseif (isset($data['donation_id'])) {
                            $notificationLink = route('donations.index') . '?notification_id=' . $notification->id;
                        } elseif (isset($data['payment_id'])) {
                            $notificationLink = route('payments.show', $data['payment_id']) . '?notification_id=' . $notification->id;
                        }
                    @endphp

                    <div class="notification-item {{ $isUnread ? 'unread' : 'read' }}"
                         data-notification-id="{{ $notification->id }}"
                         data-is-unread="{{ $isUnread ? 'true' : 'false' }}"
                         data-link="{{ $notificationLink }}">
                        
                        <div class="p-3">
                            <div class="d-flex align-items-start">
                                <!-- Profile Picture -->
                                <div class="me-3 flex-shrink-0">
                                    @if($user && $user->profile_picture)
                                        <img src="{{ asset('storage/' . $user->profile_picture) }}" 
                                             alt="{{ $user->name }}" 
                                             class="profile-picture rounded-circle">
                                    @else
                                        <div class="profile-picture rounded-circle bg-secondary d-flex align-items-center justify-content-center">
                                            <i class="bi bi-person-fill text-light"></i>
                                        </div>
                                    @endif
                                </div>

                                <!-- Notification Content -->
                                <div class="flex-grow-1 me-3">
                                    {{-- Death Report Notification --}}
                                    @if(isset($data['reporter_name']) && isset($data['deceased_name']))
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="badge bg-warning text-dark me-2">Death Report</span>
                                            @if($isUnread)
                                                <span class="badge bg-primary">New</span>
                                            @endif
                                        </div>
                                        <div class="mb-2">
                                            <strong>{{ $data['reporter_name'] }}</strong> reported death of <strong>{{ $data['deceased_name'] }}</strong>
                                            @if(isset($data['cause_of_death']))
                                                <div class="mt-1"><small>Cause: {{ $data['cause_of_death'] }}</small></div>
                                            @endif
                                            @if(isset($data['location_of_death']))
                                                <div class="mt-1"><small>Location: {{ $data['location_of_death'] }}</small></div>
                                            @endif
                                        </div>

                                        {{-- Warning if the death is reported more than once --}}
                                        @if(isset($data['message']) && Str::contains($data['message'], 'reported more than once'))
                                            <div class="alert alert-warning mt-2 mb-0 p-2">
                                                <small><i class="bi bi-exclamation-triangle-fill me-1"></i> {{ $data['message'] }}</small>
                                            </div>
                                        @endif

                                    {{-- Donation Notification --}}
                                    @elseif(isset($data['type']) && $data['type'] === 'donation')
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="badge bg-success me-2">Donation</span>
                                            @if($isUnread)
                                                <span class="badge bg-primary">New</span>
                                            @endif
                                        </div>
                                        <div class="mb-2">
                                            <strong>{{ $data['donor_name'] }}</strong> donated 
                                            <strong>{{ $data['amount_display'] ?? ($data['currency'] ?? '₱') . number_format($data['amount'], 2) }}</strong>
                                            @if(isset($data['message']) && $data['message'])
                                                <div class="mt-1"><small>"{{ $data['message'] }}"</small></div>
                                            @endif
                                        </div>

                                    {{-- Payment Notification --}}
                                    @elseif(isset($data['type']) && $data['type'] === 'payment')
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="badge bg-info me-2">Payment</span>
                                            @if($isUnread)
                                                <span class="badge bg-primary">New</span>
                                            @endif
                                        </div>
                                        <div class="mb-2">
                                            <strong>{{ $data['payer_name'] }}</strong> paid monthly funds of 
                                            <strong>{{ $data['currency'] ?? '₱' }}{{ number_format($data['amount'], 2) }}</strong>
                                            @if(isset($data['month']))
                                                <div class="mt-1"><small>For: {{ $data['month'] }}</small></div>
                                            @endif
                                        </div>

                                    {{-- Profile Update Notification --}}
                                    @elseif(isset($data['user_name']) && isset($data['title']) && $data['title'] === 'Profile Updated')
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="badge bg-primary me-2">Profile Update</span>
                                            @if($isUnread)
                                                <span class="badge bg-primary">New</span>
                                            @endif
                                        </div>
                                        <div class="mb-2">
                                            <strong>{{ $data['user_name'] }}</strong> updated their profile
                                        </div>

                                    {{-- Job Assignment Notification --}}
                                    @elseif(isset($data['case_title']) && isset($data['job_type']))
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="badge bg-info me-2">{{ ucfirst($data['job_type']) }} Assignment</span>
                                            @if($isUnread)
                                                <span class="badge bg-primary">New</span>
                                            @endif
                                        </div>
                                        <div class="mb-2">
                                            You have a new <strong>{{ $data['job_type'] }}</strong> assignment
                                            <div class="mt-1"><small>Case: {{ $data['case_title'] }}</small></div>
                                        </div>

                                    {{-- Bereavement Case Notification --}}
                                    @elseif(isset($data['case_title']) && isset($data['type']) && $data['type'] === 'bereavement')
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="badge bg-danger me-2">Bereavement Case</span>
                                            @if($isUnread)
                                                <span class="badge bg-primary">New</span>
                                            @endif
                                        </div>
                                        <div class="mb-2">
                                            New bereavement case: <strong>{{ $data['case_title'] }}</strong>
                                            @if(isset($data['case_creator_name']))
                                                <div class="mt-1"><small>Created by: {{ $data['case_creator_name'] }}</small></div>
                                            @endif
                                        </div>

                                    {{-- General Message --}}
                                    @elseif(isset($data['message']))
                                        <div class="mb-2">
                                            {{ $data['message'] }}
                                        </div>

                                    {{-- Fallback --}}
                                    @else
                                        <div class="mb-2">No message content</div>
                                    @endif

                                    <!-- Timestamp -->
                                    <div class="timestamp {{ $isUnread ? 'text-primary' : 'text-muted' }}">
                                        <i class="bi bi-clock me-1"></i>{{ $notification->created_at->diffForHumans() }}
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="ms-3 text-nowrap flex-shrink-0">
                                    {{-- View Button for Relevant Notifications --}}
                                    @if(isset($data['case_id']))
                                        <a href="{{ route('bereavement-cases.show', $data['case_id']) }}?notification_id={{ $notification->id }}" 
                                           class="btn btn-sm btn-outline-primary rounded-pill">
                                            View Case
                                        </a>
                                    @elseif(isset($data['report_id']))
                                        <a href="{{ route('admin.death-reports.index') }}?notification_id={{ $notification->id }}" 
                                           class="btn btn-sm btn-outline-primary rounded-pill">
                                            View Reports
                                        </a>
                                    @elseif(isset($data['donation_id']))
                                        <a href="{{ route('donations.index') }}?notification_id={{ $notification->id }}" 
                                           class="btn btn-sm btn-outline-primary rounded-pill">
                                            View Donation
                                        </a>
                                    @elseif(isset($data['payment_id']))
                                        <a href="{{ route('payments.show', $data['payment_id']) }}?notification_id={{ $notification->id }}" 
                                           class="btn btn-sm btn-outline-primary rounded-pill">
                                            View Payment
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle notification clicks
            document.querySelectorAll('.notification-item').forEach(item => {
                item.addEventListener('click', function(e) {
                    // Don't trigger if user clicked on a button or link inside the notification
                    if (e.target.tagName === 'BUTTON' || e.target.tagName === 'A' || e.target.closest('button') || e.target.closest('a')) {
                        return;
                    }

                    const notificationId = this.getAttribute('data-notification-id');
                    const isUnread = this.getAttribute('data-is-unread') === 'true';
                    const link = this.getAttribute('data-link');

                    if (isUnread) {
                        // Create a hidden form to submit via POST
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `/notifications/${notificationId}/read`;
                        
                        const csrfToken = document.createElement('input');
                        csrfToken.type = 'hidden';
                        csrfToken.name = '_token';
                        csrfToken.value = '{{ csrf_token() }}';
                        
                        const methodField = document.createElement('input');
                        methodField.type = 'hidden';
                        methodField.name = '_method';
                        methodField.value = 'POST';
                        
                        form.appendChild(csrfToken);
                        form.appendChild(methodField);
                        document.body.appendChild(form);
                        
                        // Submit the form
                        form.submit();
                    } else if (link && link !== '#') {
                        // If already read, just navigate to the link
                        window.location.href = link;
                    }
                });
            });

            // Add loading state for "Mark All as Read" button
            const markAllForm = document.querySelector('form[action*="markAllRead"]');
            if (markAllForm) {
                markAllForm.addEventListener('submit', function(e) {
                    const button = this.querySelector('button[type="submit"]');
                    button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Marking...';
                    button.disabled = true;
                });
            }
        });
    </script>
</body>
</html>
@endsection