@extends('layouts.app')

@section('title', 'Manage Properties - Admin Panel')

@section('content')
<!-- Admin Header -->
<section class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Manage Properties</h1>
                <p class="text-gray-600">Create, edit, and manage property listings</p>
            </div>
            <a href="{{ route('admin.properties.create') }}" 
               class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                Add New Property
            </a>
        </div>
    </div>
</section>

<!-- Filters and Search -->
<section class="bg-gray-50 border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <form method="GET" class="flex flex-col md:flex-row gap-4">
            <!-- Search -->
            <div class="flex-1">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Search properties..."
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            
            <!-- Status Filter -->
            <div class="md:w-48">
                <select name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All Status</option>
                    @foreach($statusOptions as $status)
                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Type Filter -->
            <div class="md:w-48">
                <select name="type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All Types</option>
                    @foreach($typeOptions as $type)
                        <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                            {{ ucfirst($type) }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Active Filter -->
            <div class="md:w-48">
                <select name="active" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Active & Inactive</option>
                    <option value="active" {{ request('active') == 'active' ? 'selected' : '' }}>Active Only</option>
                    <option value="inactive" {{ request('active') == 'inactive' ? 'selected' : '' }}>Inactive Only</option>
                </select>
            </div>
            
            <button type="submit" class="bg-gray-600 text-white px-6 py-2 rounded-md hover:bg-gray-700 transition-colors">
                Filter
            </button>
            
            @if(request()->hasAny(['search', 'status', 'type', 'active']))
                <a href="{{ route('admin.properties.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400 transition-colors">
                    Clear
                </a>
            @endif
        </form>
    </div>
</section>

<!-- Properties List -->
<section class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if($properties->count() > 0)
            <!-- Results Summary -->
            <div class="mb-6 flex items-center justify-between">
                <p class="text-gray-600">
                    Showing {{ $properties->firstItem() }} to {{ $properties->lastItem() }} of {{ $properties->total() }} properties
                </p>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-600">Sort by:</span>
                    <select onchange="location.href=this.value" class="text-sm border-gray-300 rounded">
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'order' => 'desc']) }}"
                                {{ request('sort') == 'created_at' && request('order') == 'desc' ? 'selected' : '' }}>
                            Newest First
                        </option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'title', 'order' => 'asc']) }}"
                                {{ request('sort') == 'title' && request('order') == 'asc' ? 'selected' : '' }}>
                            Title A-Z
                        </option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'price', 'order' => 'desc']) }}"
                                {{ request('sort') == 'price' && request('order') == 'desc' ? 'selected' : '' }}>
                            Price High-Low
                        </option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'price', 'order' => 'asc']) }}"
                                {{ request('sort') == 'price' && request('order') == 'asc' ? 'selected' : '' }}>
                            Price Low-High
                        </option>
                    </select>
                </div>
            </div>

            <!-- Properties Table -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Property
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Type & Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Price
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Location
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($properties as $property)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($property->getMainImage())
                                            <img src="{{ asset('storage/' . $property->getMainImage()) }}" 
                                                 alt="{{ $property->title }}"
                                                 class="w-12 h-12 rounded-lg object-cover mr-4">
                                        @else
                                            <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center mr-4">
                                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $property->title }}
                                                @if($property->is_featured)
                                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        Featured
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                ID: {{ $property->id }} • Created {{ $property->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $property->getPropertyTypeLabel() }}</div>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $property->getStatusBadgeClass() }}">
                                        {{ $property->getStatusLabel() }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $property->getFormattedPrice() }}
                                    </div>
                                    @if($property->square_footage)
                                        <div class="text-sm text-gray-500">
                                            {{ number_format($property->square_footage) }} sq ft
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $property->city }}, {{ $property->state }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($property->is_active)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                            Inactive
                                        </span>
                                    @endif
                                    <div class="text-xs text-gray-500 mt-1">
                                        {{ $property->views }} views
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('properties.show', $property) }}" 
                                           class="text-blue-600 hover:text-blue-900" target="_blank">View</a>
                                        <a href="{{ route('admin.properties.edit', $property) }}" 
                                           class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        
                                        <!-- Toggle Featured -->
                                        <form method="POST" action="{{ route('admin.properties.toggle-featured', $property) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="text-yellow-600 hover:text-yellow-900">
                                                {{ $property->is_featured ? 'Unfeature' : 'Feature' }}
                                            </button>
                                        </form>
                                        
                                        <!-- Delete -->
                                        <form method="POST" action="{{ route('admin.properties.destroy', $property) }}" 
                                              class="inline" 
                                              onsubmit="return confirm('Are you sure you want to delete this property?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($properties->hasPages())
                <div class="mt-6">
                    {{ $properties->appends(request()->query())->links() }}
                </div>
            @endif

        @else
            <!-- No Properties -->
            <div class="text-center py-16">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No properties found</h3>
                <p class="mt-2 text-sm text-gray-500">
                    @if(request()->hasAny(['search', 'status', 'type', 'active']))
                        No properties match your current filters. Try adjusting your search criteria.
                    @else
                        Get started by creating your first property listing.
                    @endif
                </p>
                <div class="mt-6">
                    @if(request()->hasAny(['search', 'status', 'type', 'active']))
                        <a href="{{ route('admin.properties.index') }}" 
                           class="bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-700 transition-colors mr-4">
                            Clear Filters
                        </a>
                    @endif
                    <a href="{{ route('admin.properties.create') }}" 
                       class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                        Add New Property
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>

@endsection