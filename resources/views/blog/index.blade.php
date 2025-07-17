@extends('layouts.app')

@section('title', 'Blog - Mirvan Properties')
@section('meta_description', 'Stay informed with the latest real estate news, market trends, and insights from Mirvan Properties.')

@section('content')
<!-- Blog Header -->
<section class="bg-gradient-to-r from-blue-600 to-purple-600 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center text-white">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                Real Estate Insights
            </h1>
            <p class="text-xl text-blue-100 max-w-2xl mx-auto">
                Stay informed with the latest market trends, investment tips, and industry news
            </p>
        </div>
    </div>
</section>

<!-- Search and Filters -->
<section class="bg-white shadow-lg relative z-10 -mt-8 mx-4 sm:mx-6 lg:mx-8 rounded-lg">
    <div class="max-w-7xl mx-auto px-6 py-8">
        <form method="GET" class="flex flex-col md:flex-row gap-4">
            <!-- Search -->
            <div class="flex-1">
                <label for="search" class="sr-only">Search articles</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" 
                           name="search" 
                           id="search"
                           value="{{ request('search') }}"
                           placeholder="Search articles..."
                           class="pl-10 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
            </div>
            
            <!-- Tag Filter -->
            @if($allTags->count() > 0)
                <div class="md:w-48">
                    <label for="tag" class="sr-only">Filter by tag</label>
                    <select name="tag" id="tag" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Topics</option>
                        @foreach($allTags as $tag)
                            <option value="{{ $tag }}" {{ request('tag') == $tag ? 'selected' : '' }}>
                                {{ ucfirst($tag) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif
            
            <!-- Sort -->
            <div class="md:w-48">
                <label for="sort" class="sr-only">Sort by</label>
                <select name="sort" id="sort" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="published_at" {{ request('sort') == 'published_at' ? 'selected' : '' }}>Latest</option>
                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                    <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Alphabetical</option>
                </select>
            </div>
            
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition-colors">
                Filter
            </button>
        </form>
        
        @if(request()->hasAny(['search', 'tag']))
            <div class="mt-4 flex items-center text-sm text-gray-600">
                <span>Filters applied:</span>
                @if(request('search'))
                    <span class="ml-2 bg-blue-100 text-blue-800 px-2 py-1 rounded">
                        Search: "{{ request('search') }}"
                    </span>
                @endif
                @if(request('tag'))
                    <span class="ml-2 bg-blue-100 text-blue-800 px-2 py-1 rounded">
                        Tag: {{ ucfirst(request('tag')) }}
                    </span>
                @endif
                <a href="{{ route('blog.index') }}" class="ml-3 text-blue-600 hover:text-blue-700">Clear all</a>
            </div>
        @endif
    </div>
</section>

<!-- Blog Content -->
<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-12">
            <!-- Main Content -->
            <div class="lg:col-span-3">
                @if($posts->count() > 0)
                    <!-- Results Count -->
                    <div class="mb-8">
                        <p class="text-gray-600">
                            @if(isset($currentTag))
                                Showing {{ $posts->total() }} articles tagged with "{{ ucfirst($currentTag) }}"
                            @else
                                Showing {{ $posts->firstItem() }} to {{ $posts->lastItem() }} of {{ $posts->total() }} articles
                            @endif
                        </p>
                    </div>
                    
                    <!-- Blog Posts Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                        @foreach($posts as $post)
                            <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
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
                                    </div>
                                @endif
                                
                                <div class="p-6">
                                    <!-- Meta Info -->
                                    <div class="flex items-center text-sm text-gray-500 mb-3">
                                        <time datetime="{{ $post->published_at->toDateString() }}">
                                            {{ $post->formatted_published_date }}
                                        </time>
                                        @if($post->read_time)
                                            <span class="mx-2">•</span>
                                            <span>{{ $post->read_time_text }}</span>
                                        @endif
                                        @if($post->author_name)
                                            <span class="mx-2">•</span>
                                            <span>{{ $post->author_name }}</span>
                                        @endif
                                    </div>
                                    
                                    <!-- Title -->
                                    <h2 class="text-xl font-bold text-gray-900 mb-3 hover:text-blue-600 transition-colors">
                                        <a href="{{ route('blog.show', $post) }}">
                                            {{ $post->title }}
                                        </a>
                                    </h2>
                                    
                                    <!-- Excerpt -->
                                    @if($post->excerpt)
                                        <p class="text-gray-600 mb-4">
                                            {{ $post->excerpt }}
                                        </p>
                                    @endif
                                    
                                    <!-- Tags -->
                                    @if($post->tags && count($post->tags) > 0)
                                        <div class="flex flex-wrap gap-2 mb-4">
                                            @foreach(array_slice($post->tags, 0, 3) as $tag)
                                                <a href="{{ route('blog.tag', $tag) }}" 
                                                   class="inline-block bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded hover:bg-gray-200 transition-colors">
                                                    {{ ucfirst($tag) }}
                                                </a>
                                            @endforeach
                                            @if(count($post->tags) > 3)
                                                <span class="inline-block bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded">
                                                    +{{ count($post->tags) - 3 }} more
                                                </span>
                                            @endif
                                        </div>
                                    @endif
                                    
                                    <!-- Read More -->
                                    <a href="{{ route('blog.show', $post) }}" 
                                       class="inline-flex items-center text-blue-600 font-semibold hover:text-blue-700 transition-colors">
                                        Read More
                                        <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                        </svg>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    @if($posts->hasPages())
                        <div class="flex justify-center">
                            {{ $posts->appends(request()->query())->links() }}
                        </div>
                    @endif
                @else
                    <!-- No Posts Found -->
                    <div class="text-center py-16">
                        <div class="max-w-md mx-auto">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">No articles found</h3>
                            <p class="mt-2 text-sm text-gray-500">
                                @if(request()->hasAny(['search', 'tag']))
                                    We couldn't find any articles matching your criteria. Try adjusting your filters.
                                @else
                                    No articles have been published yet. Check back soon for the latest insights.
                                @endif
                            </p>
                            @if(request()->hasAny(['search', 'tag']))
                                <div class="mt-6">
                                    <a href="{{ route('blog.index') }}" 
                                       class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                                        View All Articles
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Featured Posts -->
                @if($featuredPosts->count() > 0)
                    <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Featured Articles</h3>
                        <div class="space-y-4">
                            @foreach($featuredPosts as $featured)
                                <article class="border-b border-gray-200 last:border-b-0 pb-4 last:pb-0">
                                    <h4 class="font-semibold text-gray-900 mb-1 hover:text-blue-600 transition-colors">
                                        <a href="{{ route('blog.show', $featured) }}">
                                            {{ Str::limit($featured->title, 60) }}
                                        </a>
                                    </h4>
                                    <p class="text-sm text-gray-500">
                                        {{ $featured->formatted_published_date }}
                                        @if($featured->read_time)
                                            • {{ $featured->read_time_text }}
                                        @endif
                                    </p>
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <!-- Popular Tags -->
                @if($allTags->count() > 0)
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h4 class="font-semibold text-gray-900 mb-4">Popular Topics</h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach($allTags->take(10) as $tag)
                                <a href="{{ route('blog.tag', $tag) }}" 
                                   class="inline-block bg-white text-gray-700 text-sm px-3 py-1 rounded hover:bg-gray-100 transition-colors {{ request('tag') == $tag ? 'ring-2 ring-blue-500' : '' }}">
                                    {{ ucfirst($tag) }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection