@extends('layouts.app')

@section('title', 'Properties - Mirvan Properties')
@section('meta_description', 'Browse our premium collection of commercial and residential properties for sale and lease.')

@section('content')
<!-- Page Header -->
<section class="bg-gradient-to-r from-blue-600 to-purple-600 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center text-white">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                Premium Properties
            </h1>
            <p class="text-xl text-blue-100 max-w-2xl mx-auto">
                Discover exceptional real estate opportunities across commercial and residential sectors
            </p>
        </div>
    </div>
</section>

<!-- Filters Section -->
<section class="bg-white shadow-lg relative z-10 -mt-8 mx-4 sm:mx-6 lg:mx-8 rounded-lg">
    <div class="max-w-7xl mx-auto px-6 py-8">
        <form id="property-filters" 
              hx-get="{{ route('properties.filter') }}" 
              hx-target="#properties-grid" 
              hx-trigger="change, input delay:500ms"
              hx-indicator="#loading-indicator"
              class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
            
            <!-- Property Type -->
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Property Type</label>
                <select name="type" id="type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All Types</option>
                    @foreach($propertyTypes as $type)
                        <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $type)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" id="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All Status</option>
                    <option value="for_sale" {{ request('status') == 'for_sale' ? 'selected' : '' }}>For Sale</option>
                    <option value="for_lease" {{ request('status') == 'for_lease' ? 'selected' : '' }}>For Lease</option>
                </select>
            </div>

            <!-- Location -->
            <div>
                <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                <input type="text" 
                       name="location" 
                       id="location" 
                       value="{{ request('location') }}"
                       placeholder="City or State"
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <!-- Price Range -->
            <div>
                <label for="min_price" class="block text-sm font-medium text-gray-700 mb-2">Min Price</label>
                <input type="number" 
                       name="min_price" 
                       id="min_price" 
                       value="{{ request('min_price') }}"
                       placeholder="$0"
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label for="max_price" class="block text-sm font-medium text-gray-700 mb-2">Max Price</label>
                <input type="number" 
                       name="max_price" 
                       id="max_price" 
                       value="{{ request('max_price') }}"
                       placeholder="Any"
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <!-- Sort -->
            <div>
                <label for="sort" class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                <select name="sort" id="sort" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="featured" {{ request('sort') == 'featured' ? 'selected' : '' }}>Featured First</option>
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                </select>
            </div>
        </form>

        <!-- Additional Filters (Expandable) -->
        <div class="mt-6" x-data="{ showMore: false }">
            <button @click="showMore = !showMore" 
                    class="text-blue-600 hover:text-blue-700 font-medium text-sm flex items-center">
                <span x-text="showMore ? 'Less Filters' : 'More Filters'"></span>
                <svg class="ml-1 w-4 h-4 transform transition-transform" :class="{ 'rotate-180': showMore }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            
            <div x-show="showMore" x-transition class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                <div>
                    <label for="min_sqft" class="block text-sm font-medium text-gray-700 mb-2">Min Sq Ft</label>
                    <input type="number" 
                           name="min_sqft" 
                           id="min_sqft" 
                           value="{{ request('min_sqft') }}"
                           placeholder="0"
                           form="property-filters"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                
                <div>
                    <label for="bedrooms" class="block text-sm font-medium text-gray-700 mb-2">Min Bedrooms</label>
                    <select name="bedrooms" id="bedrooms" form="property-filters" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Any</option>
                        @for($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ request('bedrooms') == $i ? 'selected' : '' }}>
                                {{ $i }}{{ $i == 5 ? '+' : '' }}
                            </option>
                        @endfor
                    </select>
                </div>
                
                <div class="flex items-end">
                    <button type="button" 
                            onclick="document.getElementById('property-filters').reset(); htmx.trigger('#property-filters', 'change')"
                            class="bg-gray-100 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-200 transition-colors">
                        Clear Filters
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Properties Grid -->
<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Loading Indicator -->
        <div id="loading-indicator" class="htmx-indicator text-center py-8">
            <div class="inline-flex items-center">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Loading properties...
            </div>
        </div>

        <!-- Properties Grid Container -->
        <div id="properties-grid">
            @include('properties.partials.grid', ['properties' => $properties])
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    .htmx-indicator {
        display: none;
    }
    .htmx-request .htmx-indicator {
        display: block;
    }
    .htmx-request #properties-grid {
        opacity: 0.7;
    }
</style>
@endpush