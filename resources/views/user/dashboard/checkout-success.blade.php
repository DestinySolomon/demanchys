@extends('layouts.user-dashboard-clean')

@section('title', 'Order Confirmed - Demanchys Lounge')

@section('content')
<div class="checkout-success-container">
    <div class="text-center py-5">
        <!-- Success Icon -->
        <div class="success-icon mb-4">
            <i class="bi bi-check-circle-fill display-1 text-success"></i>
        </div>
        
        <!-- Success Message -->
        <h1 class="mb-3">Order Confirmed!</h1>
        <p class="lead text-muted mb-4">
            Thank you for your order. We've received it and will start preparing it right away.
        </p>
        
        <!-- Order Details -->
        @if($order)
        <div class="dashboard-card mx-auto" style="max-width: 500px;">
            <div class="card-body">
                <h5 class="card-title mb-3">Order Details</h5>
                
                <div class="order-details">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Order Reference:</span>
                        <span class="fw-semibold">{{ $order->order_ref }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Date:</span>
                        <span>{{ $order->created_at->format('M d, Y h:i A') }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Status:</span>
                        <span class="badge bg-success">{{ ucfirst($order->order_status) }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Payment Method:</span>
                        <span>{{ ucfirst($order->payment_method) }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Total Amount:</span>
                        <span class="fw-bold text-warning fs-5">₦{{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>
                
                <hr class="my-4">
                
                <!-- Delivery Information -->
                <h6 class="mb-3">Delivery Information</h6>
                <p class="mb-2">
                    <strong>{{ $order->customer_name }}</strong><br>
                    {{ $order->customer_phone }}<br>
                    {{ $order->customer_email }}<br>
                    {{ $order->customer_address }}
                </p>
                
                @if($order->delivery_instructions)
                    <div class="alert alert-info mt-3">
                        <i class="bi bi-chat-left-text me-2"></i>
                        <strong>Delivery Instructions:</strong><br>
                        {{ $order->delivery_instructions }}
                    </div>
                @endif
            </div>
        </div>
        @endif
        
        <!-- Next Steps -->
        <div class="next-steps mt-5">
            <h5 class="mb-3">What's Next?</h5>
            <div class="row justify-content-center">
                <div class="col-md-4 mb-3">
                    <div class="card border-0 bg-light h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-clock-history display-6 text-warning mb-3"></i>
                            <h6>Order Preparation</h6>
                            <p class="small text-muted mb-0">We'll prepare your order immediately</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-3">
                    <div class="card border-0 bg-light h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-truck display-6 text-warning mb-3"></i>
                            <h6>Delivery</h6>
                            <p class="small text-muted mb-0">Estimated delivery: 30-45 minutes</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-3">
                    <div class="card border-0 bg-light h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-phone display-6 text-warning mb-3"></i>
                            <h6>Updates</h6>
                            <p class="small text-muted mb-0">We'll SMS you with updates</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="action-buttons mt-5">
            <a href="{{ route('user.orders') }}" class="btn btn-warning btn-lg me-3">
                <i class="bi bi-bag me-2"></i>
                View My Orders
            </a>
            <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary btn-lg">
                <i class="bi bi-house me-2"></i>
                Back to Dashboard
            </a>
        </div>
        
        <!-- Support Information -->
        <div class="support-info mt-5 pt-4 border-top">
            <p class="text-muted">
                <i class="bi bi-question-circle me-1"></i>
                Need help? Call us at <strong>{{ $settings['phone'] ?? '+234 123 456 7890' }}</strong> 
                or email <strong>{{ $settings['email'] ?? 'support@demanchys.com' }}</strong>
            </p>
        </div>
    </div>
</div>

@push('styles')
<style>
    .checkout-success-container {
        max-width: 800px;
        margin: 0 auto;
        min-height: 70vh;
        display: flex;
        align-items: center;
    }
    
    .success-icon {
        animation: bounceIn 0.6s ease;
    }
    
    @keyframes bounceIn {
        0% {
            transform: scale(0.5);
            opacity: 0;
        }
        60% {
            transform: scale(1.1);
            opacity: 1;
        }
        100% {
            transform: scale(1);
        }
    }
    
    .dashboard-card {
        background: #ffffff;
        border: 1px solid #eaeaea;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    
    .card-body {
        padding: 2rem;
    }
    
    .card-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #2d3748;
    }
    
    .order-details {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 8px;
    }
    
    .btn-warning {
        background: linear-gradient(135deg, #ffc107, #ffb347);
        border: none;
        color: #000;
        font-weight: 600;
        padding: 0.875rem 2rem;
        transition: all 0.3s;
    }
    
    .btn-warning:hover {
        background: linear-gradient(135deg, #e6a700, #ffa500);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);
    }
    
    .btn-outline-secondary {
        border: 2px solid #e2e8f0;
        font-weight: 600;
        padding: 0.875rem 2rem;
        transition: all 0.3s;
    }
    
    .btn-outline-secondary:hover {
        background: #f8f9fa;
        border-color: #cbd5e0;
        transform: translateY(-2px);
    }
    
    .next-steps .card {
        transition: transform 0.3s;
    }
    
    .next-steps .card:hover {
        transform: translateY(-5px);
    }
    
    @media (max-width: 768px) {
        .checkout-success-container {
            padding: 2rem 1rem;
        }
        
        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .action-buttons .btn {
            width: 100%;
            margin: 0 !important;
        }
        
        .next-steps .col-md-4 {
            margin-bottom: 1rem;
        }
    }
</style>
@endpush
@endsection