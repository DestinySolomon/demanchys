<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreatePaystackConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'paystack:config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Paystack configuration file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $configPath = config_path('paystack.php');
        
        // Check if config file already exists
        if (File::exists($configPath)) {
            if ($this->confirm('Paystack config file already exists. Overwrite?')) {
                File::delete($configPath);
            } else {
                $this->info('Operation cancelled.');
                return;
            }
        }
        
        $configContent = <<<'PHP'
<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Paystack Keys
    |--------------------------------------------------------------------------
    |
    | The Paystack public key and secret key. You can get these from your
    | Paystack dashboard. Always use environment variables for security.
    |
    */
    
    'public_key' => env('PAYSTACK_PUBLIC_KEY', ''),
    'secret_key' => env('PAYSTACK_SECRET_KEY', ''),
    
    /*
    |--------------------------------------------------------------------------
    | Merchant Email
    |--------------------------------------------------------------------------
    |
    | Your Paystack merchant email address.
    |
    */
    'merchant_email' => env('PAYSTACK_MERCHANT_EMAIL', ''),
    
    /*
    |--------------------------------------------------------------------------
    | Payment URL
    |--------------------------------------------------------------------------
    |
    | Paystack API URL. Use the test URL for development.
    |
    */
    'payment_url' => env('PAYSTACK_PAYMENT_URL', 'https://api.paystack.co'),
    
    /*
    |--------------------------------------------------------------------------
    | Callback URL
    |--------------------------------------------------------------------------
    |
    | URL where Paystack will redirect after payment.
    |
    */
    'callback_url' => env('PAYSTACK_CALLBACK_URL', '/payment/callback'),
    
    /*
    |--------------------------------------------------------------------------
    | Webhook URL
    |--------------------------------------------------------------------------
    |
    | URL for Paystack webhook notifications.
    |
    */
    'webhook_url' => env('PAYSTACK_WEBHOOK_URL', '/payment/webhook'),
    
    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | Your Paystack encryption key (if using inline payment).
    |
    */
    'encryption_key' => env('PAYSTACK_ENCRYPTION_KEY', ''),
    
    /*
    |--------------------------------------------------------------------------
    | Default Currency
    |--------------------------------------------------------------------------
    |
    | Default currency for transactions.
    |
    */
    'currency' => env('PAYSTACK_CURRENCY', 'NGN'),
    
    /*
    |--------------------------------------------------------------------------
    | Default Charges
    |--------------------------------------------------------------------------
    |
    | Default transaction charges.
    |
    */
    'charges' => [
        'percentage' => 1.5, // 1.5% charge
        'additional_charge' => 100, // Additional charge in kobo
    ],
];
PHP;

        // Create the config directory if it doesn't exist
        if (!File::exists(config_path())) {
            File::makeDirectory(config_path(), 0755, true);
        }
        
        // Write the config file
        File::put($configPath, $configContent);
        
        $this->info('Paystack configuration file created successfully at: ' . $configPath);
        $this->line('');
        $this->info('Next steps:');
        $this->line('1. Add your Paystack keys to your .env file:');
        $this->line('   PAYSTACK_PUBLIC_KEY=pk_test_xxxxxx');
        $this->line('   PAYSTACK_SECRET_KEY=sk_test_xxxxxx');
        $this->line('   PAYSTACK_MERCHANT_EMAIL=your@email.com');
        $this->line('');
        $this->info('2. Test the configuration by running:');
        $this->line('   php artisan paystack:test');
    }
}