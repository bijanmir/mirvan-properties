<?php

namespace App\Mail;

use App\Models\Property;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PropertyInquiry extends Mailable
{
    use Queueable, SerializesModels;

    public Property $property;
    public array $inquiryData;

    /**
     * Create a new message instance.
     */
    public function __construct(Property $property, array $inquiryData)
    {
        $this->property = $property;
        $this->inquiryData = $inquiryData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Property Inquiry: ' . $this->property->title,
            replyTo: $this->inquiryData['email'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.property-inquiry',
            with: [
                'property' => $this->property,
                'inquiry' => $this->inquiryData,
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