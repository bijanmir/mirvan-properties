@extends('layouts.app')

@section('title', $post->title . ' - Mirvan Properties Blog')
@section('meta_description', $post->meta_description ?: $post->excerpt)

@section('content')
<!-- Blog Post Header -->
<section class="bg-white py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        <svg class="w-3 h-3 mr-2.5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                        </svg>
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                        <a href="{{ route('blog.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Blog</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ Str::limit($post->title, 30) }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Post Meta -->
        <div class="flex items-center text-sm text-gray-500 mb-6">
            <time datetime="{{ $post->published_at->toDateString() }}" class="font-medium">
                {{ $post->published_at->format('F j, Y') }}
            </time>
            @if($post->author_name)
                <span class="mx-2">•</span>
                <span>By {{ $post->author_name }}</span>
            @endif
            @if($post->read_time)
                <span class="mx-2">•</span>
                <span>{{ $post->read_time_text }}</span>
            @endif
            <span class="mx-2">•</span>
            <span>{{ $post->views }} views</span>
        </div>

        <!-- Post Title -->
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6 leading-tight">
            {{ $post->title }}
        </h1>

        <!-- Tags -->
        @if($post->tags && count($post->tags) > 0)
            <div class="flex flex-wrap gap-2 mb-8">
                @foreach($post->tags as $tag)
                    <a href="{{ route('blog.tag', $tag) }}" 
                       class="inline-block bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full hover:bg-blue-200 transition-colors">
                        #{{ ucfirst($tag) }}
                    </a>
                @endforeach
            </div>
        @endif

        <!-- Featured Image -->
        @if($post->featured_image_url)
            <div class="mb-8">
                <img src="{{ $post->featured_image_url }}" 
                     alt="{{ $post->featured_image_alt ?? $post->title }}" 
                     class="w-full h-64 md:h-96 object-cover rounded-lg shadow-lg">
            </div>
        @endif
    </div>
</section>

<!-- Blog Post Content -->
<article class="py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-12">
            <!-- Main Content -->
            <div class="lg:col-span-3">
                <!-- Post Excerpt -->
                @if($post->excerpt)
                    <div class="text-xl text-gray-600 mb-8 p-6 bg-gray-50 rounded-lg border-l-4 border-blue-500">
                        {{ $post->excerpt }}
                    </div>
                @endif

                <!-- Post Content -->
                <div class="prose prose-lg max-w-none">
                    {!! nl2br(e($post->content)) !!}
                </div>

                <!-- Share Buttons -->
                <div class="mt-12 pt-8 border-t border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Share this article</h3>
                    <div class="flex space-x-4">
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(request()->url()) }}" 
                           target="_blank"
                           class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                            Twitter
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                           target="_blank"
                           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                            Facebook
                        </a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}" 
                           target="_blank"
                           class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800 transition-colors flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                            LinkedIn
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Author Info -->
                @if($post->author_name)
                    <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">About the Author</h3>
                        <div class="flex items-center mb-3">
                            <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center">
                                <span class="text-gray-600 font-semibold">{{ substr($post->author_name, 0, 1) }}</span>
                            </div>
                            <div class="ml-3">
                                <p class="font-medium text-gray-900">{{ $post->author_name }}</p>
                                <p class="text-sm text-gray-500">Real Estate Expert</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600">
                            Experienced real estate professional with deep knowledge of market trends and investment strategies.
                        </p>
                    </div>
                @endif

                <!-- Related Posts -->
                @if($relatedPosts->count() > 0)
                    <div class="bg-gray-50 rounded-lg p-6 mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Related Articles</h3>
                        <div class="space-y-4">
                            @foreach($relatedPosts as $related)
                                <article class="border-b border-gray-200 last:border-b-0 pb-4 last:pb-0">
                                    @if($related->featured_image_url)
                                        <img src="{{ $related->featured_image_url }}" 
                                             alt="{{ $related->title }}"
                                             class="w-full h-32 object-cover rounded mb-2">
                                    @endif
                                    <h4 class="font-medium text-gray-900 mb-1 hover:text-blue-600 transition-colors">
                                        <a href="{{ route('blog.show', $related) }}">
                                            {{ Str::limit($related->title, 50) }}
                                        </a>
                                    </h4>
                                    <p class="text-xs text-gray-500">
                                        {{ $related->formatted_published_date }}
                                        @if($related->read_time)
                                            • {{ $related->read_time_text }}
                                        @endif
                                    </p>
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Newsletter Signup -->
                <div class="bg-blue-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Stay Updated</h3>
                    <p class="text-sm text-gray-600 mb-4">
                        Subscribe to our newsletter for the latest real estate insights and market updates.
                    </p>
                    <form class="space-y-3">
                        <input type="email" 
                               placeholder="Your email address"
                               class="w-full px-3 py-2 text-sm border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button type="submit" 
                                class="w-full bg-blue-600 text-white text-sm py-2 rounded hover:bg-blue-700 transition-colors">
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</article>

<!-- Navigation to Previous/Next Posts -->
<section class="py-8 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <div class="text-center">
                <a href="{{ route('blog.index') }}" 
                   class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Back to All Articles
                </a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    .prose {
        color: #374151;
        line-height: 1.75;
    }
    
    .prose p {
        margin-bottom: 1.25em;
    }
    
    .prose h2, .prose h3, .prose h4 {
        margin-top: 2em;
        margin-bottom: 1em;
        font-weight: 700;
        color: #111827;
    }
    
    .prose h2 {
        font-size: 1.5em;
    }
    
    .prose h3 {
        font-size: 1.25em;
    }
    
    .prose ul, .prose ol {
        margin: 1.25em 0;
        padding-left: 1.625em;
    }
    
    .prose li {
        margin: 0.5em 0;
    }
    
    .prose blockquote {
        font-style: italic;
        border-left: 4px solid #3B82F6;
        padding-left: 1em;
        margin: 1.5em 0;
        color: #6B7280;
    }
</style>
@endpush