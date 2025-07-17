<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\PropertyInquiry;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::active()->with('images');

        // Apply filters
        if ($request->filled('type')) {
            $query->byType($request->type);
        }

        if ($request->filled('status')) {
            if ($request->status === 'for_sale') {
                $query->forSale();
            } elseif ($request->status === 'for_lease') {
                $query->forLease();
            }
        }

        if ($request->filled('min_price') || $request->filled('max_price')) {
            $query->priceRange($request->min_price, $request->max_price);
        }

        if ($request->filled('location')) {
            $query->byLocation($request->location);
        }

        if ($request->filled('min_sqft')) {
            $query->where('square_footage', '>=', $request->min_sqft);
        }

        if ($request->filled('bedrooms')) {
            $query->where('bedrooms', '>=', $request->bedrooms);
        }

        // Sort properties
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');

        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'featured':
                $query->orderBy('is_featured', 'desc')->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy($sortBy, $sortOrder);
        }

        $properties = $query->paginate(12);

        // Get filter options for dropdowns
        $propertyTypes = Property::active()->distinct()->pluck('type');
        $cities = Property::active()->distinct()->pluck('city');

        return view('properties.index', compact('properties', 'propertyTypes', 'cities'));
    }

    public function filter(Request $request)
    {
        // This method handles HTMX filter requests
        $query = Property::active()->with('images');

        // Apply the same filters as index method
        if ($request->filled('type')) {
            $query->byType($request->type);
        }

        if ($request->filled('status')) {
            if ($request->status === 'for_sale') {
                $query->forSale();
            } elseif ($request->status === 'for_lease') {
                $query->forLease();
            }
        }

        if ($request->filled('min_price') || $request->filled('max_price')) {
            $query->priceRange($request->min_price, $request->max_price);
        }

        if ($request->filled('location')) {
            $query->byLocation($request->location);
        }

        if ($request->filled('min_sqft')) {
            $query->where('square_footage', '>=', $request->min_sqft);
        }

        if ($request->filled('bedrooms')) {
            $query->where('bedrooms', '>=', $request->bedrooms);
        }

        // Sort properties
        $sortBy = $request->get('sort', 'created_at');
        
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'featured':
                $query->orderBy('is_featured', 'desc')->orderBy('created_at', 'desc');
                break;
        }

        $properties = $query->paginate(12);

        // Return only the properties grid partial for HTMX
        return view('properties.partials.grid', compact('properties'));
    }

    public function show(Property $property)
    {
        // Increment views
        $property->incrementViews();

        // Load relationships
        $property->load(['images' => function($query) {
            $query->orderBy('sort_order');
        }]);

        // Get related properties
        $relatedProperties = Property::active()
            ->where('id', '!=', $property->id)
            ->where(function($query) use ($property) {
                $query->where('type', $property->type)
                      ->orWhere('city', $property->city);
            })
            ->limit(3)
            ->get();

        return view('properties.show', compact('property', 'relatedProperties'));
    }

    public function inquiry(Request $request, Property $property)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string|max:1000',
        ]);

        // Send inquiry email
        try {
            Mail::to('info@mirvanproperties.com')->send(
                new PropertyInquiry($property, $request->only(['name', 'email', 'phone', 'message']))
            );

            return back()->with('success', 'Your inquiry has been sent successfully. We will contact you soon.');
        } catch (\Exception $e) {
            return back()->with('error', 'There was an error sending your inquiry. Please try again.');
        }
    }
}