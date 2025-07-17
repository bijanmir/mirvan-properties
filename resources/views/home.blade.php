@extends('layouts.app')

@section('title', 'Mirvan Properties - Premium Real Estate')

@section('content')
<!-- Hero Section -->
<section class="relative h-screen flex items-center justify-center bg-gradient-to-r from-blue-900 via-blue-800 to-purple-800 overflow-hidden">
    <!-- Background Video/Image -->
    <div class="absolute inset-0 bg-black opacity-40"></div>
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80')"></div>
    
    <!-- Hero Content -->
    <div class="relative z-10 text-center text-white px-4 sm:px-6 lg:px-8">
        <h1 class="text-5xl md:text-7xl font-bold mb-6 leading-tight">
            Premium Real Estate
            <span class="block text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400">
                Redefined
            </span>
        </h1>
        <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto leading-relaxed">
            Discover exceptional commercial and residential properties with Mirvan Properties. 
            Your gateway to premium real estate investments.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('properties.index') }}" 
               class="bg-white text-blue-900 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-gray-100 transition-all duration-300 transform hover:scale-105">
                Browse Properties
            </a>
            <a href="{{ route('submissions.create') }}" 
               class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-white hover:text-blue-900 transition-all duration-300">
                List Your Property
            </a>
        </div>
    </div>
    
    <!-- Scroll indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 text-white animate-bounce">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
        </svg>
    </div>
</section>

<!-- Featured Properties Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                Featured Properties
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Handpicked premium properties that represent the best in luxury real estate
            </p>
        </div>
        
        @if($featuredProperties->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($featuredProperties as $property)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 group">
                        <div class="relative overflow-hidden">
                            <img src="{{ $property->getMainImage() }}" 
                                 alt="{{ $property->title }}" 
                                 class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute top-4 left-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $property->getStatusBadgeClass() }}">
                                    {{ $property->getStatusLabel() }}
                                </span>
                            </div>
                            <div class="absolute top-4 right-4">
                                <span class="bg-white bg-opacity-90 text-gray-900 px-3 py-1 rounded-full text-sm font-semibold">
                                    {{ $property->getPropertyTypeLabel() }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">
                                {{ $property->title }}
                            </h3>
                            <p class="text-gray-600 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ $property->city }}, {{ $property->state }}
                            </p>
                            
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-2xl font-bold text-blue-600">
                                    {{ 'Contact for Price' }}
                                </span>
                                @if($property->square_footage)
                                    <span class="text-gray-500 text-sm">
                                        {{ number_format($property->square_footage) }} sq ft
                                    </span>
                                @endif
                            </div>
                            
                            @if($property->bedrooms || $property->bathrooms)
                                <div class="flex items-center space-x-4 text-gray-600 text-sm mb-4">
                                    @if($property->bedrooms)
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2v0" />
                                            </svg>
                                            {{ $property->bedrooms }} bed{{ $property->bedrooms > 1 ? 's' : '' }}
                                        </span>
                                    @endif
                                    @if($property->bathrooms)
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                            </svg>
                                            {{ $property->bathrooms }} bath{{ $property->bathrooms > 1 ? 's' : '' }}
                                        </span>
                                    @endif
                                </div>
                            @endif
                            
                            <a href="{{ route('properties.show', $property) }}" 
                               class="block w-full bg-blue-600 text-white text-center py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                                View Details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="text-center mt-12">
                <a href="{{ route('properties.index') }}" 
                   class="inline-flex items-center bg-blue-600 text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-blue-700 transition-colors">
                    View All Properties
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        @else
            <div class="text-center py-16">
                <div class="max-w-md mx-auto">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No featured properties</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by adding some properties to feature.</p>
                </div>
            </div>
        @endif
    </div>
</section>

<!-- Services Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                Our Services
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Comprehensive real estate solutions tailored to your needs
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Commercial Properties -->
            <div class="text-center group">
                <div class="bg-blue-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6 group-hover:bg-blue-200 transition-colors">
                    <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Commercial Properties</h3>
                <p class="text-gray-600">
                    Premium office spaces, retail locations, and commercial developments for your business needs.
                </p>
            </div>
            
            <!-- Residential Properties -->
            <div class="text-center group">
                <div class="bg-purple-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6 group-hover:bg-purple-200 transition-colors">
                    <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m0 0h3m0 0h3m0 0a1 1 0 001-1V10M9 21v-6a1 1 0 011-1h2a1 1 0 011 1v6" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Residential Properties</h3>
                <p class="text-gray-600">
                    Luxury homes, condos, and residential developments in prime locations.
                </p>
            </div>
            
            <!-- Investment Opportunities -->
            <div class="text-center group">
                <div class="bg-green-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6 group-hover:bg-green-200 transition-colors">
                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Investment Opportunities</h3>
                <p class="text-gray-600">
                    Strategic investment properties with strong potential for appreciation and returns.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Latest Blog Posts -->
@if($latestPosts->count() > 0)
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                Latest News & Insights
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Stay informed with the latest real estate trends and market insights
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($latestPosts as $post)
                <article class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 group">
                    @if($post->featured_image_url)
                        <div class="relative overflow-hidden">
                            <img src="{{ $post->featured_image_url }}" 
                                 alt="{{ $post->featured_image_alt ?? $post->title }}" 
                                 class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                    @endif
                    
                    <div class="p-6">
                        <div class="flex items-center text-sm text-gray-500 mb-3">
                            <time datetime="{{ $post->published_at->toDateString() }}">
                                {{ $post->formatted_published_date }}
                            </time>
                            @if($post->read_time)
                                <span class="mx-2">•</span>
                                <span>{{ $post->read_time_text }}</span>
                            @endif
                        </div>
                        
                        <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-blue-600 transition-colors">
                            <a href="{{ route('blog.show', $post) }}">
                                {{ $post->title }}
                            </a>
                        </h3>
                        
                        @if($post->excerpt)
                            <p class="text-gray-600 mb-4">
                                {{ $post->excerpt }}
                            </p>
                        @endif
                        
                        <a href="{{ route('blog.show', $post) }}" 
                           class="inline-flex items-center text-blue-600 font-semibold hover:text-blue-700 transition-colors">
                            Read More
                            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('blog.index') }}" 
               class="inline-flex items-center bg-blue-600 text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-blue-700 transition-colors">
                View All Articles
                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-r from-blue-600 to-purple-600">
    <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
            Ready to Find Your Perfect Property?
        </h2>
        <p class="text-xl text-blue-100 mb-8">
            Let us help you discover exceptional real estate opportunities that match your vision and investment goals.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('properties.index') }}" 
               class="bg-white text-blue-600 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-gray-100 transition-all duration-300 transform hover:scale-105">
                Browse Properties
            </a>
            <a href="{{ route('contact') }}" 
               class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-white hover:text-blue-600 transition-all duration-300">
                Contact Us Today
            </a>
        </div>
    </div>
</section>

@endsection