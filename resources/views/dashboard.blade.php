@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <!-- Welcome Message -->
        <div class="bg-white overflow-hidden shadow-lg rounded-lg mb-8">
            <div class="p-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Welcome back, {{ Auth::user()->name }}!</h1>
                <p class="text-gray-600 text-lg">Manage your property submissions and track their status.</p>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <!-- Submit New Property -->
            <div class="bg-white overflow-hidden shadow-lg rounded-lg hover:shadow-xl transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900">Submit Property</h3>
                            <p class="text-gray-600">Add a new property for review</p>
                        </div>
                    </div>
                    <div class="mt-6">
                        <a href="{{ route('submissions.create') }}" 
                           class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-200 inline-block text-center">
                            Submit Now
                        </a>
                    </div>
                </div>
            </div>

            <!-- View Submissions -->
            <div class="bg-white overflow-hidden shadow-lg rounded-lg hover:shadow-xl transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900">My Submissions</h3>
                            <p class="text-gray-600">View and manage your submissions</p>
                        </div>
                    </div>
                    <div class="mt-6">
                        <a href="{{ route('submissions.index') }}" 
                           class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-200 inline-block text-center">
                            View All
                        </a>
                    </div>
                </div>
            </div>

            <!-- Profile -->
            <div class="bg-white overflow-hidden shadow-lg rounded-lg hover:shadow-xl transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900">Profile</h3>
                            <p class="text-gray-600">Update your account information</p>
                        </div>
                    </div>
                    <div class="mt-6">
                        <a href="{{ route('profile.edit') }}" 
                           class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-200 inline-block text-center">
                            Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Submissions -->
        <div class="bg-white overflow-hidden shadow-lg rounded-lg">
            <div class="p-6">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Recent Submissions</h2>
                
                @php
                    $recentSubmissions = App\Models\UserPropertySubmission::where('user_id', Auth::id())
                        ->orderBy('created_at', 'desc')
                        ->take(5)
                        ->get();
                @endphp

                @if($recentSubmissions->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentSubmissions as $submission)
                            <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900">{{ $submission->title }}</h4>
                                    <p class="text-gray-600">{{ $submission->address }}, {{ $submission->city }}, {{ $submission->state }}</p>
                                    <p class="text-sm text-gray-500">
                                        <span class="font-medium">${{ number_format($submission->price) }}</span> • 
                                        Submitted {{ $submission->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                <div class="flex items-center space-x-3 ml-4">
                                    <span class="px-3 py-1 text-xs font-medium rounded-full {{ $submission->getSubmissionStatusBadgeClass() }}">
                                        {{ $submission->getSubmissionStatusLabel() }}
                                    </span>
                                    <a href="{{ route('submissions.show', $submission) }}" 
                                       class="text-blue-600 hover:text-blue-800 font-medium">
                                        View Details →
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-6 text-center">
                        <a href="{{ route('submissions.index') }}" 
                           class="text-blue-600 hover:text-blue-800 font-medium text-lg">
                            View All Submissions →
                        </a>
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <h3 class="mt-4 text-xl font-medium text-gray-900">No submissions yet</h3>
                        <p class="mt-2 text-gray-500">Get started by submitting your first property for review.</p>
                        <div class="mt-6">
                            <a href="{{ route('submissions.create') }}" 
                               class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg transition-colors duration-200">
                                Submit Your First Property
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection