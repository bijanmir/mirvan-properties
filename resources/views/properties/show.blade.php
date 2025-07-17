@extends('layouts.app')

@section('title', $property->title . ' - Mirvan Properties')
@section('meta_description', $property->meta_description ?: Str::limit($property->description, 160))

@section('content')
<!-- Property Hero Section -->
<section class="relative">
    @if($property->images->count() > 0)
        <!-- Image Gallery -->
        <div class="relative h-96 md:h-[500px] bg-gray-200" x-data="{ currentImage: 0, images: {{ $property->images->toJson() }} }">
            <!-- Main Image -->
            <div class="relative h-full overflow-hidden">
                <template x-for="(image, index) in images" :key="image.id">
                    <img :src="image.image_url" 
                         :alt="image.alt_text || '{{ $property->title }}'"
                         x-show="currentImage === index"
                         class="absolute inset-0 w-full h-full object-cover transition-opacity duration-500">
                </template>
                
                <!-- Navigation Arrows -->
                <template x-if="images.length > 1">
                    <div>
                        <button @click="currentImage = currentImage > 0 ? currentImage - 1 : images.length - 1"
                                class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-80 hover:bg-opacity-100 p-2 rounded-full shadow-lg transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <button @click="currentImage = currentImage < images.length - 1 ? currentImage + 1 : 0"
                                class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-80 hover:bg-opacity-100 p-2 rounded-full shadow-lg transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </template>
                
                <!-- Image Counter -->
                <template x-if="images.length > 1">
                    <div class="absolute bottom-4 right-4 bg-black bg-opacity-50 text-white px-3 py-1 rounded-full text-sm">
                        <span x-text="currentImage + 1"></span> / <span x-text="images.length"></span>
                    </div>
                </template>
            </div>
            
            <!-- Thumbnail Strip -->
            <template x-if="images.length > 1">
                <div class="absolute bottom-4 left-4 flex space-x-2 max-w-md overflow-x-auto">
                    <template x-for="(image, index) in images.slice(0, 5)" :key="image.id">
                        <button @click="currentImage = index"
                                :class="currentImage === index ? 'ring-2 ring-white' : 'ring-1 ring-white ring-opacity-50'"
                                class="flex-shrink-0 w-16 h-12 rounded overflow-hidden transition-all">
                            <img :src="image.image_url" 
                                 :alt="image.alt_text"
                                 class="w-full h-full object-cover">
                        </button>
                    </template>
                    <template x-if="images.length > 5">
                        <div class="flex-shrink-0 w-16 h-12 bg-black bg-opacity-50 rounded flex items-center justify-center text-white text-xs">
                            +<span x-text="images.length - 5"></span>
                        </div>
                    </template>
                </div>
            </template>
        </div>
    @else
        <!-- Placeholder if no images -->
        <div class="h-96 md:h-[500px] bg-gray-200 flex items-center justify-center">
            <div class="text-center text-gray-500">
                <svg class="mx-auto h-16 w-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <p>No images available</p>
            </div>
        </div>
    @endif
    
    <!-- Property Status Badge -->
    <div class="absolute top-6 left-6">
        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium {{ $property->getStatusBadgeClass() }}">
            {{ $property->getStatusLabel() }}
        </span>
    </div>
    
    <!-- Property Type Badge -->
    <div class="absolute top-6 right-6">
        <span class="bg-white bg-opacity-90 text-gray-900 px-4 py-2 rounded-full text-sm font-semibold">
            {{ $property->getPropertyTypeLabel() }}
        </span>
    </div>
    
    @if($property->is_featured)
        <div class="absolute top-20 left-6">
            <span class="bg-yellow-400 text-yellow-900 px-3 py-1 rounded-full text-sm font-bold">
                FEATURED
            </span>
        </div>
    @endif
</section>

<!-- Property Details -->
<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Property Header -->
                <div class="mb-8">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        {{ $property->title }}
                    </h1>
                    
                    <div class="flex items-center text-gray-600 mb-4">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ $property->full_address }}
                    </div>
                    
                    <div class="text-3xl font-bold text-blue-600 mb-6">
                        {{ $property->getFormattedPrice() }}
                        @if($property->status === 'for_lease')
                            <span class="text-lg text-gray-500">/ month</span>
                        @endif
                    </div>
                </div>
                
                <!-- Property Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8 p-6 bg-gray-50 rounded-lg">
                    @if($property->square_footage)
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">{{ number_format($property->square_footage) }}</div>
                            <div class="text-sm text-gray-600">Square Feet</div>
                        </div>
                    @endif
                    
                    @if($property->bedrooms)
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">{{ $property->bedrooms }}</div>
                            <div class="text-sm text-gray-600">Bedroom{{ $property->bedrooms > 1 ? 's' : '' }}</div>
                        </div>
                    @endif
                    
                    @if($property->bathrooms)
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">{{ $property->bathrooms }}</div>
                            <div class="text-sm text-gray-600">Bathroom{{ $property->bathrooms > 1 ? 's' : '' }}</div>
                        </div>
                    @endif
                    
                    @if($property->parking_spaces)
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">{{ $property->parking_spaces }}</div>
                            <div class="text-sm text-gray-600">Parking Space{{ $property->parking_spaces > 1 ? 's' : '' }}</div>
                        </div>
                    @endif
                    
                    @if($property->year_built)
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">{{ $property->year_built }}</div>
                            <div class="text-sm text-gray-600">Year Built</div>
                        </div>
                    @endif
                </div>
                
                <!-- Description -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Description</h2>
                    <div class="prose prose-lg text-gray-600">
                        {!! nl2br(e($property->description)) !!}
                    </div>
                </div>
                
                <!-- Features -->
                @if($property->features && count($property->features) > 0)
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Features & Amenities</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($property->features as $feature)
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-gray-700">{{ $feature }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <!-- Map Placeholder -->
                @if($property->latitude && $property->longitude)
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Location</h2>
                        <div class="bg-gray-200 h-64 rounded-lg flex items-center justify-center">
                            <p class="text-gray-600">Map placeholder ({{ $property->latitude }}, {{ $property->longitude }})</p>
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Contact Form -->
                <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Interested in this property?</h3>
                    
                    <form action="{{ route('properties.inquiry', $property) }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                            <input type="text" id="name" name="name" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   value="{{ old('name') }}">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                            <input type="email" id="email" name="email" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   value="{{ old('email') }}">
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                            <input type="tel" id="phone" name="phone"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   value="{{ old('phone') }}">
                            @error('phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message *</label>
                            <textarea id="message" name="message" rows="4" required
                                      placeholder="I'm interested in learning more about this property..."
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-md font-semibold hover:bg-blue-700 transition-colors">
                            Send Inquiry
                        </button>
                    </form>
                    
                    @if(session('success'))
                        <div class="mt-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="mt-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>
                
                <!-- Property Details Card -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h4 class="font-semibold text-gray-900 mb-4">Property Details</h4>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Property ID:</span>
                            <span class="font-medium">#{{ $property->id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Type:</span>
                            <span class="font-medium">{{ $property->getPropertyTypeLabel() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status:</span>
                            <span class="font-medium">{{ $property->getStatusLabel() }}</span>
                        </div>
                        @if($property->square_footage)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Square Footage:</span>
                                <span class="font-medium">{{ number_format($property->square_footage) }} sq ft</span>
                            </div>
                        @endif
                        @if($property->year_built)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Year Built:</span>
                                <span class="font-medium">{{ $property->year_built }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-gray-600">Views:</span>
                            <span class="font-medium">{{ $property->views }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Properties -->
@if($relatedProperties->count() > 0)
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-8">Similar Properties</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($relatedProperties as $relatedProperty)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                        <div class="relative">
                            <img src="{{ $relatedProperty->getMainImage() }}" 
                                 alt="{{ $relatedProperty->title }}" 
                                 class="w-full h-48 object-cover">
                            
                            <div class="absolute top-3 left-3">
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium {{ $relatedProperty->getStatusBadgeClass() }}">
                                    {{ $relatedProperty->getStatusLabel() }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-900 mb-2">
                                <a href="{{ route('properties.show', $relatedProperty) }}" class="hover:text-blue-600">
                                    {{ $relatedProperty->title }}
                                </a>
                            </h3>
                            
                            <p class="text-gray-600 text-sm mb-3">
                                {{ $relatedProperty->city }}, {{ $relatedProperty->state }}
                            </p>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-blue-600">
                                    {{ $relatedProperty->getFormattedPrice() }}
                                </span>
                                @if($relatedProperty->square_footage)
                                    <span class="text-gray-500 text-sm">
                                        {{ number_format($relatedProperty->square_footage) }} sq ft
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

@endsection