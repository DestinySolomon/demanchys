<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        // Save to database
        $contact = Contact::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'status' => 'unread'
        ]);

        // Send email notification (optional - keep your existing email code)
        try {
            Mail::send('emails.contact', [
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'bodyMessage' => $request->message,
            ], function($mail) use ($request) {
                $mail->from($request->email, $request->name);
                $mail->to('navaldestiny44@gmail.com')
                     ->subject('New Contact Message: ' . $request->subject);
            });
        } catch (\Exception $e) {
            // Log email error but don't fail the form submission
            Log::error('Contact form email failed: ' . $e->getMessage());
        }

        return back()->with('success', 'Your message has been sent successfully! We will get back to you soon.');
    }
}