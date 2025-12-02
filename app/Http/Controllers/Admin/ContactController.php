<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
class ContactController extends Controller
{
    /**
     * Display a listing of contact messages.
     */
    public function index(Request $request)
    {
        $query = Contact::latest();
        
        // Filter by status
        if ($request->has('status') && in_array($request->status, ['unread', 'read', 'replied'])) {
            $query->where('status', $request->status);
        }
        
        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }
        
        $contacts = $query->paginate(20);
        
        $unreadCount = Contact::where('status', 'unread')->count();
        $readCount = Contact::where('status', 'read')->count();
        $repliedCount = Contact::where('status', 'replied')->count();
        $totalCount = Contact::count();
        
        return view('admin.contacts.index', compact(
            'contacts', 
            'unreadCount', 
            'readCount', 
            'repliedCount', 
            'totalCount'
        ));
    }

    /**
     * Display the specified contact message.
     */
    public function show(Contact $contact)
    {
        // Mark as read when viewing
        if ($contact->status === 'unread') {
            $contact->update(['status' => 'read']);
        }
        
        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Mark message as replied.
     */
    public function markAsReplied(Request $request, Contact $contact)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:1000'
        ]);
        
        $contact->update([
            'status' => 'replied',
            'admin_notes' => $request->admin_notes,
            'replied_at' => now()
        ]);
        
        return redirect()->route('admin.contacts.show', $contact)
            ->with('success', 'Message marked as replied!');
    }

    /**
     * Remove the specified contact message.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();
        
        return redirect()->route('admin.contacts.index')
            ->with('success', 'Contact message deleted successfully!');
    }
    
    /**
     * Mark message as read.
     */
    public function markAsRead(Contact $contact)
    {
        $contact->update(['status' => 'read']);
        
        return redirect()->back()
            ->with('success', 'Message marked as read!');
    }


    /**
 * Send reply email to contact message sender.
 */
public function sendReply(Request $request, Contact $contact)
{
    $request->validate([
        'reply_message' => 'required|string|min:10',
        'reply_subject' => 'nullable|string|max:255'
    ]);
    
    $subject = $request->reply_subject ?: 'Re: ' . $contact->subject;
    $replyMessage = $request->reply_message;
    
    // Send reply email
    try {
        Mail::send('emails.admin_reply', [
            'customer_name' => $contact->name,
            'admin_message' => $replyMessage,
            'original_message' => $contact->message,
            'original_subject' => $contact->subject
        ], function($mail) use ($contact, $subject) {
            $mail->from(config('mail.from.address'), config('mail.from.name'));
            $mail->to($contact->email)
                 ->subject($subject);
        });
        
        // Mark as replied with admin notes
        $contact->markAsReplied("Admin replied via system: " . Str::limit($replyMessage, 100));
        
        return redirect()->route('admin.contacts.show', $contact)
            ->with('success', 'Reply email sent successfully!');
            
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Failed to send email: ' . $e->getMessage());
    }
}
}