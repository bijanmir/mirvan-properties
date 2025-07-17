@extends('layouts.app')

@section('title', 'Manage Blog Posts - Admin Panel')

@section('content')
<!-- Admin Header -->
<section class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Manage Blog Posts</h1>
                <p class="text-gray-600">Create, edit, and manage blog articles</p>
            </div>
            <a href="{{ route('admin.blog.create') }}" 
               class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                Create New Post
            </a>
        </div>
    </div>
</section>

<!-- Filters and Search -->
<section class="bg-gray-50 border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <form method="GET" class="flex flex-col md:flex-row gap-4">
            <!-- Search -->
            <div class="flex-1">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Search blog posts..."
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            
            <!-- Status Filter -->
            <div class="md:w-48">
                <select name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All Posts</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Drafts</option>
                    <option value="featured" {{ request('status') == 'featured' ? 'selected' : '' }}>Featured</option>
                </select>
            </div>
            
            <button type="submit" class="bg-gray-600 text-white px-6 py-2 rounded-md hover:bg-gray-700 transition-colors">
                Filter
            </button>
            
            @if(request()->hasAny(['search', 'status']))
                <a href="{{ route('admin.blog.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400 transition-colors">
                    Clear
                </a>
            @endif
        </form>
    </div>
</section>

<!-- Blog Posts List -->
<section class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if($posts->count() > 0)
            <!-- Results Summary -->
            <div class="mb-6 flex items-center justify-between">
                <p class="text-gray-600">
                    Showing {{ $posts->firstItem() }} to {{ $posts->lastItem() }} of {{ $posts->total() }} posts
                </p>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-600">Sort by:</span>
                    <select onchange="location.href=this.value" class="text-sm border-gray-300 rounded">
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'order' => 'desc']) }}"
                                {{ request('sort') == 'created_at' && request('order') == 'desc' ? 'selected' : '' }}>
                            Newest First
                        </option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'title', 'order' => 'asc']) }}"
                                {{ request('sort') == 'title' && request('order') == 'asc' ? 'selected' : '' }}>
                            Title A-Z
                        </option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'published_at', 'order' => 'desc']) }}"
                                {{ request('sort') == 'published_at' && request('order') == 'desc' ? 'selected' : '' }}>
                            Recently Published
                        </option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'views', 'order' => 'desc']) }}"
                                {{ request('sort') == 'views' && request('order') == 'desc' ? 'selected' : '' }}>
                            Most Popular
                        </option>
                    </select>
                </div>
            </div>

            <!-- Posts Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($posts as $post)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <!-- Featured Image -->
                        @if($post->featured_image_url)
                            <div class="relative">
                                <img src="{{ $post->featured_image_url }}" 
                                     alt="{{ $post->featured_image_alt ?? $post->title }}"
                                     class="w-full h-48 object-cover">
                                @if($post->is_featured)
                                    <div class="absolute top-3 left-3">
                                        <span class="bg-yellow-400 text-yellow-900 px-2 py-1 rounded text-xs font-bold">
                                            FEATURED
                                        </span>
                                    </div>
                                @endif
                                @if(!$post->is_published)
                                    <div class="absolute top-3 right-3">
                                        <span class="bg-red-500 text-white px-2 py-1 rounded text-xs font-bold">
                                            DRAFT
                                        </span>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center relative">
                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                @if($post->is_featured)
                                    <div class="absolute top-3 left-3">
                                        <span class="bg-yellow-400 text-yellow-900 px-2 py-1 rounded text-xs font-bold">
                                            FEATURED
                                        </span>
                                    </div>
                                @endif
                                @if(!$post->is_published)
                                    <div class="absolute top-3 right-3">
                                        <span class="bg-red-500 text-white px-2 py-1 rounded text-xs font-bold">
                                            DRAFT
                                        </span>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <!-- Content -->
                        <div class="p-6">
                            <!-- Meta Info -->
                            <div class="flex items-center justify-between text-sm text-gray-500 mb-3">
                                <span>{{ $post->created_at->format('M j, Y') }}</span>
                                <div class="flex items-center space-x-2">
                                    @if($post->read_time)
                                        <span>{{ $post->read_time_text }}</span>
                                    @endif
                                    <span>•</span>
                                    <span>{{ $post->views }} views</span>
                                </div>
                            </div>

                            <!-- Title -->
                            <h3 class="text-lg font-bold text-gray-900 mb-2">
                                {{ $post->title }}
                            </h3>

                            <!-- Excerpt -->
                            @if($post->excerpt)
                                <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                    {{ $post->excerpt }}
                                </p>
                            @endif

                            <!-- Tags -->
                            @if($post->tags && count($post->tags) > 0)
                                <div class="mb-4">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach(array_slice($post->tags, 0, 3) as $tag)
                                            <span class="inline-block bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded">
                                                {{ ucfirst($tag) }}
                                            </span>
                                        @endforeach
                                        @if(count($post->tags) > 3)
                                            <span class="inline-block bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded">
                                                +{{ count($post->tags) - 3 }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- Status -->
                            <div class="flex items-center justify-between mb-4">
                                @if($post->is_published)
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800">
                                        Published {{ $post->published_at ? $post->published_at->diffForHumans() : '' }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                        Draft
                                    </span>
                                @endif

                                @if($post->author_name)
                                    <span class="text-xs text-gray-500">by {{ $post->author_name }}</span>
                                @endif
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                                <div class="flex items-center space-x-2">
                                    @if($post->is_published)
                                        <a href="{{ route('blog.show', $post) }}" 
                                           target="_blank"
                                           class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                            View
                                        </a>
                                    @endif
                                    <a href="{{ route('admin.blog.edit', $post) }}" 
                                       class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                                        Edit
                                    </a>
                                </div>

                                <div class="flex items-center space-x-2">
                                    <!-- Publish/Unpublish -->
                                    @if($post->is_published)
                                        <form method="POST" action="{{ route('admin.blog.unpublish', $post) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="text-orange-600 hover:text-orange-700 text-sm font-medium">
                                                Unpublish
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.blog.publish', $post) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-700 text-sm font-medium">
                                                Publish
                                            </button>
                                        </form>
                                    @endif

                                    <!-- Toggle Featured -->
                                    <form method="POST" action="{{ route('admin.blog.toggle-featured', $post) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="text-yellow-600 hover:text-yellow-700 text-sm font-medium">
                                            {{ $post->is_featured ? 'Unfeature' : 'Feature' }}
                                        </button>
                                    </form>

                                    <!-- Delete -->
                                    <form method="POST" action="{{ route('admin.blog.destroy', $post) }}" 
                                          class="inline" 
                                          onsubmit="return confirm('Are you sure you want to delete this blog post?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-700 text-sm font-medium">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($posts->hasPages())
                <div class="mt-8">
                    {{ $posts->appends(request()->query())->links() }}
                </div>
            @endif

        @else
            <!-- No Posts -->
            <div class="text-center py-16">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No blog posts found</h3>
                <p class="mt-2 text-sm text-gray-500">
                    @if(request()->hasAny(['search', 'status']))
                        No posts match your current filters. Try adjusting your search criteria.
                    @else
                        Get started by creating your first blog post.
                    @endif
                </p>
                <div class="mt-6">
                    @if(request()->hasAny(['search', 'status']))
                        <a href="{{ route('admin.blog.index') }}" 
                           class="bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-700 transition-colors mr-4">
                            Clear Filters
                        </a>
                    @endif
                    <a href="{{ route('admin.blog.create') }}" 
                       class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                        Create New Post
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>

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