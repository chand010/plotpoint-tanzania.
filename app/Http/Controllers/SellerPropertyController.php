<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SellerPropertyController extends Controller
{
    public function index(Request $request): View
    {
        $properties = Property::query()
            ->where('seller_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return view('seller.properties.index', compact('properties'));
    }

    public function create(): View
    {
        return view('seller.properties.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:160'],
            'description' => ['required', 'string', 'min:30', 'max:5000'],
            'property_type' => ['required', 'in:plot,land,house,commercial'],
            'region' => ['required', 'string', 'max:100'],
            'district' => ['required', 'string', 'max:100'],
            'ward' => ['nullable', 'string', 'max:100'],
            'neighbourhood' => ['nullable', 'string', 'max:120'],
            'latitude' => ['nullable', 'numeric', 'between:-11.8,-0.9'],
            'longitude' => ['nullable', 'numeric', 'between:29.2,40.5'],
            'area_square_meters' => ['nullable', 'numeric', 'gt:0', 'max:100000000'],
            'price_tzs' => ['nullable', 'integer', 'min:0', 'max:1000000000000'],
            'authority_to_advertise' => ['accepted'],
        ]);

        $slugBase = Str::slug($data['title']);
        $slug = $slugBase.'-'.Str::lower(Str::random(8));

        $property = Property::create([
            'seller_id' => $request->user()->id,
            'title' => $data['title'],
            'slug' => $slug,
            'description' => $data['description'],
            'property_type' => $data['property_type'],
            'region' => $data['region'],
            'district' => $data['district'],
            'ward' => $data['ward'] ?? null,
            'neighbourhood' => $data['neighbourhood'] ?? null,
            'latitude' => $data['latitude'] ?? null,
            'longitude' => $data['longitude'] ?? null,
            'area_square_meters' => $data['area_square_meters'] ?? null,
            'price_tzs' => $data['price_tzs'] ?? null,
            'currency' => 'TZS',
            'status' => 'draft',
            'seller_verified' => false,
            'property_reviewed' => false,
            'advertising_permission_at' => now(),
        ]);

        return redirect()->route('seller.properties.index')
            ->with('status', 'Listing submitted as a private draft. It will not appear in public search until seller and property checks are completed.');
    }
}
