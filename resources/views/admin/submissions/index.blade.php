@extends('layouts.app')

@section('title', 'Review Submissions - Admin Panel')

@section('content')
<!-- Admin Header -->
<section class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Review Property Submissions</h1>
                <p class="text-gray-600">Manage and moderate user-submitted property listings</p>
            </div>
            <div class="text-right">
                <div class="text-sm text-gray-600">Pending Review</div>
                <div class="text-2xl font-bold text-orange-600">{{ $statusCounts['pending'] }}</div>
            </div>
        </div>
    </div>
</section>

<!-- Status Tabs -->
<section class="bg-gray-50 border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex space-x-8" aria-label="Tabs">
            <a href="{{ route('admin.submissions.index') }}" 
               class="py-4 px-1 border-b-2 font-medium text-sm {{ !request('status') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                All Submissions
                <span class="ml-2 bg-gray-100 text-gray-900 rounded-full py-0.5 px-2.5 text-xs font-medium">
                    {{ $statusCounts['all'] }}
                </span>
            </a>
            <a href="{{ route('admin.submissions.index', ['status' => 'pending']) }}" 
               class="py-4 px-1 border-b-2 font-medium text-sm {{ request('status') === 'pending' ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                Pending
                <span class="ml-2 bg-orange-100 text-orange-900 rounded-full py-0.5 px-2.5 text-xs font-medium">
                    {{ $statusCounts['pending'] }}
                </span>
            </a>
            <a href="{{ route('admin.submissions.index', ['status' => 'approved']) }}" 
               class="py-4 px-1 border-b-2 font-medium text-sm {{ request('status') === 'approved' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                Approved
                <span class="ml-2 bg-green-100 text-green-900 rounded-full py-0.5 px-2.5 text-xs font-medium">
                    {{ $statusCounts['approved'] }}
                </span>
            </a>
            <a href="{{ route('admin.submissions.index', ['status' => 'needs_revision']) }}" 
               class="py-4 px-1 border-b-2 font-medium text-sm {{ request('status') === 'needs_revision' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                Needs Revision
                <span class="ml-2 bg-blue-100 text-blue-900 rounded-full py-0.5 px-2.5 text-xs font-medium">
                    {{ $statusCounts['needs_revision'] }}
                </span>
            </a>
            <a href="{{ route('admin.submissions.index', ['status' => 'rejected']) }}" 
               class="py-4 px-1 border-b-2 font-medium text-sm {{ request('status') === 'rejected' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                Rejected
                <span class="ml-2 bg-red-100 text-red-900 rounded-full py-0.5 px-2.5 text-xs font-medium">
                    {{ $statusCounts['rejected'] }}
                </span>
            </a>
        </nav>
    </div>
</section>

<!-- Search and Filters -->
<section class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <form method="GET" class="flex flex-col md:flex-row gap-4">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            
            <!-- Search -->
            <div class="flex-1">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Search by title, location, or contact name..."
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            
            <button type="submit" class="bg-gray-600 text-white px-6 py-2 rounded-md hover:bg-gray-700 transition-colors">
                Search
            </button>
            
            @if(request('search'))
                <a href="{{ route('admin.submissions.index', request()->only('status')) }}" 
                   class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400 transition-colors">
                    Clear
                </a>
            @endif
        </form>
    </div>
</section>

<!-- Submissions List -->
<section class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if($submissions->count() > 0)
            <!-- Results Summary -->
            <div class="mb-6 flex items-center justify-between">
                <p class="text-gray-600">
                    Showing {{ $submissions->firstItem() }} to {{ $submissions->lastItem() }} of {{ $submissions->total() }} submissions
                </p>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-600">Sort by:</span>
                    <select onchange="location.href=this.value" class="text-sm border-gray-300 rounded">
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'order' => 'desc']) }}"
                                {{ request('sort') == 'created_at' && request('order') == 'desc' ? 'selected' : '' }}>
                            Newest First
                        </option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'order' => 'asc']) }}"
                                {{ request('sort') == 'created_at' && request('order') == 'asc' ? 'selected' : '' }}>
                            Oldest First
                        </option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'price', 'order' => 'desc']) }}"
                                {{ request('sort') == 'price' && request('order') == 'desc' ? 'selected' : '' }}>
                            Price High-Low
                        </option>
                    </select>
                </div>
            </div>

            <!-- Submissions Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach($submissions as $submission)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <!-- Header -->
                        <div class="p-6 border-b border-gray-200">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-gray-900 mb-2">
                                        {{ $submission->title }}
                                    </h3>
                                    <div class="flex items-center text-sm text-gray-600 space-x-4">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            </svg>
                                            {{ $submission->city }}, {{ $submission->state }}
                                        </span>
                                        <span>{{ $submission->getPropertyTypeLabel() }}</span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $submission->getSubmissionStatusBadgeClass() }}">
                                        {{ $submission->getSubmissionStatusLabel() }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            <!-- Property Details -->
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <div class="text-sm text-gray-600">Price</div>
                                    <div class="font-semibold text-lg text-gray-900">{{ $submission->getFormattedPrice() }}</div>
                                </div>
                                @if($submission->square_footage)
                                    <div>
                                        <div class="text-sm text-gray-600">Square Footage</div>
                                        <div class="font-semibold text-gray-900">{{ number_format($submission->square_footage) }} sq ft</div>
                                    </div>
                                @endif
                                @if($submission->bedrooms)
                                    <div>
                                        <div class="text-sm text-gray-600">Bedrooms</div>
                                        <div class="font-semibold text-gray-900">{{ $submission->bedrooms }}</div>
                                    </div>
                                @endif
                                @if($submission->bathrooms)
                                    <div>
                                        <div class="text-sm text-gray-600">Bathrooms</div>
                                        <div class="font-semibold text-gray-900">{{ $submission->bathrooms }}</div>
                                    </div>
                                @endif
                            </div>

                            <!-- Description -->
                            <div class="mb-4">
                                <div class="text-sm text-gray-600 mb-1">Description</div>
                                <p class="text-gray-800 text-sm line-clamp-3">{{ $submission->description }}</p>
                            </div>

                            <!-- Contact Info -->
                            <div class="mb-4">
                                <div class="text-sm text-gray-600 mb-1">Contact Information</div>
                                <div class="text-sm">
                                    <div class="font-medium">{{ $submission->contact_name }}</div>
                                    <div class="text-gray-600">{{ $submission->contact_email }}</div>
                                    @if($submission->contact_phone)
                                        <div class="text-gray-600">{{ $submission->contact_phone }}</div>
                                    @endif
                                </div>
                            </div>

                            <!-- Submitted By -->
                            <div class="mb-4">
                                <div class="text-sm text-gray-600 mb-1">Submitted By</div>
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-gray-600 text-sm font-semibold">{{ substr($submission->user->name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <div class="font-medium text-sm">{{ $submission->user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $submission->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            </div>

                            @if($submission->admin_notes)
                                <!-- Admin Notes -->
                                <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                                    <div class="text-sm text-gray-600 mb-1">Admin Notes</div>
                                    <p class="text-sm text-gray-800">{{ $submission->admin_notes }}</p>
                                    @if($submission->reviewed_at && $submission->reviewer)
                                        <div class="text-xs text-gray-500 mt-2">
                                            By {{ $submission->reviewer->name }} • {{ $submission->reviewed_at->diffForHumans() }}
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <!-- Actions -->
                            <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                                <a href="{{ route('admin.submissions.show', $submission) }}" 
                                   class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                                    Review Details
                                </a>

                                @if($submission->submission_status === 'pending')
                                    <div class="flex items-center space-x-2">
                                        <!-- Quick Approve -->
                                        <form method="POST" action="{{ route('admin.submissions.approve', $submission) }}" class="inline">
                                            @csrf
                                            <input type="hidden" name="create_property" value="1">
                                            <button type="submit" 
                                                    class="bg-green-600 text-white px-3 py-1 rounded text-sm font-medium hover:bg-green-700 transition-colors"
                                                    onclick="return confirm('Approve this submission and create a property?')">
                                                Quick Approve
                                            </button>
                                        </form>

                                        <!-- Quick Reject -->
                                        <button onclick="showRejectModal({{ $submission->id }})" 
                                                class="bg-red-600 text-white px-3 py-1 rounded text-sm font-medium hover:bg-red-700 transition-colors">
                                            Quick Reject
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($submissions->hasPages())
                <div class="mt-8">
                    {{ $submissions->appends(request()->query())->links() }}
                </div>
            @endif

        @else
            <!-- No Submissions -->
            <div class="text-center py-16">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No submissions found</h3>
                <p class="mt-2 text-sm text-gray-500">
                    @if(request()->hasAny(['search', 'status']))
                        No submissions match your current filters.
                    @else
                        No property submissions have been received yet.
                    @endif
                </p>
                @if(request()->hasAny(['search', 'status']))
                    <div class="mt-6">
                        <a href="{{ route('admin.submissions.index') }}" 
                           class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                            Clear Filters
                        </a>
                    </div>
                @endif
            </div>
        @endif
    </div>
</section>

<!-- Quick Reject Modal -->
<div id="rejectModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Reject Submission</h3>
        <form id="rejectForm" method="POST">
            @csrf
            <div class="mb-4">
                <label for="reject_notes" class="block text-sm font-medium text-gray-700 mb-2">Reason for Rejection *</label>
                <textarea id="reject_notes" 
                          name="notes" 
                          required
                          rows="4"
                          placeholder="Please provide a reason for rejecting this submission..."
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"></textarea>
            </div>
            <div class="flex items-center justify-end space-x-4">
                <button type="button" 
                        onclick="hideRejectModal()"
                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition-colors">
                    Cancel
                </button>
                <button type="submit" 
                        class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition-colors">
                    Reject Submission
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('styles')
<style>
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush

@push('scripts')
<script>
    function showRejectModal(submissionId) {
        document.getElementById('rejectForm').action = `/admin/submissions/${submissionId}/reject`;
        document.getElementById('rejectModal').classList.remove('hidden');
    }

    function hideRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
        document.getElementById('reject_notes').value = '';
    }

    // Close modal when clicking outside
    document.getElementById('rejectModal').addEventListener('click', function(e) {
        if (e.target === this) {
            hideRejectModal();
        }
    });
</script>
@endpush