<?php

namespace Tests\Feature;

use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminPropertyReviewTest extends TestCase
{
    use RefreshDatabase;

    private function makeUser(string $email, string $role = 'buyer'): User
    {
        return User::query()->create([
            'name' => 'Review Tester',
            'email' => $email,
            'password' => Hash::make('a-long-test-password'),
            'role' => $role,
            'seller_identity_verified' => false,
        ]);
    }

    public function test_regular_user_cannot_open_admin_review_queue(): void
    {
        $user = $this->makeUser('buyer@example.test');

        $this->actingAs($user)->get(route('admin.properties.index'))->assertForbidden();
    }

    public function test_admin_can_record_separate_seller_verification(): void
    {
        $admin = $this->makeUser('admin@example.test', 'admin');
        $seller = $this->makeUser('seller-review@example.test');
        $property = Property::query()->create([
            'seller_id' => $seller->id,
            'title' => 'Review Test Plot',
            'slug' => 'review-test-plot',
            'description' => 'Test property for the restricted review workflow.',
            'property_type' => 'plot',
            'region' => 'Dar es Salaam',
            'district' => 'Kigamboni',
            'status' => 'draft',
            'seller_verified' => false,
            'property_reviewed' => false,
        ]);

        $this->actingAs($admin)->post(route('admin.properties.verify-seller', $property), [
            'evidence_reference' => 'CASE-SELLER-001',
            'notes' => 'Identity and authority checks completed against the documented review process.',
        ])->assertRedirect();

        $this->assertDatabaseHas('properties', [
            'id' => $property->id,
            'seller_verified' => true,
            'property_reviewed' => false,
            'seller_verified_by' => $admin->id,
        ]);
        $this->assertDatabaseHas('property_review_audits', [
            'property_id' => $property->id,
            'admin_id' => $admin->id,
            'action' => 'seller_verified',
        ]);
    }
}
