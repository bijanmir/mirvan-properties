<?php

namespace App\Http\Controllers;

use App\Models\UserPropertySubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserPropertySubmissionController extends Controller
{
    /**
     * Display a listing of user submissions
     */
    public function index()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $submissions = UserPropertySubmission::where('user_id', Auth::id())
            ->with('property')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('submissions.index', compact('submissions'));
    }

    /**
     * Show the form for creating a new submission
     */
    public function create()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return view('submissions.create');
    }

    /**
     * Store a newly created submission
     */
    public function store(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'type' => 'required|in:residential,commercial,retail,office,industrial,land',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:for_sale,for_lease',
            'square_footage' => 'nullable|numeric|min:0',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'parking_spaces' => 'nullable|integer|min:0',
            'year_built' => 'nullable|integer|min:1800|max:' . (date('Y') + 1),
            'features' => 'nullable|string',
            'contact_name' => 'required|string|max:255',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string|max:20',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Convert features string to array
        $features = [];
        if (!empty($validated['features'])) {
            $features = array_map('trim', explode(',', $validated['features']));
        }

        // Create the submission
        $submission = UserPropertySubmission::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'address' => $validated['address'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'postal_code' => $validated['postal_code'],
            'type' => $validated['type'],
            'price' => $validated['price'],
            'status' => $validated['status'],
            'square_footage' => $validated['square_footage'],
            'bedrooms' => $validated['bedrooms'],
            'bathrooms' => $validated['bathrooms'],
            'parking_spaces' => $validated['parking_spaces'],
            'year_built' => $validated['year_built'],
            'features' => $features,
            'contact_name' => $validated['contact_name'],
            'contact_email' => $validated['contact_email'],
            'contact_phone' => $validated['contact_phone'],
            'submission_status' => 'pending',
        ]);

        // Handle image uploads if any
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('submissions', 'public');
                $images[] = $path;
            }
            $submission->update(['images' => $images]);
        }

        return redirect()
            ->route('submissions.index')
            ->with('success', 'Your property submission has been sent for review!');
    }

    /**
     * Display the specified submission
     */
    public function show(UserPropertySubmission $submission)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Ensure user can only view their own submissions
        if ($submission->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('submissions.show', compact('submission'));
    }

    /**
     * Show the form for editing the specified submission
     */
    public function edit(UserPropertySubmission $submission)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Ensure user can only edit their own submissions
        if ($submission->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if (!$submission->canBeEdited()) {
            return redirect()
                ->route('submissions.index')
                ->with('error', 'This submission cannot be edited.');
        }

        return view('submissions.edit', compact('submission'));
    }

    /**
     * Update the specified submission
     */
    public function update(Request $request, UserPropertySubmission $submission)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Ensure user can only update their own submissions
        if ($submission->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if (!$submission->canBeEdited()) {
            return redirect()
                ->route('submissions.index')
                ->with('error', 'This submission cannot be edited.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'type' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'status' => 'required|string|max:50',
            'square_footage' => 'nullable|numeric|min:0',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'parking_spaces' => 'nullable|integer|min:0',
            'year_built' => 'nullable|integer|min:1800|max:' . (date('Y') + 1),
            'features' => 'nullable|string',
            'contact_name' => 'required|string|max:255',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string|max:20',
        ]);

        // Convert features string to array
        $features = [];
        if (!empty($validated['features'])) {
            $features = array_map('trim', explode(',', $validated['features']));
        }

        // Update the submission
        $submission->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'address' => $validated['address'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'postal_code' => $validated['postal_code'],
            'type' => $validated['type'],
            'price' => $validated['price'],
            'status' => $validated['status'],
            'square_footage' => $validated['square_footage'],
            'bedrooms' => $validated['bedrooms'],
            'bathrooms' => $validated['bathrooms'],
            'parking_spaces' => $validated['parking_spaces'],
            'year_built' => $validated['year_built'],
            'features' => $features,
            'contact_name' => $validated['contact_name'],
            'contact_email' => $validated['contact_email'],
            'contact_phone' => $validated['contact_phone'],
            'submission_status' => 'pending' // Reset to pending when updated
        ]);

        return redirect()
            ->route('submissions.index')
            ->with('success', 'Submission updated successfully!');
    }

    /**
     * Remove the specified submission
     */
    public function destroy(UserPropertySubmission $submission)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Ensure user can only delete their own submissions
        if ($submission->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Only allow deletion if pending or rejected
        if (!in_array($submission->submission_status, ['pending', 'rejected'])) {
            return redirect()
                ->route('submissions.index')
                ->with('error', 'This submission cannot be deleted.');
        }

        $submission->delete();

        return redirect()
            ->route('submissions.index')
            ->with('success', 'Submission deleted successfully!');
    }
}