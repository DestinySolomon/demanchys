<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OtpCode;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;



class OtpLoginController extends Controller
{
    // Step A: show phone number form
    public function loginPage()
    {
        return view('auth.whatsapp-login');
    }

    // Step B: generate OTP
    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required'
        ]);

        $otp = rand(100000, 999999);

        OtpCode::create([
            'phone' => $request->phone,
            'code' => $otp,
            'expires_at' => Carbon::now()->addMinutes(5)
        ]);

            $message = urlencode("Your De Manchys Lounge login OTP is: $otp");

            return redirect("https://wa.me/{$request->phone}?text={$message}");
        }

       // Step C: show OTP verify page
       public function verifyPage(Request $request)
    {
        return view('auth.verify-otp', ['phone' => $request->phone]);
    }

    // Step D: Verify OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'otp'   => 'required'
        ]);

        $otpData = OtpCode::where('phone', $request->phone)
            ->where('code', $request->otp)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$otpData) {
            return back()->with('error', 'Invalid or expired OTP');
        }

        // find or create user
        $user = User::firstOrCreate(
            ['phone' => $request->phone],
            ['name' => 'Customer']
        );

        Auth::login($user);

        return redirect('/checkout');
    }
}