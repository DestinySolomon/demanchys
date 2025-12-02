@extends('admin.layouts.app')

@section('title', 'Message: ' . Str::limit($contact->subject, 30))

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">📧 Message Details</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.contacts.index') }}">Messages</a>
                            </li>
                            <li class="breadcrumb-item active">View</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Message Card -->
            <div class="card shadow mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0">Message</h5>
                    <span class="badge bg-{{ 
                        $contact->status == 'unread' ? 'warning' : 
                        ($contact->status == 'read' ? 'info' : 'success') 
                    }}">
                        {{ ucfirst($contact->status) }}
                    </span>
                </div>
                <div class="card-body">
                    <!-- Sender Info -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted small mb-1">FROM</h6>
                            <h5 class="mb-1">{{ $contact->name }}</h5>
                            <p class="mb-0">
                                <i class="bi bi-envelope me-1"></i>
                                <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted small mb-1">RECEIVED</h6>
                            <p class="mb-1">
                                <i class="bi bi-calendar me-1"></i>
                                {{ $contact->created_at->format('F d, Y') }}
                            </p>
                            <p class="mb-0">
                                <i class="bi bi-clock me-1"></i>
                                {{ $contact->created_at->format('h:i A') }}
                                <span class="text-muted ms-2">({{ $contact->created_at->diffForHumans() }})</span>
                            </p>
                        </div>
                    </div>

                    <!-- Subject -->
                    <div class="mb-4">
                        <h6 class="text-muted small mb-2">SUBJECT</h6>
                        <h4 class="mb-0">{{ $contact->subject }}</h4>
                    </div>

                    <!-- Message -->
                    <div class="mb-4">
                        <h6 class="text-muted small mb-2">MESSAGE</h6>
                        <div class="bg-light p-4 rounded">
                            {!! nl2br(e($contact->message)) !!}
                        </div>
                    </div>

                    <!-- Admin Notes -->
                    @if($contact->admin_notes)
                    <div class="mb-4">
                        <h6 class="text-muted small mb-2">ADMIN NOTES</h6>
                        <div class="bg-info bg-opacity-10 p-3 rounded border-start border-info border-3">
                            {{ $contact->admin_notes }}
                            @if($contact->replied_at)
                            <div class="mt-2 small text-muted">
                                <i class="bi bi-clock-history me-1"></i>
                                Replied: {{ $contact->replied_at->format('M d, Y h:i A') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between">
                        <div class="btn-group">
                            @if($contact->status != 'replied')
                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#markRepliedModal">
                                <i class="bi bi-reply"></i> Mark as Replied
                            </button>
                            @endif
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#sendReplyModal">
                                <i class="bi bi-send"></i> Send Reply
                            </button>
                            <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}" 
                               class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-envelope-plus"></i> Email Client
                            </a>
                        </div>
                        <form action="{{ route('admin.contacts.destroy', $contact) }}" 
                              method="POST" 
                              onsubmit="return confirm('Delete this message?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card shadow mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($contact->status == 'unread')
                        <form action="{{ route('admin.contacts.mark-as-read', $contact) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-info w-100 mb-2">
                                <i class="bi bi-envelope-open me-2"></i> Mark as Read
                            </button>
                        </form>
                        @endif

                        <button type="button" class="btn btn-primary w-100 mb-2" data-bs-toggle="modal" data-bs-target="#sendReplyModal">
                            <i class="bi bi-send me-2"></i> Send System Reply
                        </button>

                        <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}" 
                           class="btn btn-outline-primary w-100 mb-2">
                            <i class="bi bi-envelope-plus me-2"></i> Reply via Email Client
                        </a>

                        <a href="{{ route('admin.contacts.index', ['status' => 'unread']) }}" 
                           class="btn btn-warning w-100 mb-2">
                            <i class="bi bi-envelope-exclamation me-2"></i> View Unread
                        </a>

                        <a href="{{ route('admin.contacts.index') }}" 
                           class="btn btn-secondary w-100">
                            <i class="bi bi-list me-2"></i> All Messages
                        </a>
                    </div>
                </div>
            </div>

            <!-- Message Info -->
            <div class="card shadow">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0">Message Info</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled small mb-0">
                        <li class="mb-2">
                            <i class="bi bi-person-circle text-primary me-2"></i>
                            <strong>Name:</strong> {{ $contact->name }}
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-envelope text-primary me-2"></i>
                            <strong>Email:</strong> {{ $contact->email }}
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-calendar text-primary me-2"></i>
                            <strong>Received:</strong> {{ $contact->created_at->diffForHumans() }}
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-info-circle text-primary me-2"></i>
                            <strong>Status:</strong> 
                            <span class="badge bg-{{ 
                                $contact->status == 'unread' ? 'warning' : 
                                ($contact->status == 'read' ? 'info' : 'success') 
                            }}">
                                {{ ucfirst($contact->status) }}
                            </span>
                        </li>
                        @if($contact->replied_at)
                        <li class="mb-2">
                            <i class="bi bi-reply text-primary me-2"></i>
                            <strong>Replied:</strong> {{ $contact->replied_at->diffForHumans() }}
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mark as Replied Modal -->
<div class="modal fade" id="markRepliedModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Mark as Replied</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.contacts.mark-as-replied', $contact) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="admin_notes" class="form-label">Notes (Optional)</label>
                        <textarea class="form-control" id="admin_notes" name="admin_notes" rows="3" 
                                  placeholder="Add any notes about the reply..."></textarea>
                        <div class="form-text small">This will be saved with the message record.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Mark as Replied</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Send Reply Modal -->
<div class="modal fade" id="sendReplyModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Send Reply to {{ $contact->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.contacts.send-reply', $contact) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="reply_subject" class="form-label">Subject</label>
                        <input type="text" class="form-control" id="reply_subject" name="reply_subject" 
                               value="Re: {{ $contact->subject }}">
                    </div>
                    
                    <div class="mb-3">
                        <label for="reply_message" class="form-label">Your Reply Message *</label>
                        <textarea class="form-control" id="reply_message" name="reply_message" 
                                  rows="8" placeholder="Type your reply here..." required></textarea>
                        <div class="form-text small">
                            This will be sent to {{ $contact->email }} and the message will be marked as replied.
                        </div>
                    </div>
                    
                    <div class="alert alert-info small">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Original message from {{ $contact->name }}:</strong>
                        <div class="mt-2 p-2 bg-light rounded">
                            {!! nl2br(e($contact->message)) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-send me-1"></i> Send Reply
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection