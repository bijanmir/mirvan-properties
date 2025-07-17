@extends('layouts.app')

@section('title', 'About Us - Mirvan Properties')
@section('meta_description', 'Learn about Mirvan Properties - your trusted partner in premium real estate. We specialize in commercial and residential properties with exceptional service.')

@section('content')
<!-- About Hero Section -->
<section class="bg-gradient-to-r from-blue-600 to-purple-600 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center text-white">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">
                About Mirvan Properties
            </h1>
            <p class="text-xl md:text-2xl text-blue-100 max-w-3xl mx-auto leading-relaxed">
                Your trusted partner in premium real estate for over two decades
            </p>
        </div>
    </div>
</section>

<!-- Company Story -->
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                    Our Story
                </h2>
                <div class="space-y-6 text-lg text-gray-600">
                    <p>
                        Founded in 2001, Mirvan Properties has grown from a small local real estate firm to one of the most trusted names in premium property development and management. Our journey began with a simple vision: to redefine excellence in real estate services.
                    </p>
                    <p>
                        Over the years, we've built lasting relationships with clients, investors, and communities by consistently delivering exceptional results. Our portfolio spans commercial developments, luxury residential properties, and strategic investment opportunities across major metropolitan areas.
                    </p>
                    <p>
                        Today, we're proud to have facilitated over $2 billion in real estate transactions while maintaining our commitment to personalized service and innovative solutions.
                    </p>
                </div>
            </div>
            <div class="relative">
                <div class="aspect-w-4 aspect-h-3">
                    <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" 
                         alt="Modern office building representing our company" 
                         class="rounded-lg shadow-xl object-cover w-full h-96">
                </div>
                <!-- Floating Stats Card -->
                <div class="absolute -bottom-8 -left-8 bg-white rounded-lg shadow-lg p-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600">20+</div>
                        <div class="text-sm text-gray-600">Years Experience</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission, Vision, Values -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Our Foundation
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                The principles that guide everything we do
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Mission -->
            <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Our Mission</h3>
                <p class="text-gray-600">
                    To provide exceptional real estate services that exceed client expectations while creating lasting value for communities and stakeholders.
                </p>
            </div>
            
            <!-- Vision -->
            <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Our Vision</h3>
                <p class="text-gray-600">
                    To be the leading real estate firm recognized for innovation, integrity, and transformative property solutions that shape the future of communities.
                </p>
            </div>
            
            <!-- Values -->
            <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Our Values</h3>
                <p class="text-gray-600">
                    Integrity, excellence, and client-first approach drive our commitment to transparent and ethical business practices in every transaction.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Statistics -->
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Our Track Record
            </h2>
            <p class="text-xl text-gray-600">
                Numbers that speak to our success and commitment
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="text-4xl md:text-5xl font-bold text-blue-600 mb-2">$2B+</div>
                <div class="text-gray-600 font-medium">Total Transactions</div>
            </div>
            <div class="text-center">
                <div class="text-4xl md:text-5xl font-bold text-blue-600 mb-2">500+</div>
                <div class="text-gray-600 font-medium">Properties Sold</div>
            </div>
            <div class="text-center">
                <div class="text-4xl md:text-5xl font-bold text-blue-600 mb-2">98%</div>
                <div class="text-gray-600 font-medium">Client Satisfaction</div>
            </div>
            <div class="text-center">
                <div class="text-4xl md:text-5xl font-bold text-blue-600 mb-2">15</div>
                <div class="text-gray-600 font-medium">Major Cities</div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Our Leadership Team
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Meet the experts who drive our success and guide our vision
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Team Member 1 -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                <div class="aspect-w-1 aspect-h-1">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80" 
                         alt="CEO Portrait" 
                         class="w-full h-64 object-cover">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-1">Michael Johnson</h3>
                    <p class="text-blue-600 font-medium mb-3">CEO & Founder</p>
                    <p class="text-gray-600 text-sm">
                        With over 25 years in real estate, Michael founded Mirvan Properties with a vision to revolutionize premium property services.
                    </p>
                </div>
            </div>
            
            <!-- Team Member 2 -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                <div class="aspect-w-1 aspect-h-1">
                    <img src="https://images.unsplash.com/photo-1494790108755-2616b95cad42?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80" 
                         alt="COO Portrait" 
                         class="w-full h-64 object-cover">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-1">Sarah Chen</h3>
                    <p class="text-blue-600 font-medium mb-3">Chief Operating Officer</p>
                    <p class="text-gray-600 text-sm">
                        Sarah oversees daily operations and strategic planning, bringing innovative solutions to complex real estate challenges.
                    </p>
                </div>
            </div>
            
            <!-- Team Member 3 -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                <div class="aspect-w-1 aspect-h-1">
                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80" 
                         alt="Investment Director Portrait" 
                         class="w-full h-64 object-cover">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-1">David Rodriguez</h3>
                    <p class="text-blue-600 font-medium mb-3">Director of Investments</p>
                    <p class="text-gray-600 text-sm">
                        David leads our investment strategy, identifying opportunities that deliver exceptional returns for our clients.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Overview -->
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                What We Do
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Comprehensive real estate services tailored to your unique needs
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <!-- Commercial Real Estate -->
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Commercial Real Estate</h3>
                    <p class="text-gray-600">
                        From office buildings to retail spaces, we provide comprehensive commercial real estate solutions including acquisition, development, leasing, and management.
                    </p>
                </div>
            </div>
            
            <!-- Residential Properties -->
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m0 0h3m0 0h3m0 0a1 1 0 001-1V10M9 21v-6a1 1 0 011-1h2a1 1 0 011 1v6" />
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Luxury Residential</h3>
                    <p class="text-gray-600">
                        Specializing in high-end residential properties, from penthouses to family estates, we help clients find their perfect home or investment property.
                    </p>
                </div>
            </div>
            
            <!-- Investment Services -->
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Investment Advisory</h3>
                    <p class="text-gray-600">
                        Our investment team provides strategic guidance for portfolio diversification, market analysis, and identifying high-yield opportunities.
                    </p>
                </div>
            </div>
            
            <!-- Property Management -->
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Property Management</h3>
                    <p class="text-gray-600">
                        Complete property management services including maintenance, tenant relations, financial reporting, and asset optimization.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-20 bg-gradient-to-r from-blue-600 to-purple-600">
    <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
            Ready to Work With Us?
        </h2>
        <p class="text-xl text-blue-100 mb-8">
            Whether you're buying, selling, or investing, our team is ready to help you achieve your real estate goals.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('contact') }}" 
               class="bg-white text-blue-600 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-gray-100 transition-all duration-300 transform hover:scale-105">
                Get in Touch
            </a>
            <a href="{{ route('properties.index') }}" 
               class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-white hover:text-blue-600 transition-all duration-300">
                View Properties
            </a>
        </div>
    </div>
</section>

@endsection