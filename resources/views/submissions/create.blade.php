@extends('layouts.app')

@section('title', 'Submit Property')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-6">Submit Your Property</h1>
            <p class="text-gray-600 mb-8">Fill out the form below to submit your property for review. Our team will review your submission and contact you shortly.</p>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('submissions.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- Property Information --}}
                <div class="border-b border-gray-200 pb-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Property Information</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Property Title *</label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Beautiful 3BR Family Home" required>
                        </div>

                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address *</label>
                            <input type="text" id="address" name="address" value="{{ old('address') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="123 Main Street" required>
                        </div>

                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 mb-2">City *</label>
                            <input type="text" id="city" name="city" value="{{ old('city') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="San Francisco" required>
                        </div>

                        <div>
                            <label for="state" class="block text-sm font-medium text-gray-700 mb-2">State *</label>
                            <input type="text" id="state" name="state" value="{{ old('state') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="California" required>
                        </div>

                        <div>
                            <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-2">Postal Code *</label>
                            <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="94102" required>
                        </div>

                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Price *</label>
                            <input type="number" id="price" name="price" value="{{ old('price') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="500000" min="0" step="1000" required>
                        </div>

                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Property Type *</label>
                            <select id="type" name="type" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                <option value="">Select Property Type</option>
                                <option value="residential" {{ old('type') == 'residential' ? 'selected' : '' }}>Residential (House/Apartment)</option>
                                <option value="commercial" {{ old('type') == 'commercial' ? 'selected' : '' }}>Commercial</option>
                                <option value="retail" {{ old('type') == 'retail' ? 'selected' : '' }}>Retail</option>
                                <option value="office" {{ old('type') == 'office' ? 'selected' : '' }}>Office</option>
                                <option value="industrial" {{ old('type') == 'industrial' ? 'selected' : '' }}>Industrial</option>
                                <option value="land" {{ old('type') == 'land' ? 'selected' : '' }}>Land</option>
                            </select>
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Listing Type *</label>
                            <select id="status" name="status" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                <option value="">Select Listing Type</option>
                                <option value="for_sale" {{ old('status') == 'for_sale' ? 'selected' : '' }}>For Sale</option>
                                <option value="for_lease" {{ old('status') == 'for_lease' ? 'selected' : '' }}>For Lease</option>
                            </select>
                        </div>

                        <div>
                            <label for="bedrooms" class="block text-sm font-medium text-gray-700 mb-2">Bedrooms</label>
                            <input type="number" id="bedrooms" name="bedrooms" value="{{ old('bedrooms') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   min="0" max="20">
                        </div>

                        <div>
                            <label for="bathrooms" class="block text-sm font-medium text-gray-700 mb-2">Bathrooms</label>
                            <input type="number" id="bathrooms" name="bathrooms" value="{{ old('bathrooms') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   min="0" max="20">
                        </div>

                        <div class="md:col-span-2">
                            <label for="square_footage" class="block text-sm font-medium text-gray-700 mb-2">Square Footage</label>
                            <input type="number" id="square_footage" name="square_footage" value="{{ old('square_footage') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   min="0" step="1" placeholder="2500">
                        </div>

                        <div>
                            <label for="parking_spaces" class="block text-sm font-medium text-gray-700 mb-2">Parking Spaces</label>
                            <input type="number" id="parking_spaces" name="parking_spaces" value="{{ old('parking_spaces') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   min="0" max="20">
                        </div>

                        <div>
                            <label for="year_built" class="block text-sm font-medium text-gray-700 mb-2">Year Built</label>
                            <input type="number" id="year_built" name="year_built" value="{{ old('year_built') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   min="1800" max="{{ date('Y') + 1 }}" placeholder="2020">
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Property Description *</label>
                        <textarea id="description" name="description" rows="4" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Describe your property in detail..." required>{{ old('description') }}</textarea>
                    </div>

                    <div class="mt-6">
                        <label for="features" class="block text-sm font-medium text-gray-700 mb-2">Additional Features</label>
                        <textarea id="features" name="features" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Pool, garage, garden, fireplace, etc. (separate with commas)">{{ old('features') }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">Enter features separated by commas</p>
                    </div>
                </div>

                {{-- Images --}}
                <div class="border-b border-gray-200 pb-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Property Images</h2>
                    <div>
                        <label for="images" class="block text-sm font-medium text-gray-700 mb-2">Upload Images</label>
                        <input type="file" id="images" name="images[]" multiple accept="image/*"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <p class="text-sm text-gray-500 mt-2">You can select multiple images. Supported formats: JPG, PNG, GIF. Max size: 2MB per image.</p>
                    </div>
                </div>

                {{-- Contact Information --}}
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Contact Information</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="contact_name" class="block text-sm font-medium text-gray-700 mb-2">Contact Name *</label>
                            <input type="text" id="contact_name" name="contact_name" value="{{ old('contact_name', Auth::user()->name ?? '') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   required>
                        </div>

                        <div>
                            <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-2">Contact Email *</label>
                            <input type="email" id="contact_email" name="contact_email" value="{{ old('contact_email', Auth::user()->email ?? '') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   required>
                        </div>

                        <div class="md:col-span-2">
                            <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-2">Contact Phone *</label>
                            <input type="tel" id="contact_phone" name="contact_phone" value="{{ old('contact_phone') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="+1 (555) 123-4567" required>
                        </div>
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="flex justify-end pt-6">
                    <button type="button" onclick="window.history.back()" 
                            class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg mr-4">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg">
                        Submit Property
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection