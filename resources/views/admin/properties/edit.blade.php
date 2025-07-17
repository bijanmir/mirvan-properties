@extends('layouts.app')

@section('title', isset($property) ? 'Edit Property - Admin Panel' : 'Add New Property - Admin Panel')

@section('content')
<!-- Admin Header -->
<section class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    {{ isset($property) ? 'Edit Property' : 'Add New Property' }}
                </h1>
                <p class="text-gray-600">
                    {{ isset($property) ? 'Update property information and settings' : 'Create a new property listing' }}
                </p>
            </div>
            <a href="{{ route('admin.properties.index') }}" 
               class="bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-700 transition-colors">
                Back to Properties
            </a>
        </div>
    </div>
</section>

<!-- Form Section -->
<section class="py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" 
              action="{{ isset($property) ? route('admin.properties.update', $property) : route('admin.properties.store') }}" 
              enctype="multipart/form-data"
              class="space-y-8">
            @csrf
            @if(isset($property))
                @method('PUT')
            @endif

            <!-- Basic Information -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Basic Information</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Property Title *</label>
                        <input type="text" 
                               id="title" 
                               name="title" 
                               required
                               value="{{ old('title', $property->title ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Type -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Property Type *</label>
                        <select id="type" name="type" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Type</option>
                            <option value="residential" {{ old('type', $property->type ?? '') == 'residential' ? 'selected' : '' }}>Residential</option>
                            <option value="commercial" {{ old('type', $property->type ?? '') == 'commercial' ? 'selected' : '' }}>Commercial</option>
                            <option value="retail" {{ old('type', $property->type ?? '') == 'retail' ? 'selected' : '' }}>Retail</option>
                            <option value="office" {{ old('type', $property->type ?? '') == 'office' ? 'selected' : '' }}>Office</option>
                            <option value="industrial" {{ old('type', $property->type ?? '') == 'industrial' ? 'selected' : '' }}>Industrial</option>
                            <option value="land" {{ old('type', $property->type ?? '') == 'land' ? 'selected' : '' }}>Land</option>
                        </select>
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                        <select id="status" name="status" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Status</option>
                            <option value="for_sale" {{ old('status', $property->status ?? '') == 'for_sale' ? 'selected' : '' }}>For Sale</option>
                            <option value="for_lease" {{ old('status', $property->status ?? '') == 'for_lease' ? 'selected' : '' }}>For Lease</option>
                            <option value="sold" {{ old('status', $property->status ?? '') == 'sold' ? 'selected' : '' }}>Sold</option>
                            <option value="leased" {{ old('status', $property->status ?? '') == 'leased' ? 'selected' : '' }}>Leased</option>
                        </select>
                    </div>

                    <!-- Price -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Price *</label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-500">$</span>
                            <input type="number" 
                                   id="price" 
                                   name="price" 
                                   required
                                   step="0.01"
                                   min="0"
                                   value="{{ old('price', $property->price ?? '') }}"
                                   class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <!-- Square Footage -->
                    <div>
                        <label for="square_footage" class="block text-sm font-medium text-gray-700 mb-2">Square Footage</label>
                        <input type="number" 
                               id="square_footage" 
                               name="square_footage"
                               min="0"
                               value="{{ old('square_footage', $property->square_footage ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                        <textarea id="description" 
                                  name="description" 
                                  required
                                  rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('description', $property->description ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Location -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Location</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Address -->
                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Street Address *</label>
                        <input type="text" 
                               id="address" 
                               name="address" 
                               required
                               value="{{ old('address', $property->address ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- City -->
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-2">City *</label>
                        <input type="text" 
                               id="city" 
                               name="city" 
                               required
                               value="{{ old('city', $property->city ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- State -->
                    <div>
                        <label for="state" class="block text-sm font-medium text-gray-700 mb-2">State *</label>
                        <input type="text" 
                               id="state" 
                               name="state" 
                               required
                               value="{{ old('state', $property->state ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Postal Code -->
                    <div>
                        <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-2">Postal Code *</label>
                        <input type="text" 
                               id="postal_code" 
                               name="postal_code" 
                               required
                               value="{{ old('postal_code', $property->postal_code ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Country -->
                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                        <input type="text" 
                               id="country" 
                               name="country"
                               value="{{ old('country', $property->country ?? 'USA') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            </div>

            <!-- Property Details -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Property Details</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Bedrooms -->
                    <div>
                        <label for="bedrooms" class="block text-sm font-medium text-gray-700 mb-2">Bedrooms</label>
                        <input type="number" 
                               id="bedrooms" 
                               name="bedrooms"
                               min="0"
                               value="{{ old('bedrooms', $property->bedrooms ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Bathrooms -->
                    <div>
                        <label for="bathrooms" class="block text-sm font-medium text-gray-700 mb-2">Bathrooms</label>
                        <input type="number" 
                               id="bathrooms" 
                               name="bathrooms"
                               min="0"
                               step="0.5"
                               value="{{ old('bathrooms', $property->bathrooms ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Parking Spaces -->
                    <div>
                        <label for="parking_spaces" class="block text-sm font-medium text-gray-700 mb-2">Parking Spaces</label>
                        <input type="number" 
                               id="parking_spaces" 
                               name="parking_spaces"
                               min="0"
                               value="{{ old('parking_spaces', $property->parking_spaces ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Year Built -->
                    <div>
                        <label for="year_built" class="block text-sm font-medium text-gray-700 mb-2">Year Built</label>
                        <input type="number" 
                               id="year_built" 
                               name="year_built"
                               min="1800"
                               max="{{ date('Y') }}"
                               value="{{ old('year_built', $property->year_built ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <!-- Features -->
                <div class="mt-6">
                    <label for="features" class="block text-sm font-medium text-gray-700 mb-2">Features & Amenities</label>
                    <textarea id="features" 
                              name="features"
                              rows="4"
                              placeholder="Enter one feature per line"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('features', isset($property) && $property->features ? implode("\n", $property->features) : '') }}</textarea>
                    <p class="text-sm text-gray-500 mt-1">Enter one feature per line</p>
                </div>
            </div>

            <!-- Images -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Images</h3>
                
                @if(isset($property) && $property->images->count() > 0)
                    <!-- Existing Images -->
                    <div class="mb-6">
                        <h4 class="text-md font-medium text-gray-900 mb-4">Current Images</h4>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($property->images as $image)
                                <div class="relative group">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" 
                                         alt="{{ $image->alt_text }}"
                                         class="w-full h-32 object-cover rounded-lg">
                                    @if($image->is_primary)
                                        <div class="absolute top-2 left-2">
                                            <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded">Primary</span>
                                        </div>
                                    @endif
                                    <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <form method="POST" action="{{ route('admin.properties.images.destroy', $image) }}" 
                                              class="inline"
                                              onsubmit="return confirm('Are you sure you want to delete this image?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-600 text-white p-1 rounded hover:bg-red-700">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Upload New Images -->
                <div>
                    <label for="images" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ isset($property) ? 'Add More Images' : 'Upload Images' }}
                    </label>
                    <input type="file" 
                           id="images" 
                           name="images[]"
                           multiple
                           accept="image/*"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <p class="text-sm text-gray-500 mt-1">
                        Select multiple images. Maximum 5MB per image. Supported formats: JPEG, PNG, JPG, GIF.
                        @unless(isset($property))
                            The first image will be set as the primary image.
                        @endunless
                    </p>
                </div>
            </div>

            <!-- SEO & Settings -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">SEO & Settings</h3>
                
                <div class="space-y-6">
                    <!-- Meta Description -->
                    <div>
                        <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-2">Meta Description</label>
                        <textarea id="meta_description" 
                                  name="meta_description"
                                  rows="3"
                                  maxlength="160"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('meta_description', $property->meta_description ?? '') }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">Recommended: 150-160 characters</p>
                    </div>

                    <!-- Meta Keywords -->
                    <div>
                        <label for="meta_keywords" class="block text-sm font-medium text-gray-700 mb-2">Meta Keywords</label>
                        <input type="text" 
                               id="meta_keywords" 
                               name="meta_keywords"
                               value="{{ old('meta_keywords', $property->meta_keywords ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <p class="text-sm text-gray-500 mt-1">Separate keywords with commas</p>
                    </div>

                    <!-- Settings -->
                    <div class="flex items-center space-x-8">
                        <!-- Featured -->
                        <div class="flex items-center">
                            <input type="hidden" name="is_featured" value="0">
                            <input type="checkbox" 
                                   id="is_featured" 
                                   name="is_featured" 
                                   value="1"
                                   {{ old('is_featured', $property->is_featured ?? false) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="is_featured" class="ml-2 block text-sm text-gray-900">
                                Featured Property
                            </label>
                        </div>

                        <!-- Active -->
                        <div class="flex items-center">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" 
                                   id="is_active" 
                                   name="is_active" 
                                   value="1"
                                   {{ old('is_active', $property->is_active ?? true) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="is_active" class="ml-2 block text-sm text-gray-900">
                                Active (Visible on Site)
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-between">
                <a href="{{ route('admin.properties.index') }}" 
                   class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-400 transition-colors">
                    Cancel
                </a>
                
                <div class="flex items-center space-x-4">
                    @if(isset($property))
                        <!-- Preview Property -->
                        <a href="{{ route('properties.show', $property) }}" 
                           target="_blank"
                           class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                            Preview Property
                        </a>
                    @endif
                    
                    <button type="submit" 
                            class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                        {{ isset($property) ? 'Update Property' : 'Create Property' }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>

@endsection

@push('scripts')
<script>
    // Auto-generate slug from title (optional enhancement)
    document.getElementById('title').addEventListener('input', function() {
        // You could add slug generation logic here if you want to add a slug field
    });

    // File upload preview (optional enhancement)
    document.getElementById('images').addEventListener('change', function(e) {
        const files = e.target.files;
        if (files.length > 0) {
            console.log(`${files.length} image(s) selected for upload`);
        }
    });
</script>
@endpush