@php
    use App\Models\Setting;
@endphp

@if(Setting::getValue('whatsapp_enabled') && Setting::getValue('whatsapp_number'))
    @php
        $whatsappNumber = Setting::getValue('whatsapp_number');
        $whatsappMessage = Setting::getValue('whatsapp_message', 'Hello! I need help with...');
        $position = Setting::getValue('whatsapp_position', 'right');
        $delay = Setting::getValue('whatsapp_delay', 5) * 1000; // Convert to milliseconds
    @endphp
    
    <div class="whatsapp-widget whatsapp-{{ $position }}" id="whatsappWidget">
        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $whatsappNumber) }}?text={{ urlencode($whatsappMessage) }}" 
           target="_blank" 
           class="whatsapp-button" 
           id="whatsappButton"
           title="Chat with us on WhatsApp">
            <i class="bi bi-whatsapp"></i>
            <span class="whatsapp-label">Need help?</span>
        </a>
    </div>

    <style>
        .whatsapp-widget {
            position: fixed;
            z-index: 99999;
            bottom: 20px;
        }
        
        .whatsapp-right {
            right: 20px;
        }
        
        .whatsapp-left {
            left: 20px;
        }
        
        .whatsapp-button {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 60px;
            background: #25D366;
            border-radius: 50%;
            color: white;
            font-size: 28px;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(37, 211, 102, 0.4);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .whatsapp-button:hover {
            background: #128C7E;
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(37, 211, 102, 0.6);
            text-decoration: none;
            color: white;
        }
        
        .whatsapp-label {
            position: absolute;
            right: 70px;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
            white-space: nowrap;
            opacity: 0;
            transform: translateX(10px);
            transition: all 0.3s ease;
            pointer-events: none;
        }
        
        .whatsapp-button:hover .whatsapp-label {
            opacity: 1;
            transform: translateX(0);
        }
        
        /* Animation for first-time visitors */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        
        .whatsapp-button.pulse {
            animation: pulse 2s infinite;
        }
        
        /* Mobile responsive */
        @media (max-width: 768px) {
            .whatsapp-button {
                width: 50px;
                height: 50px;
                font-size: 24px;
                bottom: 15px;
                right: 15px;
            }
            
            .whatsapp-label {
                font-size: 12px;
                padding: 4px 10px;
                right: 60px;
            }
        }
        
        @media (max-width: 576px) {
            .whatsapp-button {
                width: 45px;
                height: 45px;
                font-size: 22px;
            }
            
            .whatsapp-label {
                display: none; /* Hide label on very small screens */
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const whatsappButton = document.getElementById('whatsappButton');
            const delay = {{ $delay }};
            
            // Add pulse animation after delay
            if (delay > 0) {
                setTimeout(function() {
                    whatsappButton.classList.add('pulse');
                    
                    // Remove pulse after 10 seconds
                    setTimeout(function() {
                        whatsappButton.classList.remove('pulse');
                    }, 10000);
                }, delay);
            } else {
                // If no delay, show pulse immediately
                whatsappButton.classList.add('pulse');
                setTimeout(function() {
                    whatsappButton.classList.remove('pulse');
                }, 10000);
            }
            
            // Optional: Track clicks (if you want analytics)
            whatsappButton.addEventListener('click', function() {
                // You can add Google Analytics or other tracking here
                console.log('WhatsApp widget clicked');
            });
        });
    </script>
@endif