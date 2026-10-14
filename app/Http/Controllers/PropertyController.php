<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PropertyController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'region' => ['nullable', 'string', 'max:100'],
            'district' => ['nullable', 'string', 'max:100'],
            'type' => ['nullable', 'in:plot,land,house,commercial'],
            'min_price' => ['nullable', 'integer', 'min:0'],
            'max_price' => ['nullable', 'integer', 'min:0', 'gte:min_price'],
        ]);

        $query = Property::query()
            ->where('status', 'published')
            ->where('seller_verified', true)
            ->where('property_reviewed', true)
            ->whereNotNull('advertising_permission_at')
            ->with(['media' => fn ($media) => $media->where('media_type', 'photo')->where('is_public', true)->orderBy('sort_order')]);

        if (! empty($filters['q'])) {
            $term = $filters['q'];
            $query->where(function ($builder) use ($term) {
                $builder->where('title', 'ilike', "%{$term}%")
                    ->orWhere('description', 'ilike', "%{$term}%")
                    ->orWhere('neighbourhood', 'ilike', "%{$term}%")
                    ->orWhere('ward', 'ilike', "%{$term}%")
                    ->orWhere('district', 'ilike', "%{$term}%");
            });
        }

        foreach (['region', 'district'] as $field) {
            if (! empty($filters[$field])) {
                $query->where($field, 'ilike', $filters[$field]);
            }
        }

        if (! empty($filters['type'])) {
            $query->where('property_type', $filters['type']);
        }

        if (isset($filters['min_price'])) {
            $query->where('price_tzs', '>=', $filters['min_price']);
        }

        if (isset($filters['max_price'])) {
            $query->where('price_tzs', '<=', $filters['max_price']);
        }

        $properties = $query->latest()->paginate(12)->withQueryString();

        $mapProperties = $properties->getCollection()
            ->filter(fn (Property $property) => $property->latitude !== null && $property->longitude !== null)
            ->map(fn (Property $property) => [
                'title' => $property->title,
                'url' => route('properties.show', $property),
                'lat' => (float) $property->latitude,
                'lng' => (float) $property->longitude,
                'price' => $property->price_tzs,
                'district' => $property->district,
            ])->values();

        return view('properties.index', [
            'properties' => $properties,
            'mapProperties' => $mapProperties,
            'filters' => $filters,
        ]);
    }

    public function show(Property $property): View
    {
        abort_unless(
            $property->status === 'published'
            && $property->seller_verified
            && $property->property_reviewed
            && $property->advertising_permission_at !== null,
            404
        );

        $property->load([
            'media' => fn ($media) => $media->where('media_type', 'photo')->where('is_public', true)->orderBy('sort_order'),
        ]);

        return view('properties.show', compact('property'));
    }
}
