@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Online Payment Methods</h1>
        <p class="text-muted mb-0">Manage payment gateways for online payments</p>
    </div>

    <div class="row">
        @foreach($paymentMethods as $method)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-3">
                            @if($method->image)
                                <!-- Show uploaded image -->
                                <div class="bg-light rounded p-2" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                    <img src="{{ asset('storage/' . $method->image) }}" 
                                         alt="{{ $method->name }}" 
                                         class="img-fluid" 
                                         style="max-width: 50px; max-height: 50px; object-fit: contain;"
                                         onerror="this.onerror=null; this.parentElement.innerHTML='<i class=\'{{ $method->icon }} fa-lg text-primary\'></i>';">
                                </div>
                            @else
                                <!-- Fallback to icon -->
                                <div class="bg-light rounded-circle p-3">
                                    <i class="{{ $method->icon }} fa-lg text-primary"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="card-title mb-1">{{ $method->name }}</h5>
                            <p class="text-muted small mb-0">{{ $method->description }}</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <span class="badge bg-secondary text-uppercase">{{ $method->type }}</span>
                        @if($method->is_default)
                        <span class="badge bg-success ms-1">
                            <i class="fas fa-star me-1"></i> Default
                        </span>
                        @endif
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input status-toggle" type="checkbox" 
                                   data-id="{{ $method->id }}"
                                   {{ $method->is_active ? 'checked' : '' }}
                                   id="switch{{ $method->id }}">
                            <label class="form-check-label small" for="switch{{ $method->id }}">
                                {{ $method->is_active ? 'Active' : 'Inactive' }}
                            </label>
                        </div>
                        
                        <div>
                            @if(!$method->is_default)
                            <button type="button" class="btn btn-sm btn-outline-success set-default-btn"
                                    data-id="{{ $method->id }}"
                                    data-name="{{ $method->name }}">
                                <i class="fas fa-star"></i> Set Default
                            </button>
                            @else
                            <span class="badge bg-success px-3 py-2">
                                <i class="fas fa-star me-1"></i> Default
                            </span>
                            @endif
                        </div>
                    </div>

                   <a href="{{ route('admin.payments.edit', $method->id) }}" class="btn btn-sm btn-outline-primary w-100">
                   <i class="fas fa-cog me-1"></i> Configure
                   </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="alert alert-info">
                <h5><i class="fas fa-info-circle me-2"></i>Next Steps</h5>
                <p class="mb-0">To activate Paystack, you'll need to:</p>
                <ol class="mb-0 mt-2">
                    <li>Register on <a href="https://paystack.com" target="_blank">Paystack.com</a></li>
                    <li>Get your API keys from the dashboard</li>
                    <li>Configure them here when we build the configuration page</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Toggle active status
    $('.status-toggle').change(function() {
        const methodId = $(this).data('id');
        const isActive = $(this).is(':checked') ? 1 : 0;
        const $toggle = $(this);
        
        $.ajax({
            url: '{{ route("admin.payments.toggle-status") }}',
            method: 'POST',
            data: {
                id: methodId,
                is_active: isActive,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // Update the label text
                const label = $toggle.next('label');
                label.text(isActive ? 'Active' : 'Inactive');
                
                // Show success message
                toastr.success('Status updated successfully');
            },
            error: function() {
                // Revert the toggle if error
                $toggle.prop('checked', !isActive);
                toastr.error('Error updating status');
            }
        });
    });

    // Set as default payment method
    $('.set-default-btn').click(function() {
        const methodId = $(this).data('id');
        const methodName = $(this).data('name');
        const $button = $(this);
        
        if (confirm(`Set "${methodName}" as the default payment method?`)) {
            $.ajax({
                url: '{{ route("admin.payments.set-default") }}',
                method: 'POST',
                data: {
                    id: methodId,
                    _token: '{{ csrf_token() }}'
                },
                beforeSend: function() {
                    $button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Setting...');
                },
                success: function(response) {
                    toastr.success(response.message);
                    
                    // Reload the page after 1 second to show updated status
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                },
                error: function() {
                    toastr.error('Error setting default payment method');
                    $button.prop('disabled', false).html('<i class="fas fa-star"></i> Set Default');
                }
            });
        }
    });
});
</script>
@endsection