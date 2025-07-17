@extends('layouts.app')

@section('title', 'Edit Property Submission')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-900">Edit Property Submission</h1>
                <a href="{{ route('submissions.show', $submission) }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                    ← Back to Details
                </a>
            </div>

            {{-- Admin Notes Alert --}}
            @if($submission->admin_notes)
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">Admin Feedback:</h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <p>{{ $submission->admin_notes }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('submissions.update', $submission) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Property Information --}}
                <div class="border-b border-gray-200 pb-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Property Information</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Property Title *</label>
                            <input type="text" id="title" name="title" value="{{ old('title', $submission->title) }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Beautiful 3BR Family Home" required>
                        </div>

                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address *</label>
                            <input type="text" id="address" name="address" value="{{ old('address', $submission->address) }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="123 Main Street" required>
                        </div>

                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 mb-2">City *</label>
                            <input type="text" id="city" name="city" value="{{ old('city', $submission->city) }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="San Francisco" required>
                        </div>

                        <div>
                            <label for="state" class="block text-sm font-medium text-gray-700 mb-2">State *</label>
                            <input type="text" id="state" name="state" value="{{ old('state', $submission->state) }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="California" required>
                        </div>

                        <div>
                            <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-2">Postal Code *</label>
                            <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code', $submission->postal_code) }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="94102" required>
                        </div>

                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Price *</label>
                            <input type="number" id="price" name="price" value="{{ old('price', $submission->price) }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="500000" min="0" step="1000" required>
                        </div>

                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Property Type *</label>
                            <select id="type" name="type" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                <option value="">Select Property Type</option>
                                <option value="residential" {{ old('type', $submission->type) == 'residential' ? 'selected' : '' }}>Residential (House/Apartment)</option>
                                <option value="commercial" {{ old('type', $submission->type) == 'commercial' ? 'selected' : '' }}>Commercial</option>
                                <option value="retail" {{ old('type', $submission->type) == 'retail' ? 'selected' : '' }}>Retail</option>
                                <option value="office" {{ old('type', $submission->type) == 'office' ? 'selected' : '' }}>Office</option>
                                <option value="industrial" {{ old('type', $submission->type) == 'industrial' ? 'selected' : '' }}>Industrial</option>
                                <option value="land" {{ old('type', $submission->type) == 'land' ? 'selected' : '' }}>Land</option>
                            </select>
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Listing Type *</label>
                            <select id="status" name="status" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                <option value="">Select Listing Type</option>
                                <option value="for_sale" {{ old('status', $submission->status) == 'for_sale' ? 'selected' : '' }}>For Sale</option>
                                <option value="for_lease" {{ old('status', $submission->status) == 'for_lease' ? 'selected' : '' }}>For Lease</option>
                            </select>
                        </div>

                        <div>
                            <label for="bedrooms" class="block text-sm font-medium text-gray-700 mb-2">Bedrooms</label>
                            <input type="number" id="bedrooms" name="bedrooms" value="{{ old('bedrooms', $submission->bedrooms) }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   min="0" max="20">
                        </div>

                        <div>
                            <label for="bathrooms" class="block text-sm font-medium text-gray-700 mb-2">Bathrooms</label>
                            <input type="number" id="bathrooms" name="bathrooms" value="{{ old('bathrooms', $submission->bathrooms) }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   min="0" max="20">
                        </div>

                        <div>
                            <label for="square_footage" class="block text-sm font-medium text-gray-700 mb-2">Square Footage</label>
                            <input type="number" id="square_footage" name="square_footage" value="{{ old('square_footage', $submission->square_footage) }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   min="0" step="1" placeholder="2500">
                        </div>

                        <div>
                            <label for="parking_spaces" class="block text-sm font-medium text-gray-700 mb-2">Parking Spaces</label>
                            <input type="number" id="parking_spaces" name="parking_spaces" value="{{ old('parking_spaces', $submission->parking_spaces) }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   min="0" max="20">
                        </div>

                        <div>
                            <label for="year_built" class="block text-sm font-medium text-gray-700 mb-2">Year Built</label>
                            <input type="number" id="year_built" name="year_built" value="{{ old('year_built', $submission->year_built) }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   min="1800" max="{{ date('Y') + 1 }}" placeholder="2020">
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Property Description *</label>
                        <textarea id="description" name="description" rows="4" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Describe your property in detail..." required>{{ old('description', $submission->description) }}</textarea>
                    </div>

                    <div class="mt-6">
                        <label for="features" class="block text-sm font-medium text-gray-700 mb-2">Additional Features</label>
                        <textarea id="features" name="features" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Pool, garage, garden, fireplace, etc. (separate with commas)">{{ old('features', is_array($submission->features) ? implode(', ', $submission->features) : $submission->features) }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">Enter features separated by commas</p>
                    </div>
                </div>

                {{-- Current Images --}}
                @if($submission->images && count($submission->images) > 0)
                <div class="border-b border-gray-200 pb-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Current Images</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($submission->images as $image)
                            <div class="relative">
                                <img src="{{ Storage::url($image) }}" 
                                     alt="Property image" 
                                     class="w-full h-32 object-cover rounded-lg border">
                            </div>
                        @endforeach
                    </div>
                    <p class="text-sm text-gray-500 mt-2">To replace images, upload new ones below. Current images will be replaced.</p>
                </div>
                @endif

                {{-- New Images --}}
                <div class="border-b border-gray-200 pb-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Update Property Images</h2>
                    <div>
                        <label for="images" class="block text-sm font-medium text-gray-700 mb-2">Upload New Images</label>
                        <input type="file" id="images" name="images[]" multiple accept="image/*"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <p class="text-sm text-gray-500 mt-2">You can select multiple images. Supported formats: JPG, PNG, GIF. Max size: 2MB per image. Leave empty to keep current images.</p>
                    </div>
                </div>

                {{-- Contact Information --}}
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Contact Information</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="contact_name" class="block text-sm font-medium text-gray-700 mb-2">Contact Name *</label>
                            <input type="text" id="contact_name" name="contact_name" value="{{ old('contact_name', $submission->contact_name) }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   required>
                        </div>

                        <div>
                            <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-2">Contact Email *</label>
                            <input type="email" id="contact_email" name="contact_email" value="{{ old('contact_email', $submission->contact_email) }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   required>
                        </div>

                        <div class="md:col-span-2">
                            <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-2">Contact Phone *</label>
                            <input type="tel" id="contact_phone" name="contact_phone" value="{{ old('contact_phone', $submission->contact_phone) }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="+1 (555) 123-4567" required>
                        </div>
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="flex justify-end pt-6 space-x-4">
                    <a href="{{ route('submissions.show', $submission) }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg">
                        Update Submission
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection