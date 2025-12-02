<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'icon',
        'image',
        'is_active',
        'is_default',
        'sort_order',
        'credentials'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'credentials' => 'array'
    ];

    /**
     * Get the icon class for the payment method
     */
    public function getIconAttribute($value)
    {
        // If no icon is set, return a default based on type
        if (!$value) {
            $defaultIcons = [
                'cash' => 'fas fa-money-bill-wave',
                'pos' => 'fas fa-credit-card',
                'bank_transfer' => 'fas fa-university',
                'flutterwave' => 'fas fa-wave-square',
                'paystack' => 'fas fa-bolt',
                'ussd' => 'fas fa-mobile-alt',
                'mobile_money' => 'fas fa-money-check-alt',
            ];
            
            return $defaultIcons[$this->type] ?? 'fas fa-wallet';
        }
        
        return $value;
    }

    /**
     * Scope a query to only include active payment methods.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the default payment method.
     */
    public static function getDefault()
    {
        return self::where('is_default', true)->first();
    }

    /**
     * Check if this is the default payment method.
     */
    public function isDefault()
    {
        return $this->is_default;
    }

    /**
     * Get configuration fields for this payment method type
     */
    public function getConfigurationFields()
    {
        $fields = [
            'paystack' => [
                [
                    'name' => 'public_key',
                    'label' => 'Public Key',
                    'type' => 'text',
                    'required' => true,
                    'help' => 'Your Paystack public API key'
                ],
                [
                    'name' => 'secret_key',
                    'label' => 'Secret Key',
                    'type' => 'password',
                    'required' => true,
                    'help' => 'Your Paystack secret API key'
                ],
                [
                    'name' => 'callback_url',
                    'label' => 'Callback URL',
                    'type' => 'text',
                    'required' => false,
                    'default' => url('/payment/callback'),
                    'help' => 'Where Paystack sends payment notifications'
                ]
            ],
            'bank_transfer' => [
                [
                    'name' => 'bank_name',
                    'label' => 'Bank Name',
                    'type' => 'text',
                    'required' => true,
                    'help' => 'Name of your bank'
                ],
                [
                    'name' => 'account_name',
                    'label' => 'Account Name',
                    'type' => 'text',
                    'required' => true,
                    'help' => 'Name on the bank account'
                ],
                [
                    'name' => 'account_number',
                    'label' => 'Account Number',
                    'type' => 'text',
                    'required' => true,
                    'help' => 'Your bank account number'
                ],
                [
                    'name' => 'instructions',
                    'label' => 'Transfer Instructions',
                    'type' => 'textarea',
                    'required' => false,
                    'help' => 'Instructions for customers making transfers'
                ]
            ],
            'mobile_money' => [
                [
                    'name' => 'provider',
                    'label' => 'Mobile Money Provider',
                    'type' => 'select',
                    'options' => ['opay' => 'OPay', 'palmpay' => 'PalmPay', 'mtn' => 'MTN MoMo', 'airtel' => 'Airtel Money'],
                    'required' => true,
                    'help' => 'Select the mobile money provider'
                ],
                [
                    'name' => 'phone_number',
                    'label' => 'Phone Number',
                    'type' => 'text',
                    'required' => true,
                    'help' => 'Your mobile money phone number'
                ],
                [
                    'name' => 'account_name',
                    'label' => 'Account Name',
                    'type' => 'text',
                    'required' => true,
                    'help' => 'Name on the mobile money account'
                ]
            ],
            'cash' => [
                [
                    'name' => 'instructions',
                    'label' => 'Cash Payment Instructions',
                    'type' => 'textarea',
                    'required' => false,
                    'help' => 'Instructions for cash payments'
                ]
            ],
            'pos' => [
                [
                    'name' => 'instructions',
                    'label' => 'POS Payment Instructions',
                    'type' => 'textarea',
                    'required' => false,
                    'help' => 'Instructions for POS payments'
                ]
            ],
            'ussd' => [
                [
                    'name' => 'instructions',
                    'label' => 'USSD Payment Instructions',
                    'type' => 'textarea',
                    'required' => false,
                    'help' => 'USSD code and instructions'
                ]
            ]
        ];

        return $fields[$this->type] ?? [];
    }

    /**
 * Get all available payment types
 */
public static function getPaymentTypes()
{
    return [
        'cash' => 'Cash',
        'pos' => 'POS',
        'bank_transfer' => 'Bank Transfer',
        'paystack' => 'Paystack',
        'mobile_money' => 'Mobile Money',
        'ussd' => 'USSD'
    ];
}

    /**
     * Get the value of a configuration field
     */
    public function getConfigValue($fieldName, $default = null)
    {
        $credentials = $this->credentials ?? [];
        return $credentials[$fieldName] ?? $default;
    }

    /**
     * Check if payment method requires configuration
     */
    public function requiresConfiguration()
    {
        return !empty($this->getConfigurationFields());
    }

    /**
     * Check if payment method is for online payments
     */
    public function isOnlinePayment()
    {
        return in_array($this->type, ['paystack', 'flutterwave']);
    }

    
}