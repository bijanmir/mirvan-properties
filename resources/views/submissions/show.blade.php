@extends('layouts.app')

@section('title', 'Submission Details')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        {{-- Header --}}
        <div class="flex justify-between items-start mb-8">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <h1 class="text-3xl font-bold text-gray-900">{{ $submission->title }}</h1>
                    <span class="px-3 py-1 rounded-full text-sm font-medium {{ $submission->getSubmissionStatusBadgeClass() }}">
                        {{ $submission->getSubmissionStatusLabel() }}
                    </span>
                </div>
                <p class="text-gray-600">Submitted on {{ $submission->created_at->format('F j, Y \a\t g:i A') }}</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('submissions.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                    ← Back to My Submissions
                </a>
                
                @if($submission->canBeEdited())
                    <a href="{{ route('submissions.edit', $submission) }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Edit Submission
                    </a>
                @endif
            </div>
        </div>

        {{-- Status Alert --}}
        @if($submission->submission_status === 'needs_revision' && $submission->admin_notes)
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">Revision Required</h3>
                        <div class="mt-2 text-sm text-yellow-700">
                            <p>{{ $submission->admin_notes }}</p>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('submissions.edit', $submission) }}" 
                               class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded text-sm">
                                Make Changes
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($submission->submission_status === 'rejected' && $submission->admin_notes)
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Submission Rejected</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <p>{{ $submission->admin_notes }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($submission->submission_status === 'approved')
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-green-800">Submission Approved!</h3>
                        <div class="mt-2 text-sm text-green-700">
                            <p>Congratulations! Your property submission has been approved and is now live on our website.</p>
                            @if($submission->property_id)
                                <div class="mt-3">
                                    <a href="{{ route('properties.show', $submission->property_id) }}" 
                                       class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm">
                                        View Live Property
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Property Information --}}
                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Property Information</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Property Type</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $submission->getPropertyTypeLabel() }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Listing Type</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $submission->getStatusLabel() }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Price</label>
                            <p class="mt-1 text-lg font-semibold text-gray-900">{{ $submission->formatted_price }}</p>
                        </div>
                        
                        @if($submission->square_footage)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Square Footage</label>
                            <p class="mt-1 text-sm text-gray-900">{{ number_format($submission->square_footage) }} sq ft</p>
                        </div>
                        @endif
                        
                        @if($submission->bedrooms)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Bedrooms</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $submission->bedrooms }}</p>
                        </div>
                        @endif
                        
                        @if($submission->bathrooms)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Bathrooms</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $submission->bathrooms }}</p>
                        </div>
                        @endif
                        
                        @if($submission->parking_spaces)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Parking Spaces</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $submission->parking_spaces }}</p>
                        </div>
                        @endif
                        
                        @if($submission->year_built)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Year Built</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $submission->year_built }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Location --}}
                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Location</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Address</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $submission->address }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">City</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $submission->city }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">State</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $submission->state }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Postal Code</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $submission->postal_code }}</p>
                        </div>
                    </div>
                </div>

                {{-- Description --}}
                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Description</h2>
                    <p class="text-gray-700 whitespace-pre-line">{{ $submission->description }}</p>
                </div>

                {{-- Features --}}
                @if($submission->features && count($submission->features) > 0)
                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Features</h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach($submission->features as $feature)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                {{ trim($feature) }}
                            </span>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Images --}}
                @if($submission->images && count($submission->images) > 0)
                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Images</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($submission->images as $image)
                            <div class="aspect-w-16 aspect-h-9">
                                <img src="{{ Storage::url($image) }}" 
                                     alt="Property image" 
                                     class="object-cover rounded-lg shadow-sm w-full h-48">
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                {{-- Contact Information --}}
                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Contact Information</h2>
                    
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Contact Name</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $submission->contact_name }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $submission->contact_email }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Phone</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $submission->contact_phone }}</p>
                        </div>
                    </div>
                </div>

                {{-- Submission Timeline --}}
                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Submission Timeline</h2>
                    
                    <div class="flow-root">
                        <ul class="-mb-8">
                            <li>
                                <div class="relative pb-8">
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white">
                                                <svg class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">Submission Created</p>
                                                <p class="text-sm text-gray-500">{{ $submission->created_at->format('F j, Y \a\t g:i A') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            @if($submission->reviewed_at)
                            <li>
                                <div class="relative">
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full {{ $submission->submission_status === 'approved' ? 'bg-green-500' : ($submission->submission_status === 'rejected' ? 'bg-red-500' : 'bg-yellow-500') }} flex items-center justify-center ring-8 ring-white">
                                                @if($submission->submission_status === 'approved')
                                                    <svg class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                    </svg>
                                                @elseif($submission->submission_status === 'rejected')
                                                    <svg class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                @else
                                                    <svg class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                @endif
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $submission->getSubmissionStatusLabel() }}</p>
                                                <p class="text-sm text-gray-500">{{ $submission->reviewed_at->format('F j, Y \a\t g:i A') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>

                {{-- Actions --}}
                @if($submission->canBeEdited())
                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Actions</h2>
                    
                    <div class="space-y-3">
                        <a href="{{ route('submissions.edit', $submission) }}" 
                           class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center block">
                            Edit Submission
                        </a>

                        @if(in_array($submission->submission_status, ['pending', 'rejected']))
                            <form action="{{ route('submissions.destroy', $submission) }}" method="POST" 
                                  onsubmit="return confirm('Are you sure you want to delete this submission? This action cannot be undone.')" 
                                  class="w-full">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Delete Submission
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection