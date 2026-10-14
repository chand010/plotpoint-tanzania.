<?php

namespace Tests\Feature;

use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertyDiscoveryTest extends TestCase
{
    use RefreshDatabase;

    public function test_unreviewed_properties_are_not_shown_in_public_search(): void
    {
        Property::query()->create([
            'title' => 'Hidden draft plot',
            'slug' => 'hidden-draft-plot',
            'property_type' => 'plot',
            'region' => 'Dar es Salaam',
            'price_tzs' => 12000000,
            'status' => 'published',
            'seller_verified' => true,
            'property_reviewed' => false,
            'advertising_permission_at' => now(),
        ]);

        $this->get(route('properties.index'))
            ->assertOk()
            ->assertDontSee('Hidden draft plot');
    }

    public function test_fully_reviewed_property_can_appear_in_search_and_detail(): void
    {
        $property = Property::query()->create([
            'title' => 'Reviewed Kigamboni Plot',
            'slug' => 'reviewed-kigamboni-plot',
            'property_type' => 'plot',
            'region' => 'Dar es Salaam',
            'district' => 'Kigamboni',
            'price_tzs' => 15000000,
            'status' => 'published',
            'seller_verified' => true,
            'property_reviewed' => true,
            'advertising_permission_at' => now(),
        ]);

        $this->get(route('properties.index'))
            ->assertOk()
            ->assertSee('Reviewed Kigamboni Plot');

        $this->get(route('properties.show', $property))
            ->assertOk()
            ->assertSee('Reviewed Kigamboni Plot');
    }

    public function test_unreviewed_property_detail_returns_not_found(): void
    {
        $property = Property::query()->create([
            'title' => 'Unreviewed Listing',
            'slug' => 'unreviewed-listing',
            'property_type' => 'plot',
            'region' => 'Dar es Salaam',
            'status' => 'published',
            'seller_verified' => true,
            'property_reviewed' => false,
        ]);

        $this->get(route('properties.show', $property))->assertNotFound();
    }
}
