<x-mail::message>
# Thank You for Contacting Us

Dear {{ $contact['name'] }},

Thank you for reaching out to Mirvan Properties. We have received your inquiry and will respond within 24 hours.

## Your Message Details
- **Subject:** {{ $contact['subject'] }}
- **Inquiry Type:** {{ ucfirst(str_replace('_', ' ', $contact['inquiry_type'])) }}
- **Date Submitted:** {{ now()->format('F j, Y \a\t g:i A') }}

## Your Message
{{ $contact['message'] }}

## What Happens Next?
Our team will review your inquiry and respond promptly. For urgent matters, please call us directly at (555) 123-4567.

## Contact Information
- **Phone:** (555) 123-4567
- **Email:** info@mirvanproperties.com
- **Office Hours:** Monday-Friday 9:00 AM - 7:00 PM

<x-mail::button :url="route('properties.index')">
Browse Our Properties
</x-mail::button>

We appreciate your interest in Mirvan Properties and look forward to assisting you with your real estate needs.

Best regards,<br>
The Mirvan Properties Team
</x-mail::message>