<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactInquiry;

class ContactController extends Controller
{
    /**
     * Show the contact form.
     */
    public function show()
    {
        return view('pages.contact');
    }

    /**
     * Store a contact form submission.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
            'inquiry_type' => 'required|in:general,buying,selling,leasing,investment',
        ]);

        try {
            // Send email to admin
            Mail::to('info@mirvanproperties.com')->send(
                new ContactInquiry($request->all())
            );

            // Optionally send confirmation email to user
            if ($request->filled('send_copy')) {
                Mail::to($request->email)->send(
                    new ContactInquiry($request->all(), true) // true for user copy
                );
            }

            return back()->with('success', 'Thank you for your message! We will get back to you within 24 hours.');
        } catch (\Exception $e) {
            \Log::error('Contact form error: ' . $e->getMessage());
            return back()->with('error', 'There was an error sending your message. Please try again or call us directly.');
        }
    }
}