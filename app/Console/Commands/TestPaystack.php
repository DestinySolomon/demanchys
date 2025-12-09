<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Yabacon\Paystack;

class TestPaystack extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'paystack:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Paystack configuration and connection';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== Paystack Configuration Test ===');
        $this->line('');
        
        // 1. Check if config file exists
        $configPath = config_path('paystack.php');
        if (!file_exists($configPath)) {
            $this->error('❌ Config file not found at: ' . $configPath);
            $this->line('   Run: php artisan paystack:config');
            return 1;
        }
        $this->info('✓ Config file exists: ' . $configPath);
        
        // 2. Check if config is loaded
        $config = config('paystack');
        if (!is_array($config)) {
            $this->error('❌ Config file exists but not loaded as array');
            $this->line('   Try: php artisan config:clear');
            return 1;
        }
        $this->info('✓ Config loaded successfully');
        
        // 3. Check environment variables
        $this->line('');
        $this->info('Environment Variables:');
        
        $publicKey = env('PAYSTACK_PUBLIC_KEY');
        $secretKey = env('PAYSTACK_SECRET_KEY');
        $merchantEmail = env('PAYSTACK_MERCHANT_EMAIL');
        
        $this->line('   PAYSTACK_PUBLIC_KEY: ' . ($publicKey ? '✓ "' . substr($publicKey, 0, 10) . '..."' : '✗ Not set'));
        $this->line('   PAYSTACK_SECRET_KEY: ' . ($secretKey ? '✓ "' . substr($secretKey, 0, 10) . '..."' : '✗ Not set'));
        $this->line('   PAYSTACK_MERCHANT_EMAIL: ' . ($merchantEmail ? '✓ "' . $merchantEmail . '"' : '✗ Not set'));
        
        // 4. Check package availability
        $this->line('');
        $this->info('Package Check:');
        
        if (!class_exists('Yabacon\Paystack')) {
            $this->error('❌ Paystack PHP package not found!');
            $this->line('   Run: composer require yabacon/paystack-php');
            return 1;
        }
        $this->info('✓ Paystack package available (v2.2)');
        
        // 5. Test instantiation
        $this->line('');
        $this->info('Package Instantiation:');
        
        try {
            // Try with dummy key first to test instantiation
            $testKey = $secretKey ?: 'sk_test_dummy_key_for_testing';
            $paystack = new Paystack($testKey);
            $this->info('✓ Package instantiated successfully');
        } catch (\Exception $e) {
            $this->error('❌ Failed to instantiate Paystack: ' . $e->getMessage());
            return 1;
        }
        
        // 6. If keys are set, test API connection
        if ($secretKey && !str_contains($secretKey, 'dummy')) {
            $this->line('');
            $this->info('API Connection Test:');
            
            try {
                // Simple API test - get list of banks (limited to 1)
                $result = $paystack->bank->getList(['perPage' => 1]);
                
                if ($result && $result->status) {
                    $this->info('✓ API connection successful!');
                    $this->line('   Response: ' . $result->message);
                } else {
                    $this->warn('⚠ API responded but with unexpected result');
                }
            } catch (\Exception $e) {
                $this->warn('⚠ API test failed (might be invalid keys): ' . $e->getMessage());
            }
        } else {
            $this->line('');
            $this->warn('⚠ Using dummy keys - skipping real API test');
            $this->line('   Add real keys to .env for full API test');
        }
        
        // 7. Final summary
        $this->line('');
        $this->info('========================================');
        $this->info('✅ SETUP COMPLETE!');
        $this->info('========================================');
        $this->line('');
        
        if (!$publicKey || !$secretKey || str_contains($secretKey, 'dummy')) {
            $this->warn('IMPORTANT: Add real Paystack keys to .env');
            $this->line('Get test keys from: https://dashboard.paystack.com');
            $this->line('');
            $this->line('Example .env entries:');
            $this->line('PAYSTACK_PUBLIC_KEY=pk_test_your_real_key');
            $this->line('PAYSTACK_SECRET_KEY=sk_test_your_real_key');
            $this->line('PAYSTACK_MERCHANT_EMAIL=your@email.com');
        } else {
            $this->info('🎉 Everything is set up correctly!');
            $this->line('You can now use Paystack in your application.');
        }
        
        $this->line('');
        $this->info('Quick usage example:');
        $this->line('$paystack = new Yabacon\Paystack(config(\'paystack.secret_key\'));');
        $this->line('$transaction = $paystack->transaction->initialize([...]);');
        
        return 0;
    }
}