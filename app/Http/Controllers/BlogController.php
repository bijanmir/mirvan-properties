<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of blog posts.
     */
    public function index(Request $request)
    {
        $query = BlogPost::published();

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('excerpt', 'like', "%{$searchTerm}%")
                  ->orWhere('content', 'like', "%{$searchTerm}%");
            });
        }

        // Tag filtering
        if ($request->filled('tag')) {
            $query->byTag($request->tag);
        }

        // Sort options
        $sortBy = $request->get('sort', 'published_at');
        $sortOrder = $request->get('order', 'desc');

        switch ($sortBy) {
            case 'popular':
                $query->orderBy('views', 'desc');
                break;
            case 'title':
                $query->orderBy('title', $sortOrder);
                break;
            default:
                $query->orderBy('published_at', 'desc');
        }

        $posts = $query->paginate(12);

        // Get featured posts for sidebar
        $featuredPosts = BlogPost::published()
            ->featured()
            ->limit(3)
            ->get();

        // Get all unique tags for filter
        $allTags = BlogPost::published()
            ->whereNotNull('tags')
            ->get()
            ->pluck('tags')
            ->flatten()
            ->unique()
            ->sort()
            ->values();

        return view('blog.index', compact('posts', 'featuredPosts', 'allTags'));
    }

    /**
     * Display the specified blog post.
     */
    public function show(BlogPost $post)
    {
        // Check if post is published
        if (!$post->is_published || !$post->published_at || $post->published_at->isFuture()) {
            abort(404);
        }

        // Increment views
        $post->incrementViews();

        // Get related posts
        $relatedPosts = BlogPost::published()
            ->where('id', '!=', $post->id)
            ->where(function($query) use ($post) {
                if ($post->tags && count($post->tags) > 0) {
                    foreach ($post->tags as $tag) {
                        $query->orWhereJsonContains('tags', $tag);
                    }
                }
            })
            ->limit(3)
            ->get();

        // If no related posts by tags, get recent posts
        if ($relatedPosts->count() === 0) {
            $relatedPosts = BlogPost::published()
                ->where('id', '!=', $post->id)
                ->recent(3)
                ->get();
        }

        return view('blog.show', compact('post', 'relatedPosts'));
    }

    /**
     * Display posts by tag.
     */
    public function byTag(Request $request, $tag)
    {
        $posts = BlogPost::published()
            ->byTag($tag)
            ->recent()
            ->paginate(12);

        $featuredPosts = BlogPost::published()
            ->featured()
            ->limit(3)
            ->get();

        // Get all unique tags for filter
        $allTags = BlogPost::published()
            ->whereNotNull('tags')
            ->get()
            ->pluck('tags')
            ->flatten()
            ->unique()
            ->sort()
            ->values();

        return view('blog.index', compact('posts', 'featuredPosts', 'allTags'))
            ->with('currentTag', $tag);
    }
}