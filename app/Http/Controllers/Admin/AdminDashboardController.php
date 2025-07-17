<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\BlogPost;
use App\Models\UserPropertySubmission;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Dashboard Statistics
        $stats = [
            'total_properties' => Property::count(),
            'active_properties' => Property::active()->count(),
            'featured_properties' => Property::featured()->count(),
            'properties_for_sale' => Property::forSale()->count(),
            'properties_for_lease' => Property::forLease()->count(),
            
            'total_blog_posts' => BlogPost::count(),
            'published_posts' => BlogPost::published()->count(),
            'featured_posts' => BlogPost::featured()->count(),
            
            'total_submissions' => UserPropertySubmission::count(),
            'pending_submissions' => UserPropertySubmission::pending()->count(),
            'approved_submissions' => UserPropertySubmission::approved()->count(),
            'rejected_submissions' => UserPropertySubmission::rejected()->count(),
            
            'total_users' => User::count(),
            'admin_users' => User::admins()->count(),
        ];

        // Recent Activities
        $recent_properties = Property::latest()->limit(5)->get();
        $recent_posts = BlogPost::latest()->limit(5)->get();
        $recent_submissions = UserPropertySubmission::with('user')->latest()->limit(5)->get();

        // Monthly Statistics (last 6 months)
        $monthly_stats = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthly_stats[] = [
                'month' => $date->format('M Y'),
                'properties' => Property::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)->count(),
                'blog_posts' => BlogPost::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)->count(),
                'submissions' => UserPropertySubmission::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)->count(),
            ];
        }

        return view('admin.dashboard', compact('stats', 'recent_properties', 'recent_posts', 'recent_submissions', 'monthly_stats'));
    }
}