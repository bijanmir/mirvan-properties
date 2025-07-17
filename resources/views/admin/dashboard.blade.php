@extends('layouts.app')

@section('title', 'Admin Dashboard - Mirvan Properties')

@section('content')
<!-- Admin Header -->
<section class="bg-gradient-to-r from-gray-900 to-blue-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-white">Admin Dashboard</h1>
                <p class="text-blue-200 mt-1">Welcome back, {{ Auth::user()->name }}</p>
            </div>
            <div class="text-white text-right">
                <div class="text-sm text-blue-200">Last updated</div>
                <div class="font-semibold">{{ now()->format('M j, Y g:i A') }}</div>
            </div>
        </div>
    </div>
</section>

<!-- Dashboard Content -->
<section class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Properties Stats -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">Properties</h3>
                        <div class="text-2xl font-bold text-blue-600">{{ $stats['total_properties'] }}</div>
                        <div class="text-sm text-gray-500">{{ $stats['active_properties'] }} active</div>
                    </div>
                </div>
            </div>

            <!-- Blog Posts Stats -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">Blog Posts</h3>
                        <div class="text-2xl font-bold text-green-600">{{ $stats['total_blog_posts'] }}</div>
                        <div class="text-sm text-gray-500">{{ $stats['published_posts'] }} published</div>
                    </div>
                </div>
            </div>

            <!-- Submissions Stats -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">Submissions</h3>
                        <div class="text-2xl font-bold text-yellow-600">{{ $stats['total_submissions'] }}</div>
                        <div class="text-sm text-gray-500">{{ $stats['pending_submissions'] }} pending</div>
                    </div>
                </div>
            </div>

            <!-- Users Stats -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">Users</h3>
                        <div class="text-2xl font-bold text-purple-600">{{ $stats['total_users'] }}</div>
                        <div class="text-sm text-gray-500">{{ $stats['admin_users'] }} admins</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Quick Actions</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('admin.properties.create') }}" class="bg-blue-600 text-white px-4 py-3 rounded-lg font-semibold text-center hover:bg-blue-700 transition-colors">
                    Add New Property
                </a>
                <a href="{{ route('admin.blog.create') }}" class="bg-green-600 text-white px-4 py-3 rounded-lg font-semibold text-center hover:bg-green-700 transition-colors">
                    Create Blog Post
                </a>
                <a href="{{ route('admin.submissions.index') }}" class="bg-yellow-600 text-white px-4 py-3 rounded-lg font-semibold text-center hover:bg-yellow-700 transition-colors">
                    Review Submissions
                </a>
                <a href="{{ route('properties.index') }}" class="bg-gray-600 text-white px-4 py-3 rounded-lg font-semibold text-center hover:bg-gray-700 transition-colors">
                    View Public Site
                </a>
            </div>
        </div>

        <!-- Recent Activity and Analytics -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Properties -->
            <div class="bg-white rounded-lg shadow-lg">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Recent Properties</h3>
                        <a href="{{ route('admin.properties.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">View All</a>
                    </div>
                </div>
                <div class="p-6">
                    @if($recent_properties->count() > 0)
                        <div class="space-y-4">
                            @foreach($recent_properties as $property)
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-900">{{ $property->title }}</h4>
                                        <p class="text-sm text-gray-500">{{ $property->city }}, {{ $property->state }} • {{ $property->getStatusLabel() }}</p>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-sm font-medium text-gray-900">{{ $property->getFormattedPrice() }}</div>
                                        <div class="text-xs text-gray-500">{{ $property->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">No properties added yet.</p>
                    @endif
                </div>
            </div>

            <!-- Recent Blog Posts -->
            <div class="bg-white rounded-lg shadow-lg">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Recent Blog Posts</h3>
                        <a href="{{ route('admin.blog.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">View All</a>
                    </div>
                </div>
                <div class="p-6">
                    @if($recent_posts->count() > 0)
                        <div class="space-y-4">
                            @foreach($recent_posts as $post)
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-900">{{ $post->title }}</h4>
                                        <p class="text-sm text-gray-500">
                                            {{ $post->is_published ? 'Published' : 'Draft' }}
                                            @if($post->is_featured) • Featured @endif
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-sm text-gray-900">{{ $post->views }} views</div>
                                        <div class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">No blog posts created yet.</p>
                    @endif
                </div>
            </div>

            <!-- Pending Submissions -->
            <div class="bg-white rounded-lg shadow-lg">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Pending Submissions</h3>
                        <a href="{{ route('admin.submissions.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">View All</a>
                    </div>
                </div>
                <div class="p-6">
                    @if($recent_submissions->count() > 0)
                        <div class="space-y-4">
                            @foreach($recent_submissions as $submission)
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-900">{{ $submission->title }}</h4>
                                        <p class="text-sm text-gray-500">By {{ $submission->user->name }} • {{ $submission->getPropertyTypeLabel() }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium {{ $submission->getSubmissionStatusBadgeClass() }}">
                                            {{ $submission->getSubmissionStatusLabel() }}
                                        </span>
                                        <div class="text-xs text-gray-500 mt-1">{{ $submission->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">No submissions to review.</p>
                    @endif
                </div>
            </div>

            <!-- Monthly Statistics Chart -->
            <div class="bg-white rounded-lg shadow-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">6-Month Overview</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach($monthly_stats as $stat)
                            <div class="flex items-center justify-between">
                                <div class="text-sm font-medium text-gray-700">{{ $stat['month'] }}</div>
                                <div class="flex space-x-4 text-sm">
                                    <span class="text-blue-600">{{ $stat['properties'] }} Props</span>
                                    <span class="text-green-600">{{ $stat['blog_posts'] }} Posts</span>
                                    <span class="text-yellow-600">{{ $stat['submissions'] }} Subs</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Property Status Breakdown -->
        <div class="mt-8 bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Property Status Breakdown</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600">{{ $stats['properties_for_sale'] }}</div>
                    <div class="text-sm text-gray-600">For Sale</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600">{{ $stats['properties_for_lease'] }}</div>
                    <div class="text-sm text-gray-600">For Lease</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-yellow-600">{{ $stats['featured_properties'] }}</div>
                    <div class="text-sm text-gray-600">Featured</div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection