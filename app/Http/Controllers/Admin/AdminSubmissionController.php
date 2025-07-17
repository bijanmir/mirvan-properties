<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserPropertySubmission;
use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSubmissionController extends Controller
{
    /**
     * Display a listing of submissions.
     */
    public function index(Request $request)
    {
        $query = UserPropertySubmission::with('user');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('submission_status', $request->status);
        }

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                    ->orWhere('city', 'like', "%{$searchTerm}%")
                    ->orWhere('contact_name', 'like', "%{$searchTerm}%")
                    ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                        $userQuery->where('name', 'like', "%{$searchTerm}%");
                    });
            });
        }

        // Sort options
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $submissions = $query->paginate(15);

        // Get status counts for filters
        $statusCounts = [
            'all' => UserPropertySubmission::count(),
            'pending' => UserPropertySubmission::pending()->count(),
            'approved' => UserPropertySubmission::approved()->count(),
            'rejected' => UserPropertySubmission::rejected()->count(),
            'needs_revision' => UserPropertySubmission::needsRevision()->count(),
        ];

        return view('admin.submissions.index', compact('submissions', 'statusCounts'));
    }

    /**
     * Display the specified submission.
     */
    public function show(UserPropertySubmission $submission)
    {
        $submission->load('user', 'property', 'reviewer');
        return view('admin.submissions.show', compact('submission'));
    }

    /**
     * Approve a submission and optionally create a property.
     */
    public function approve(Request $request, UserPropertySubmission $submission)
    {
        $request->validate([
            'notes' => 'nullable|string|max:1000',
        ]);

        $submission->approve(auth()->id(), $request->notes);

        // Always create a property from approved submissions
        $property = $this->createPropertyFromSubmission($submission);
        $submission->update(['property_id' => $property->id]);

        return back()->with('success', 'Submission approved and property created successfully.');
    }

    /**
     * Reject a submission.
     */
    public function reject(Request $request, UserPropertySubmission $submission)
    {
        $request->validate([
            'notes' => 'required|string|max:1000',
        ]);

        $submission->reject(auth()->id(), $request->notes);

        return back()->with('success', 'Submission rejected.');
    }

    /**
     * Request revision for a submission.
     */
    public function requestRevision(Request $request, UserPropertySubmission $submission)
    {
        $request->validate([
            'notes' => 'required|string|max:1000',
        ]);

        $submission->requestRevision(auth()->id(), $request->notes);

        return back()->with('success', 'Revision requested. User will be notified.');
    }

    /**
     * Create a property from an approved submission.
     */
    private function createPropertyFromSubmission(UserPropertySubmission $submission)
    {
        $propertyData = [
            'title' => $submission->title,
            'description' => $submission->description,
            'address' => $submission->address,
            'city' => $submission->city,
            'state' => $submission->state,
            'postal_code' => $submission->postal_code,
            'type' => $submission->type,
            'price' => $submission->price,
            'status' => $submission->status,
            'square_footage' => $submission->square_footage,
            'bedrooms' => $submission->bedrooms,
            'bathrooms' => $submission->bathrooms,
            'parking_spaces' => $submission->parking_spaces,
            'year_built' => $submission->year_built,
            'features' => $submission->features,
            'is_featured' => false,
            'is_active' => true,
        ];

        $property = Property::create($propertyData);

        // Handle images if they exist
        if ($submission->images && is_array($submission->images)) {
            foreach ($submission->images as $index => $imagePath) {
                // Copy the image from the submission storage to property storage
                if (Storage::disk('public')->exists($imagePath)) {
                    $newPath = 'properties/' . basename($imagePath);
                    Storage::disk('public')->copy($imagePath, $newPath);

                    PropertyImage::create([
                        'property_id' => $property->id,
                        'image_path' => $newPath,
                        'alt_text' => $property->title . ' - Image ' . ($index + 1),
                        'sort_order' => $index,
                        'is_primary' => $index === 0,
                    ]);
                }
            }
        }

        return $property;
    }
}