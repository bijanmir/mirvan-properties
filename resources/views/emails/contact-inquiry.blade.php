<x-mail::message>
# New Contact Inquiry

You have received a new contact inquiry through the Mirvan Properties website.

## Contact Information
- **Name:** {{ $contact['name'] }}
- **Email:** {{ $contact['email'] }}
@if(!empty($contact['phone']))
- **Phone:** {{ $contact['phone'] }}
@endif
- **Inquiry Type:** {{ ucfirst(str_replace('_', ' ', $contact['inquiry_type'])) }}

## Subject
{{ $contact['subject'] }}

## Message
{{ $contact['message'] }}

<x-mail::button :url="route('contact')">
View Contact Page
</x-mail::button>

Please respond to this inquiry promptly to maintain our high level of customer service.

Thanks,<br>
{{ config('app.name') }} Website
</x-mail::message>