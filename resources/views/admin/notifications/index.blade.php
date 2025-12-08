@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Notifications</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Notifications</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <form action="{{ route('admin.notifications.clear-all') }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger" 
                        onclick="return confirm('Clear all notifications?')">
                    <i class="bi bi-trash"></i> Clear All
                </button>
            </form>
            <form action="{{ route('admin.notifications.mark-all-read') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-primary">
                    <i class="bi bi-check-all"></i> Mark All as Read
                </button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            @if($notifications->count() > 0)
                <div class="list-group list-group-flush">
                    @foreach($notifications as $notification)
                    <div class="list-group-item notification-item {{ $notification->read_at ? 'read' : 'unread' }}" 
                         data-id="{{ $notification->id }}">
                        <div class="d-flex align-items-start">
                            <div class="notification-icon {{ $notification->icon_class }}">
                                <i class="bi {{ $notification->icon }}"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <h6 class="mb-1">{{ $notification->notification_title }}</h6>
                                    <small class="text-muted">{{ $notification->time_ago }}</small>
                                </div>
                                <p class="mb-1">{{ $notification->notification_message }}</p>
                                @php
                                    $payload = data_get($notification->data, 'data');
                                @endphp
                                @if($payload)
                                    <small class="text-muted">
                                        @if($notification->notification_type == 'order')
                                            Order #{{ data_get($payload, 'order_id', '') }}
                                        @elseif($notification->notification_type == 'booking')
                                            Booking #{{ data_get($payload, 'booking_id', '') }}
                                        @endif
                                    </small>
                                @endif
                                <div class="mt-2">
                                    @if(!$notification->read_at)
                                    <form action="{{ route('admin.notifications.mark-as-read', $notification->id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-success">
                                            <i class="bi bi-check"></i> Mark as Read
                                        </button>
                                    </form>
                                    @endif
                                    <form action="{{ route('admin.notifications.destroy', $notification->id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Delete this notification?')">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="card-footer bg-white border-top">
                    {{ $notifications->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-bell-slash text-muted fs-1"></i>
                    <h4 class="mt-3">No notifications</h4>
                    <p class="text-muted">You don't have any notifications yet.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.notification-item {
    padding: 1rem;
    border-bottom: 1px solid #f0f0f0;
    transition: background-color 0.2s;
}

.notification-item:hover {
    background-color: #f8f9fa;
}

.notification-item.unread {
    background-color: #f0f7ff;
    border-left: 3px solid #007bff;
}

.notification-item.read {
    opacity: 0.7;
}

.notification-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.notification-icon.order { background-color: #e3f2fd; color: #1976d2; }
.notification-icon.booking { background-color: #e8f5e9; color: #388e3c; }
.notification-icon.system { background-color: #fff3e0; color: #f57c00; }
.notification-icon.user { background-color: #f3e5f5; color: #7b1fa2; }
.notification-icon.contact { background-color: #e0f2f1; color: #00796b; }
.notification-icon.delivery { background-color: #e3f2fd; color: #1976d2; }
</style>
@endsection