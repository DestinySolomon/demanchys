@extends('layouts.user-dashboard-clean')

@section('title', 'Payment Cancelled - Demanchys Lounge')

@section('content')
<div class="checkout-cancel-container">
    <div class="text-center py-5">
        <!-- Cancel Icon -->
        <div class="cancel-icon mb-4">
            <i class="bi bi-x-circle-fill display-1 text-danger"></i>
        </div>
        
        <!-- Cancel Message -->
        <h1 class="mb-3">Payment Cancelled</h1>
        <p class="lead text-muted mb-4">
            Your payment was cancelled. No charges were made to your account.
        </p>
        
        <!-- Explanation -->
        <div class="dashboard-card mx-auto mb-4" style="max-width: 500px;">
            <div class="card-body">
                <h6 class="card-title mb-3">Possible Reasons</h6>
                <ul class="text-start">
                    <li>You cancelled the payment process</li>
                    <li>Payment session expired</li>
                    <li>Technical issue with payment gateway</li>
                    <li>Insufficient funds in your account</li>
                </ul>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="action-buttons mt-4">
            <a href="{{ route('user.cart') }}" class="btn btn-warning btn-lg me-3">
                <i class="bi bi-arrow-left me-2"></i>
                Back to Cart
            </a>
            <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary btn-lg">
                <i class="bi bi-house me-2"></i>
                Back to Dashboard
            </a>
        </div>
        
        <!-- Support -->
        <div class="support-info mt-5 pt-4 border-top">
            <p class="text-muted">
                Need help with payment? Contact us at 
                <strong>{{ $settings['phone'] ?? '+234 123 456 7890' }}</strong>
            </p>
        </div>
    </div>
</div>

@push('styles')
<style>
    .checkout-cancel-container {
        max-width: 600px;
        margin: 0 auto;
        min-height: 70vh;
        display: flex;
        align-items: center;
    }
    
    .cancel-icon {
        animation: shake 0.5s ease;
    }
    
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-10px); }
        75% { transform: translateX(10px); }
    }
    
    .dashboard-card {
        background: #ffffff;
        border: 1px solid #eaeaea;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    ul {
        padding-left: 1.5rem;
    }
    
    li {
        margin-bottom: 0.5rem;
        color: #6c757d;
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
    
    @media (max-width: 768px) {
        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .action-buttons .btn {
            width: 100%;
            margin: 0 !important;
        }
    }
</style>
@endpush
@endsection