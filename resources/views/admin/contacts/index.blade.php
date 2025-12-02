@extends('admin.layouts.app')

@section('title', 'Contact Messages')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">📧 Contact Messages</h1>
                <div class="btn-group">
                    <a href="{{ route('admin.contacts.index', ['status' => 'unread']) }}" 
                       class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-envelope"></i> Unread
                    </a>
                    <a href="{{ route('admin.contacts.index', ['status' => 'read']) }}" 
                       class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-envelope-open"></i> Read
                    </a>
                    <a href="{{ route('admin.contacts.index', ['status' => 'replied']) }}" 
                       class="btn btn-outline-success btn-sm">
                        <i class="bi bi-reply"></i> Replied
                    </a>
                    <a href="{{ route('admin.contacts.index') }}" 
                       class="btn btn-outline-dark btn-sm">
                        <i class="bi bi-list"></i> All
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="mb-1">Total</h6>
                            <h4 class="mb-0">{{ $totalCount }}</h4>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-envelope fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-white">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="mb-1">Unread</h6>
                            <h4 class="mb-0">{{ $unreadCount }}</h4>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-envelope-exclamation fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="mb-1">Read</h6>
                            <h4 class="mb-0">{{ $readCount }}</h4>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-envelope-open fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="mb-1">Replied</h6>
                            <h4 class="mb-0">{{ $repliedCount }}</h4>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-reply-all fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search -->
    <div class="card shadow mb-4">
        <div class="card-body py-3">
            <form action="{{ route('admin.contacts.index') }}" method="GET" class="row g-2">
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="text" 
                               class="form-control form-control-sm" 
                               name="search" 
                               placeholder="Search messages..."
                               value="{{ request('search') }}">
                        <button class="btn btn-primary btn-sm" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-4">
                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>Unread</option>
                        <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Read</option>
                        <option value="replied" {{ request('status') == 'replied' ? 'selected' : '' }}>Replied</option>
                    </select>
                </div>
            </form>
        </div>
    </div>

    <!-- Messages Table -->
    <div class="card shadow">
        <div class="card-body p-0">
            @if($contacts->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">From</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contacts as $contact)
                        <tr class="{{ $contact->status == 'unread' ? 'table-warning' : '' }}">
                            <td class="ps-3">
                                <div class="fw-semibold">{{ $contact->name }}</div>
                                <small class="text-muted">{{ $contact->email }}</small>
                            </td>
                            <td>
                                <div class="text-truncate" style="max-width: 150px;">
                                    {{ $contact->subject }}
                                </div>
                            </td>
                            <td>
                                <div class="text-truncate" style="max-width: 200px;">
                                    {{ Str::limit($contact->message, 80) }}
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-{{ 
                                    $contact->status == 'unread' ? 'warning' : 
                                    ($contact->status == 'read' ? 'info' : 'success') 
                                }}">
                                    {{ ucfirst($contact->status) }}
                                </span>
                            </td>
                            <td>
                                <small>{{ $contact->created_at->format('M d') }}</small><br>
                                <small class="text-muted">{{ $contact->created_at->format('h:i A') }}</small>
                            </td>
                            <td class="text-end pe-3">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.contacts.show', $contact) }}" 
                                       class="btn btn-outline-primary" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if($contact->status == 'unread')
                                    <form action="{{ route('admin.contacts.mark-as-read', $contact) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-info" title="Mark as Read">
                                            <i class="bi bi-envelope-open"></i>
                                        </button>
                                    </form>
                                    @endif
                                    <form action="{{ route('admin.contacts.destroy', $contact) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Delete this message?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="p-3 border-top">
                {{ $contacts->links() }}
            </div>
            @else
            <div class="text-center py-5">
                <i class="bi bi-envelope-slash fs-1 text-muted"></i>
                <h5 class="mt-3">No Messages Found</h5>
                <p class="text-muted">
                    @if(request('search') || request('status'))
                    Try changing your search criteria
                    @else
                    No contact messages yet
                    @endif
                </p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection