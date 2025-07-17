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
                <p class="text-gray-600">Submitted by {{ $submission->user->name }} on {{ $submission->created_at->format('F j, Y \a\t g:i A') }}</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.submissions.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                    ← Back to Submissions
                </a>
            </div>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
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
                            <p class="mt-1 text-sm text-gray-900">
                                <a href="mailto:{{ $submission->contact_email }}" class="text-blue-600 hover:text-blue-800">
                                    {{ $submission->contact_email }}
                                </a>
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Phone</label>
                            <p class="mt-1 text-sm text-gray-900">
                                <a href="tel:{{ $submission->contact_phone }}" class="text-blue-600 hover:text-blue-800">
                                    {{ $submission->contact_phone }}
                                </a>
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Submission Status --}}
                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Submission Status</h2>
                    
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Current Status</label>
                            <span class="mt-1 inline-flex px-3 py-1 rounded-full text-sm font-medium {{ $submission->getSubmissionStatusBadgeClass() }}">
                                {{ $submission->getSubmissionStatusLabel() }}
                            </span>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Submitted</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $submission->created_at->format('F j, Y \a\t g:i A') }}</p>
                        </div>
                        
                        @if($submission->reviewed_at)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Last Reviewed</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $submission->reviewed_at->format('F j, Y \a\t g:i A') }}</p>
                        </div>
                        @endif
                        
                        @if($submission->reviewer)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Reviewed By</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $submission->reviewer->name }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Admin Notes --}}
                @if($submission->admin_notes)
                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Admin Notes</h2>
                    <p class="text-gray-700 whitespace-pre-line">{{ $submission->admin_notes }}</p>
                </div>
                @endif

                {{-- Actions --}}
                @if($submission->submission_status === 'pending')
                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Actions</h2>
                    
                    <div class="space-y-3">
                        <form action="{{ route('admin.submissions.approve', $submission) }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" 
                                    class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                                    onclick="return confirm('Are you sure you want to approve this submission? This will create a new property listing.')">
                                ✓ Approve Submission
                            </button>
                        </form>

                        <button type="button" 
                                class="w-full bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded"
                                onclick="showRevisionModal()">
                            ↻ Request Revision
                        </button>

                        <button type="button" 
                                class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                onclick="showRejectModal()">
                            ✗ Reject Submission
                        </button>
                    </div>
                </div>
                @endif

                {{-- Related Property --}}
                @if($submission->property)
                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Related Property</h2>
                    <p class="text-sm text-gray-600 mb-3">This submission was approved and converted to a live property:</p>
                    <a href="{{ route('admin.properties.show', $submission->property) }}" 
                       class="block bg-blue-600 hover:bg-blue-700 text-white text-center font-bold py-2 px-4 rounded">
                        View Live Property
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Revision Modal --}}
<div id="revisionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Request Revision</h3>
        <form action="{{ route('admin.submissions.request-revision', $submission) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="revision_notes" class="block text-sm font-medium text-gray-700">Revision Notes</label>
                <textarea id="revision_notes" name="notes" rows="4" 
                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Please explain what needs to be revised..." required></textarea>
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" onclick="hideRevisionModal()" 
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded">
                    Cancel
                </button>
                <button type="submit" 
                        class="bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded">
                    Request Revision
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Reject Modal --}}
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Reject Submission</h3>
        <form action="{{ route('admin.submissions.reject', $submission) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="reject_notes" class="block text-sm font-medium text-gray-700">Rejection Reason</label>
                <textarea id="reject_notes" name="notes" rows="4" 
                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Please explain why this submission is being rejected..." required></textarea>
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" onclick="hideRejectModal()" 
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded">
                    Cancel
                </button>
                <button type="submit" 
                        class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded">
                    Reject Submission
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function showRevisionModal() {
    document.getElementById('revisionModal').classList.remove('hidden');
}

function hideRevisionModal() {
    document.getElementById('revisionModal').classList.add('hidden');
    document.getElementById('revision_notes').value = '';
}

function showRejectModal() {
    document.getElementById('rejectModal').classList.remove('hidden');
}

function hideRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
    document.getElementById('reject_notes').value = '';
}
</script>
@endsection