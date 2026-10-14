<?php

namespace Tests\Feature;

use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SellerListingSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_open_seller_workspace(): void
    {
        $this->get(route('seller.properties.create'))
            ->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_save_private_draft_but_it_is_not_public(): void
    {
        $user = User::query()->create([
            'name' => 'Test Seller',
            'email' => 'seller@example.test',
            'password' => Hash::make('a-very-long-test-password'),
            'role' => 'buyer',
            'seller_identity_verified' => false,
        ]);

        $response = $this->actingAs($user)->post(route('seller.properties.store'), [
            'title' => 'Private Kigamboni Plot',
            'description' => 'A residential plot description long enough to satisfy validation and explain the location.',
            'property_type' => 'plot',
            'region' => 'Dar es Salaam',
            'district' => 'Kigamboni',
            'ward' => 'Kibada',
            'latitude' => '-6.82',
            'longitude' => '39.31',
            'area_square_meters' => '400',
            'price_tzs' => '15000000',
            'authority_to_advertise' => '1',
        ]);

        $response->assertRedirect(route('seller.properties.index'));
        $this->assertDatabaseHas('properties', [
            'title' => 'Private Kigamboni Plot',
            'seller_id' => $user->id,
            'status' => 'draft',
            'seller_verified' => false,
            'property_reviewed' => false,
        ]);

        $this->get(route('properties.index'))
            ->assertOk()
            ->assertDontSee('Private Kigamboni Plot');
    }

    public function test_submission_requires_advertising_authority_confirmation(): void
    {
        $user = User::query()->create([
            'name' => 'Test Seller',
            'email' => 'seller2@example.test',
            'password' => Hash::make('a-very-long-test-password'),
            'role' => 'buyer',
            'seller_identity_verified' => false,
        ]);

        $this->actingAs($user)->from(route('seller.properties.create'))
            ->post(route('seller.properties.store'), [
                'title' => 'Missing Consent Plot',
                'description' => 'A residential plot description long enough to satisfy validation and explain the location.',
                'property_type' => 'plot',
                'region' => 'Dar es Salaam',
                'district' => 'Kigamboni',
            ])
            ->assertSessionHasErrors('authority_to_advertise');

        $this->assertDatabaseMissing('properties', ['title' => 'Missing Consent Plot']);
    }
}
