<?php

namespace Tests\Feature;

use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertyScopeTest extends TestCase
{
    use RefreshDatabase;

    public function test_by_location_scope_respects_active_properties(): void
    {
        $active = Property::create([
            'title' => 'Active Property',
            'slug' => 'active-property',
            'description' => 'A lovely active property.',
            'address' => '123 Main St',
            'city' => 'Sample City',
            'state' => 'NY',
            'postal_code' => '10001',
            'country' => 'USA',
            'type' => 'residential',
            'price' => 100000,
            'status' => 'for_sale',
            'is_active' => true,
        ]);

        $inactive = Property::create([
            'title' => 'Inactive Property',
            'slug' => 'inactive-property',
            'description' => 'An inactive property.',
            'address' => '456 Side St',
            'city' => 'Another City',
            'state' => 'NY',
            'postal_code' => '10002',
            'country' => 'USA',
            'type' => 'residential',
            'price' => 90000,
            'status' => 'for_sale',
            'is_active' => false,
        ]);

        $results = Property::active()->byLocation('NY')->pluck('id');

        $this->assertTrue($results->contains($active->id));
        $this->assertFalse($results->contains($inactive->id));
    }
}

