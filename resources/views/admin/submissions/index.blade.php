@extends('layouts.app')

@section('title', 'User Submissions')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        {{-- Header --}}
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">User Property Submissions</h1>
                <p class="text-gray-600 mt-2">Review and manage property submissions from users</p>
            </div>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        {{-- Status Tabs --}}
        <div class="mb-6">
            <nav class="flex space-x-8" aria-label="Tabs">
                <a href="{{ route('admin.submissions.index') }}" 
                   class="@if(!request('status')) border-blue-500 text-blue-600 @else border-transparent text-gray-500 hover:text-gray-700 @endif whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                    All Submissions
                </a>
                <a href="{{ route('admin.submissions.index', ['status' => 'pending']) }}" 
                   class="@if(request('status') === 'pending') border-blue-500 text-blue-600 @else border-transparent text-gray-500 hover:text-gray-700 @endif whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                    Pending
                </a>
                <a href="{{ route('admin.submissions.index', ['status' => 'approved']) }}" 
                   class="@if(request('status') === 'approved') border-green-500 text-green-600 @else border-transparent text-gray-500 hover:text-gray-700 @endif whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                    Approved
                </a>
                <a href="{{ route('admin.submissions.index', ['status' => 'rejected']) }}" 
                   class="@if(request('status') === 'rejected') border-red-500 text-red-600 @else border-transparent text-gray-500 hover:text-gray-700 @endif whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                    Rejected
                </a>
                <a href="{{ route('admin.submissions.index', ['status' => 'needs_revision']) }}" 
                   class="@if(request('status') === 'needs_revision') border-yellow-500 text-yellow-600 @else border-transparent text-gray-500 hover:text-gray-700 @endif whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                    Needs Revision
                </a>
            </nav>
        </div>

        {{-- Submissions List --}}
        @if($submissions->count() > 0)
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="space-y-6">
                        @foreach($submissions as $submission)
                            <div class="border border-gray-200 rounded-lg p-6 hover:bg-gray-50 transition-colors duration-200">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-3">
                                            <h3 class="text-xl font-semibold text-gray-900">
                                                <a href="{{ route('admin.submissions.show', $submission) }}" class="hover:text-blue-600">
                                                    {{ $submission->title }}
                                                </a>
                                            </h3>
                                            <span class="px-3 py-1 rounded-full text-sm font-medium {{ $submission->getSubmissionStatusBadgeClass() }}">
                                                {{ $submission->getSubmissionStatusLabel() }}
                                            </span>
                                        </div>
                                        
                                        {{-- Property Details --}}
                                        <div class="grid grid-cols-2 gap-4 mb-4">
                                            <div>
                                                <div class="text-sm text-gray-600">Price</div>
                                                <div class="font-semibold text-lg text-gray-900">{{ $submission->formatted_price }}</div>
                                            </div>
                                            <div>
                                                <div class="text-sm text-gray-600">Location</div>
                                                <div class="font-medium text-gray-900">{{ $submission->city }}, {{ $submission->state }}</div>
                                            </div>
                                            @if($submission->square_footage)
                                            <div>
                                                <div class="text-sm text-gray-600">Square Footage</div>
                                                <div class="font-medium text-gray-900">{{ number_format($submission->square_footage) }} sq ft</div>
                                            </div>
                                            @endif
                                            @if($submission->bedrooms)
                                            <div>
                                                <div class="text-sm text-gray-600">Bedrooms</div>
                                                <div class="font-medium text-gray-900">{{ $submission->bedrooms }} bed • {{ $submission->bathrooms }} bath</div>
                                            </div>
                                            @endif
                                        </div>

                                        {{-- Contact & Submission Info --}}
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600">
                                            <div>
                                                <span class="font-medium">Submitted by:</span> {{ $submission->user->name }}
                                            </div>
                                            <div>
                                                <span class="font-medium">Contact:</span> {{ $submission->contact_name }}
                                            </div>
                                            <div>
                                                <span class="font-medium">Date:</span> {{ $submission->created_at->format('M j, Y g:i A') }}
                                            </div>
                                        </div>

                                        {{-- Admin Notes --}}
                                        @if($submission->admin_notes)
                                            <div class="mt-4 p-3 bg-blue-50 rounded border-l-4 border-blue-300">
                                                <p class="text-sm font-medium text-blue-700">Admin Notes:</p>
                                                <p class="text-sm text-blue-600 mt-1">{{ $submission->admin_notes }}</p>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Action Buttons --}}
                                    <div class="flex flex-col gap-2 ml-6">
                                        <a href="{{ route('admin.submissions.show', $submission) }}" 
                                           class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-4 rounded text-center">
                                            View Details
                                        </a>

                                        @if($submission->submission_status === 'pending')
                                            <form action="{{ route('admin.submissions.approve', $submission) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="w-full bg-green-600 hover:bg-green-700 text-white text-sm font-medium py-2 px-4 rounded"
                                                        onclick="return confirm('Are you sure you want to approve this submission?')">
                                                    Approve
                                                </button>
                                            </form>

                                            <button type="button" 
                                                    class="bg-yellow-600 hover:bg-yellow-700 text-white text-sm font-medium py-2 px-4 rounded"
                                                    onclick="showRevisionModal({{ $submission->id }})">
                                                Request Revision
                                            </button>

                                            <button type="button" 
                                                    class="bg-red-600 hover:bg-red-700 text-white text-sm font-medium py-2 px-4 rounded"
                                                    onclick="showRejectModal({{ $submission->id }})">
                                                Reject
                                            </button>
                                        @endif

                                        @if($submission->submission_status === 'approved' && $submission->property_id)
                                            <a href="{{ route('admin.properties.show', $submission->property_id) }}" 
                                               class="bg-green-100 text-green-800 text-sm font-medium py-2 px-4 rounded text-center">
                                                View Live Property
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Pagination --}}
            <div class="mt-8">
                {{ $submissions->appends(request()->query())->links() }}
            </div>
        @else
            {{-- Empty State --}}
            <div class="text-center py-12">
                <div class="max-w-md mx-auto">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No submissions found</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        @if(request('status'))
                            No submissions with "{{ request('status') }}" status.
                        @else
                            No property submissions have been received yet.
                        @endif
                    </p>
                </div>
            </div>
        @endif
    </div>
</div>

{{-- Revision Modal --}}
<div id="revisionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Request Revision</h3>
        <form id="revisionForm" method="POST">
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
        <form id="rejectForm" method="POST">
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
function showRevisionModal(submissionId) {
    document.getElementById('revisionForm').action = `/admin/submissions/${submissionId}/request-revision`;
    document.getElementById('revisionModal').classList.remove('hidden');
}

function hideRevisionModal() {
    document.getElementById('revisionModal').classList.add('hidden');
    document.getElementById('revision_notes').value = '';
}

function showRejectModal(submissionId) {
    document.getElementById('rejectForm').action = `/admin/submissions/${submissionId}/reject`;
    document.getElementById('rejectModal').classList.remove('hidden');
}

function hideRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
    document.getElementById('reject_notes').value = '';
}
</script>
@endsection