<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\UserPropertySubmissionController; // ← CHANGE THIS LINE
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminPropertyController;
use App\Http\Controllers\Admin\AdminBlogController;
use App\Http\Controllers\Admin\AdminSubmissionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Properties
Route::prefix('properties')->name('properties.')->group(function () {
    Route::get('/', [PropertyController::class, 'index'])->name('index');
    Route::get('/filter', [PropertyController::class, 'filter'])->name('filter'); // HTMX endpoint
    Route::get('/{property}', [PropertyController::class, 'show'])->name('show');
    Route::post('/{property}/inquiry', [PropertyController::class, 'inquiry'])->name('inquiry');
});

// Blog
Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('index');
    Route::get('/{post}', [BlogController::class, 'show'])->name('show');
    Route::get('/tag/{tag}', [BlogController::class, 'byTag'])->name('tag');
});

// Contact & About
Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// User Property Submissions (Authenticated) - UPDATED CONTROLLER
Route::middleware(['auth'])->prefix('submissions')->name('submissions.')->group(function () {
    Route::get('/', [UserPropertySubmissionController::class, 'index'])->name('index');
    Route::get('/create', [UserPropertySubmissionController::class, 'create'])->name('create');
    Route::post('/', [UserPropertySubmissionController::class, 'store'])->name('store');
    Route::get('/{submission}', [UserPropertySubmissionController::class, 'show'])->name('show');
    Route::get('/{submission}/edit', [UserPropertySubmissionController::class, 'edit'])->name('edit');
    Route::put('/{submission}', [UserPropertySubmissionController::class, 'update'])->name('update');
    Route::delete('/{submission}', [UserPropertySubmissionController::class, 'destroy'])->name('destroy');
});

// Profile Management Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes (Protected)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Properties Management
    Route::resource('properties', AdminPropertyController::class);
    Route::post('properties/{property}/toggle-featured', [AdminPropertyController::class, 'toggleFeatured'])->name('properties.toggle-featured');
    Route::post('properties/{property}/images', [AdminPropertyController::class, 'uploadImages'])->name('properties.images.store');
    Route::delete('properties/images/{image}', [AdminPropertyController::class, 'deleteImage'])->name('properties.images.destroy');
    
    // Blog Management
    Route::resource('blog', AdminBlogController::class);
    Route::post('blog/{post}/publish', [AdminBlogController::class, 'publish'])->name('blog.publish');
    Route::post('blog/{post}/unpublish', [AdminBlogController::class, 'unpublish'])->name('blog.unpublish');
    Route::post('blog/{post}/toggle-featured', [AdminBlogController::class, 'toggleFeatured'])->name('blog.toggle-featured');
    
    // User Submissions Management
    Route::prefix('submissions')->name('submissions.')->group(function () {
        Route::get('/', [AdminSubmissionController::class, 'index'])->name('index');
        Route::get('/{submission}', [AdminSubmissionController::class, 'show'])->name('show');
        Route::post('/{submission}/approve', [AdminSubmissionController::class, 'approve'])->name('approve');
        Route::post('/{submission}/reject', [AdminSubmissionController::class, 'reject'])->name('reject');
        Route::post('/{submission}/request-revision', [AdminSubmissionController::class, 'requestRevision'])->name('request-revision');
    });
});

// Authentication Routes (Laravel Breeze)
require __DIR__.'/auth.php';