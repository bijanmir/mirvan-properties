@extends('layouts.app')

@section('title', 'My Property Submissions')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        {{-- Header --}}
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">My Property Submissions</h1>
                <p class="text-gray-600 mt-2">Track the status of your submitted properties</p>
            </div>
            <a href="{{ route('submissions.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg">
                Submit New Property
            </a>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        {{-- Error Message --}}
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        {{-- Submissions List --}}
        @if($submissions->count() > 0)
            <div class="grid gap-6">
                @foreach($submissions as $submission)
                    <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 
                        @if($submission->status === 'approved') border-green-500
                        @elseif($submission->status === 'rejected') border-red-500
                        @elseif($submission->status === 'needs_revision') border-yellow-500
                        @else border-blue-500
                        @endif">
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center gap-4 mb-2">
                                    <h3 class="text-xl font-semibold text-gray-900">
                                        <a href="{{ route('submissions.show', $submission) }}" class="hover:text-blue-600">
                                            {{ $submission->title }}
                                        </a>
                                    </h3>
                                    <span class="px-3 py-1 rounded-full text-sm font-medium
                                        @if($submission->status === 'approved') bg-green-100 text-green-800
                                        @elseif($submission->status === 'rejected') bg-red-100 text-red-800
                                        @elseif($submission->status === 'needs_revision') bg-yellow-100 text-yellow-800
                                        @else bg-blue-100 text-blue-800
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $submission->status)) }}
                                    </span>
                                </div>
                                
                                <div class="text-gray-600 space-y-1">
                                    <p><span class="font-medium">Location:</span> {{ $submission->location }}</p>
                                    <p><span class="font-medium">Price:</span> ${{ number_format($submission->price) }}</p>
                                    <p><span class="font-medium">Type:</span> {{ ucfirst($submission->property_type) }}</p>
                                    @if($submission->bedrooms || $submission->bathrooms)
                                        <p>
                                            @if($submission->bedrooms)<span class="font-medium">{{ $submission->bedrooms }} bed</span>@endif
                                            @if($submission->bedrooms && $submission->bathrooms) • @endif
                                            @if($submission->bathrooms)<span class="font-medium">{{ $submission->bathrooms }} bath</span>@endif
                                        </p>
                                    @endif
                                    <p><span class="font-medium">Submitted:</span> {{ $submission->created_at->format('M j, Y g:i A') }}</p>
                                </div>

                                @if($submission->admin_notes)
                                    <div class="mt-3 p-3 bg-gray-50 rounded border-l-4 border-gray-300">
                                        <p class="text-sm font-medium text-gray-700">Admin Notes:</p>
                                        <p class="text-sm text-gray-600 mt-1">{{ $submission->admin_notes }}</p>
                                    </div>
                                @endif
                            </div>

                            <div class="flex flex-col gap-2 ml-4">
                                <a href="{{ route('submissions.show', $submission) }}" 
                                   class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-4 rounded">
                                    View Details
                                </a>

                                @if(in_array($submission->status, ['pending', 'needs_revision']))
                                    <a href="{{ route('submissions.edit', $submission) }}" 
                                       class="bg-yellow-600 hover:bg-yellow-700 text-white text-sm font-medium py-2 px-4 rounded">
                                        Edit
                                    </a>
                                @endif

                                @if(in_array($submission->status, ['pending', 'rejected']))
                                    <form action="{{ route('submissions.destroy', $submission) }}" method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete this submission?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-red-600 hover:bg-red-700 text-white text-sm font-medium py-2 px-4 rounded w-full">
                                            Delete
                                        </button>
                                    </form>
                                @endif

                                @if($submission->status === 'approved' && $submission->property_id)
                                    <a href="{{ route('properties.show', $submission->property_id) }}" 
                                       class="bg-green-600 hover:bg-green-700 text-white text-sm font-medium py-2 px-4 rounded">
                                        View Live Property
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-8">
                {{ $submissions->links() }}
            </div>
        @else
            {{-- Empty State --}}
            <div class="text-center py-12">
                <div class="max-w-md mx-auto">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No submissions yet</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by submitting your first property.</p>
                    <div class="mt-6">
                        <a href="{{ route('submissions.create') }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg">
                            Submit Your First Property
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection