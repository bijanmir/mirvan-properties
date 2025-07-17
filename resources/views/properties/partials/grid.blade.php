@if($properties->count() > 0)
    <!-- Results Count -->
    <div class="flex justify-between items-center mb-8">
        <p class="text-gray-600">
            Showing {{ $properties->firstItem() }} to {{ $properties->lastItem() }} of {{ $properties->total() }} properties
        </p>
    </div>

    <!-- Properties Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
        @foreach($properties as $property)
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 group">
                <div class="relative overflow-hidden">
                    <img src="{{ Storage::url($property->getMainImage()) }}" 
                         alt="{{ $property->title }}" 
                         class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500"
                         loading="lazy">
                    
                    <!-- Status Badge -->
                    <div class="absolute top-4 left-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $property->getStatusBadgeClass() }}">
                            {{ $property->getStatusLabel() }}
                        </span>
                    </div>
                    
                    <!-- Property Type Badge -->
                    <div class="absolute top-4 right-4">
                        <span class="bg-white bg-opacity-90 text-gray-900 px-3 py-1 rounded-full text-sm font-semibold">
                            {{ $property->getPropertyTypeLabel() }}
                        </span>
                    </div>
                    
                    <!-- Featured Badge -->
                    @if($property->is_featured)
                        <div class="absolute bottom-4 left-4">
                            <span class="bg-yellow-400 text-yellow-900 px-2 py-1 rounded-full text-xs font-bold">
                                FEATURED
                            </span>
                        </div>
                    @endif
                </div>
                
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">
                        <a href="{{ route('properties.show', $property) }}">
                            {{ $property->title }}
                        </a>
                    </h3>
                    
                    <!-- Location -->
                    <p class="text-gray-600 mb-3 flex items-center">
                        <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ $property->city }}, {{ $property->state }}
                    </p>
                    
                    <!-- Price and Square Footage -->
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-2xl font-bold text-blue-600">
                            {{ $property->getFormattedPrice() ?? 'Contact for Price'}}
                        </span>
                        @if($property->square_footage)
                            <span class="text-gray-500 text-sm">
                                {{ number_format($property->square_footage) }} sq ft
                            </span>
                        @endif
                    </div>
                    
                    <!-- Property Details -->
                    @if($property->bedrooms || $property->bathrooms || $property->parking_spaces)
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10v11M20 10v11" />
                                    </svg>
                                    {{ $property->bathrooms }} bath{{ $property->bathrooms > 1 ? 's' : '' }}
                                </span>
                            @endif
                            
                            @if($property->parking_spaces)
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $property->parking_spaces }} parking
                                </span>
                            @endif
                        </div>
                    @endif
                    
                    <!-- Description -->
                    @if($property->description)
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                            {{ Str::limit($property->description, 120) }}
                        </p>
                    @endif
                    
                    <!-- Features -->
                    @if($property->features && count($property->features) > 0)
                        <div class="mb-4">
                            <div class="flex flex-wrap gap-1">
                                @foreach(array_slice($property->features, 0, 3) as $feature)
                                    <span class="inline-block bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded">
                                        {{ $feature }}
                                    </span>
                                @endforeach
                                @if(count($property->features) > 3)
                                    <span class="inline-block bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded">
                                        +{{ count($property->features) - 3 }} more
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif
                    
                    <!-- View Details Button -->
                    <a href="{{ route('properties.show', $property) }}" 
                       class="block w-full bg-blue-600 text-white text-center py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                        View Details
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($properties->hasPages())
        <div class="flex justify-center">
            <nav class="flex items-center space-x-1">
                {{-- Previous Page Link --}}
                @if ($properties->onFirstPage())
                    <span class="px-3 py-2 text-gray-500 bg-gray-100 rounded-md cursor-not-allowed">
                        Previous
                    </span>
                @else
                    <a href="{{ $properties->previousPageUrl() }}" 
                       class="px-3 py-2 text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors"
                       hx-get="{{ $properties->previousPageUrl() }}"
                       hx-target="#properties-grid"
                       hx-indicator="#loading-indicator">
                        Previous
                    </a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($properties->getUrlRange(1, $properties->lastPage()) as $page => $url)
                    @if ($page == $properties->currentPage())
                        <span class="px-3 py-2 text-white bg-blue-600 rounded-md">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" 
                           class="px-3 py-2 text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors"
                           hx-get="{{ $url }}"
                           hx-target="#properties-grid"
                           hx-indicator="#loading-indicator">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($properties->hasMorePages())
                    <a href="{{ $properties->nextPageUrl() }}" 
                       class="px-3 py-2 text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors"
                       hx-get="{{ $properties->nextPageUrl() }}"
                       hx-target="#properties-grid"
                       hx-indicator="#loading-indicator">
                        Next
                    </a>
                @else
                    <span class="px-3 py-2 text-gray-500 bg-gray-100 rounded-md cursor-not-allowed">
                        Next
                    </span>
                @endif
            </nav>
        </div>
    @endif

@else
    <!-- No Properties Found -->
    <div class="text-center py-16">
        <div class="max-w-md mx-auto">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">No properties found</h3>
            <p class="mt-2 text-sm text-gray-500">
                We couldn't find any properties matching your criteria. Try adjusting your filters.
            </p>
            <div class="mt-6">
                <button type="button" 
                        onclick="document.getElementById('property-filters').reset(); htmx.trigger('#property-filters', 'change')"
                        class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                    Clear All Filters
                </button>
            </div>
        </div>
    </div>
@endif

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush