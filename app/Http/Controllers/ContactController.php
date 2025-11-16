<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        // Send email
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

        return back()->with('success', 'Your message has been sent successfully!');
    }
}
