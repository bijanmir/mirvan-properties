@extends('layouts.app')

@section('title', 'Contact Us - Mirvan Properties')
@section('meta_description', 'Get in touch with Mirvan Properties for all your real estate needs. We\'re here to help with buying, selling, leasing, and investment opportunities.')

@section('content')
<!-- Contact Header -->
<section class="bg-gradient-to-r from-blue-600 to-purple-600 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center text-white">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                Contact Us
            </h1>
            <p class="text-xl text-blue-100 max-w-2xl mx-auto">
                Ready to take the next step? We're here to help with all your real estate needs.
            </p>
        </div>
    </div>
</section>

<!-- Contact Content -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
            <!-- Contact Form -->
            <div>
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Send Us a Message</h2>
                    
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            <div class="flex">
                                <svg class="w-5 h-5 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                            <div class="flex">
                                <svg class="w-5 h-5 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                {{ session('error') }}
                            </div>
                        </div>
                    @endif
                    
                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <!-- Name and Email Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Full Name *
                                </label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       required
                                       value="{{ old('name') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror">
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Email Address *
                                </label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       required
                                       value="{{ old('email') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror">
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Phone and Inquiry Type Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                    Phone Number
                                </label>
                                <input type="tel" 
                                       id="phone" 
                                       name="phone"
                                       value="{{ old('phone') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('phone') border-red-500 @enderror">
                                @error('phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="inquiry_type" class="block text-sm font-medium text-gray-700 mb-2">
                                    Inquiry Type *
                                </label>
                                <select id="inquiry_type" 
                                        name="inquiry_type" 
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('inquiry_type') border-red-500 @enderror">
                                    <option value="">Select an option</option>
                                    <option value="general" {{ old('inquiry_type') == 'general' ? 'selected' : '' }}>General Inquiry</option>
                                    <option value="buying" {{ old('inquiry_type') == 'buying' ? 'selected' : '' }}>Buying Property</option>
                                    <option value="selling" {{ old('inquiry_type') == 'selling' ? 'selected' : '' }}>Selling Property</option>
                                    <option value="leasing" {{ old('inquiry_type') == 'leasing' ? 'selected' : '' }}>Leasing</option>
                                    <option value="investment" {{ old('inquiry_type') == 'investment' ? 'selected' : '' }}>Investment Opportunities</option>
                                </select>
                                @error('inquiry_type')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Subject -->
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                                Subject *
                            </label>
                            <input type="text" 
                                   id="subject" 
                                   name="subject" 
                                   required
                                   value="{{ old('subject') }}"
                                   placeholder="Brief description of your inquiry"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('subject') border-red-500 @enderror">
                            @error('subject')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Message -->
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                                Message *
                            </label>
                            <textarea id="message" 
                                      name="message" 
                                      rows="6" 
                                      required
                                      placeholder="Please provide details about your inquiry..."
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Send Copy Checkbox -->
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   id="send_copy" 
                                   name="send_copy" 
                                   value="1"
                                   {{ old('send_copy') ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="send_copy" class="ml-2 block text-sm text-gray-700">
                                Send me a copy of this message
                            </label>
                        </div>
                        
                        <!-- Submit Button -->
                        <button type="submit" 
                                class="w-full bg-blue-600 text-white py-4 px-6 rounded-lg font-semibold text-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                            Send Message
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Contact Information -->
            <div class="space-y-8">
                <!-- Contact Details -->
                <div class="bg-gray-50 rounded-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Get in Touch</h2>
                    
                    <div class="space-y-6">
                        <!-- Phone -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">Phone</h3>
                                <p class="text-gray-600">Call us for immediate assistance</p>
                                <a href="tel:+1-555-123-4567" class="text-blue-600 hover:text-blue-700 font-medium">
                                    +1 (555) 123-4567
                                </a>
                            </div>
                        </div>
                        
                        <!-- Email -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">Email</h3>
                                <p class="text-gray-600">Send us an email anytime</p>
                                <a href="mailto:info@mirvanproperties.com" class="text-blue-600 hover:text-blue-700 font-medium">
                                    info@mirvanproperties.com
                                </a>
                            </div>
                        </div>
                        
                        <!-- Address -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">Office</h3>
                                <p class="text-gray-600">Visit us at our main office</p>
                                <address class="text-gray-700 not-italic">
                                    123 Real Estate Blvd<br>
                                    Suite 500<br>
                                    Los Angeles, CA 90210
                                </address>
                            </div>
                        </div>
                        
                        <!-- Hours -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">Business Hours</h3>
                                <p class="text-gray-600">We're here to help</p>
                                <div class="text-gray-700">
                                    <p>Monday - Friday: 9:00 AM - 7:00 PM</p>
                                    <p>Saturday: 10:00 AM - 5:00 PM</p>
                                    <p>Sunday: 12:00 PM - 4:00 PM</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Why Choose Us -->
                <div class="bg-blue-50 rounded-lg p-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Why Choose Mirvan Properties?</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-700">Expert knowledge of local markets</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-700">Personalized service for every client</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-700">Comprehensive property management</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-700">24/7 customer support</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-700">Proven track record of success</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="py-16 bg-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Find Our Office</h2>
            <p class="text-lg text-gray-600">Located in the heart of Los Angeles, we're easily accessible</p>
        </div>
        
        <!-- Map Placeholder -->
        <div class="bg-gray-300 h-96 rounded-lg flex items-center justify-center">
            <div class="text-center">
                <svg class="mx-auto h-16 w-16 text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <p class="text-gray-600">Interactive map placeholder</p>
                <p class="text-sm text-gray-500">123 Real Estate Blvd, Suite 500, Los Angeles, CA 90210</p>
            </div>
        </div>
    </div>
</section>

@endsection