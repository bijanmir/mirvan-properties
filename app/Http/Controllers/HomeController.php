<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured properties
        $featuredProperties = Property::active()
            ->featured()
            ->with(['images' => function($query) {
                $query->orderBy('sort_order');
            }])
            ->limit(6)
            ->get();

        // Get latest published blog posts
        $latestPosts = BlogPost::published()
            ->recent(3)
            ->get();

        return view('home', compact('featuredProperties', 'latestPosts'));
    }
}