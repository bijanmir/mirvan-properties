<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactInquiry extends Mailable
{
    use Queueable, SerializesModels;

    public array $contactData;
    public bool $isUserCopy;

    /**
     * Create a new message instance.
     */
    public function __construct(array $contactData, bool $isUserCopy = false)
    {
        $this->contactData = $contactData;
        $this->isUserCopy = $isUserCopy;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->isUserCopy 
            ? 'Thank you for contacting Mirvan Properties'
            : 'New Contact Inquiry: ' . $this->contactData['subject'];

        return new Envelope(
            subject: $subject,
            replyTo: $this->contactData['email'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $view = $this->isUserCopy 
            ? 'emails.contact-confirmation'
            : 'emails.contact-inquiry';

        return new Content(
            markdown: $view,
            with: [
                'contact' => $this->contactData,
                'isUserCopy' => $this->isUserCopy,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}