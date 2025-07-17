<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@mirvanproperties.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        // Create regular user
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
            'email_verified_at' => now(),
        ]);

        // Sample properties
        $properties = [
            [
                'title' => 'Modern Downtown Office Building',
                'description' => 'A stunning 15-story office building in the heart of downtown. Features modern amenities, high-speed elevators, and panoramic city views. Perfect for businesses looking for a prestigious address.',
                'address' => '123 Business District Ave',
                'city' => 'Los Angeles',
                'state' => 'CA',
                'postal_code' => '90210',
                'type' => 'commercial',
                'price' => 8500000.00,
                'status' => 'for_sale',
                'square_footage' => 45000,
                'parking_spaces' => 120,
                'year_built' => 2020,
                'features' => ['High-speed elevators', 'Central air conditioning', 'Security system', 'Parking garage', 'Conference rooms'],
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'title' => 'Luxury Waterfront Penthouse',
                'description' => 'Exclusive penthouse with breathtaking ocean views. This magnificent residence features floor-to-ceiling windows, a private terrace, and premium finishes throughout.',
                'address' => '456 Ocean View Dr',
                'city' => 'Miami',
                'state' => 'FL',
                'postal_code' => '33101',
                'type' => 'residential',
                'price' => 3200000.00,
                'status' => 'for_sale',
                'square_footage' => 4500,
                'bedrooms' => 4,
                'bathrooms' => 3,
                'parking_spaces' => 2,
                'year_built' => 2019,
                'features' => ['Ocean view', 'Private terrace', 'Concierge service', 'Gym access', 'Wine cellar'],
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'title' => 'Prime Retail Space',
                'description' => 'High-traffic retail location in a popular shopping district. Excellent visibility and foot traffic make this an ideal investment opportunity.',
                'address' => '789 Shopping Center Blvd',
                'city' => 'New York',
                'state' => 'NY',
                'postal_code' => '10001',
                'type' => 'retail',
                'price' => 12000.00,
                'status' => 'for_lease',
                'square_footage' => 2500,
                'parking_spaces' => 15,
                'year_built' => 2015,
                'features' => ['High foot traffic', 'Large storefront windows', 'Loading dock', 'Storage area'],
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'title' => 'Industrial Warehouse Complex',
                'description' => 'Large warehouse facility with multiple loading bays and office space. Perfect for distribution or manufacturing operations.',
                'address' => '321 Industrial Park Way',
                'city' => 'Phoenix',
                'state' => 'AZ',
                'postal_code' => '85001',
                'type' => 'industrial',
                'price' => 2500000.00,
                'status' => 'for_sale',
                'square_footage' => 85000,
                'parking_spaces' => 50,
                'year_built' => 2010,
                'features' => ['Multiple loading bays', 'Office space', 'High ceilings', '24/7 security'],
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'title' => 'Family Home in Suburban Neighborhood',
                'description' => 'Beautiful family home with a large backyard, updated kitchen, and spacious living areas. Located in a quiet, family-friendly neighborhood.',
                'address' => '654 Maple Street',
                'city' => 'Denver',
                'state' => 'CO',
                'postal_code' => '80201',
                'type' => 'residential',
                'price' => 675000.00,
                'status' => 'for_sale',
                'square_footage' => 2800,
                'bedrooms' => 4,
                'bathrooms' => 3,
                'parking_spaces' => 2,
                'year_built' => 2005,
                'features' => ['Updated kitchen', 'Large backyard', 'Fireplace', 'Two-car garage', 'Walk-in closets'],
                'is_featured' => true,
                'is_active' => true,
            ],
        ];

        foreach ($properties as $propertyData) {
            $property = Property::create($propertyData);
            
            // Add some sample images
            PropertyImage::create([
                'property_id' => $property->id,
                'image_path' => 'properties/sample-' . $property->id . '-1.jpg',
                'alt_text' => $property->title . ' - Main view',
                'sort_order' => 1,
                'is_primary' => true,
            ]);
            
            PropertyImage::create([
                'property_id' => $property->id,
                'image_path' => 'properties/sample-' . $property->id . '-2.jpg',
                'alt_text' => $property->title . ' - Interior view',
                'sort_order' => 2,
                'is_primary' => false,
            ]);
        }

        // Sample blog posts
        $blogPosts = [
            [
                'title' => '2024 Real Estate Market Trends: What to Expect',
                'excerpt' => 'Discover the key trends shaping the real estate market this year and how they might affect your investment decisions.',
                'content' => "The real estate market continues to evolve with changing economic conditions and buyer preferences. In this comprehensive analysis, we explore the major trends that are defining 2024.\n\n**Market Predictions**\n\nExperts predict a stabilization in home prices after the volatile period of 2022-2023. Interest rates are expected to level off, providing more predictability for both buyers and sellers.\n\n**Technology Integration**\n\nVirtual tours and AI-powered property recommendations are becoming standard tools in the industry. These technologies are making property searches more efficient and accessible.\n\n**Sustainable Properties**\n\nThere's an increasing demand for eco-friendly properties with energy-efficient features. Green building certifications are becoming a significant factor in property valuations.",
                'featured_image' => 'blog/market-trends-2024.jpg',
                'is_published' => true,
                'is_featured' => true,
                'published_at' => now()->subDays(5),
                'meta_description' => 'Comprehensive analysis of 2024 real estate market trends and predictions for investors and homebuyers.',
                'tags' => ['market trends', 'investment', '2024', 'analysis'],
                'author_name' => 'Sarah Johnson',
                'read_time' => 8,
            ],
            [
                'title' => 'Commercial Real Estate Investment Guide',
                'excerpt' => 'Everything you need to know about investing in commercial real estate, from office buildings to retail spaces.',
                'content' => "Commercial real estate investment offers unique opportunities for building wealth and generating passive income. This guide covers the essential aspects of commercial property investment.\n\n**Types of Commercial Properties**\n\n1. Office Buildings - Traditional investments with steady rental income\n2. Retail Spaces - High-traffic locations with potential for appreciation\n3. Industrial Properties - Warehouses and manufacturing facilities\n4. Multi-family Properties - Apartment complexes and condominiums\n\n**Investment Strategies**\n\nSuccessful commercial real estate investment requires careful market analysis, due diligence, and understanding of local zoning laws and regulations.",
                'featured_image' => 'blog/commercial-investment.jpg',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now()->subDays(12),
                'meta_description' => 'Complete guide to commercial real estate investment strategies and opportunities.',
                'tags' => ['commercial', 'investment', 'guide', 'strategy'],
                'author_name' => 'Michael Chen',
                'read_time' => 12,
            ],
            [
                'title' => 'Home Staging Tips That Sell Properties Fast',
                'excerpt' => 'Professional staging techniques that can help you sell your property faster and for a better price.',
                'content' => "Home staging is a powerful tool that can significantly impact how quickly your property sells and the final sale price. Here are proven techniques used by professionals.\n\n**Key Staging Principles**\n\n- Decluttering and depersonalizing spaces\n- Maximizing natural light\n- Creating neutral color schemes\n- Highlighting key features\n\n**Room-by-Room Tips**\n\n**Living Room:** Focus on creating a conversation area with furniture arranged to promote flow and showcase the room's best features.\n\n**Kitchen:** Clear countertops, update hardware if needed, and ensure all appliances are clean and functional.\n\n**Bedrooms:** Use neutral bedding, minimize personal items, and ensure adequate lighting.",
                'featured_image' => 'blog/home-staging.jpg',
                'is_published' => true,
                'is_featured' => true,
                'published_at' => now()->subDays(8),
                'meta_description' => 'Professional home staging tips to sell your property faster and maximize your sale price.',
                'tags' => ['staging', 'selling', 'tips', 'residential'],
                'author_name' => 'Emily Rodriguez',
                'read_time' => 6,
            ],
        ];

        foreach ($blogPosts as $postData) {
            BlogPost::create($postData);
        }

        $this->command->info('Sample data seeded successfully!');
    }
}