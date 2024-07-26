<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'Landlord2 User',
                'email' => 'landlord2@example.com',
                'password' => Hash::make('password'),
                'phone_number' => '1234567890',
                'role' => 'landlord',
                'image' => 'https://res.cloudinary.com/dv2lhfdnv/image/upload/v1720976348/myHome/cgyvahapaavhsqtqyc6z.png',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Landlord1 User',
                'email' => 'landlord1@example.com',
                'password' => Hash::make('password'),
                'phone_number' => '0987654321',
                'role' => 'landlord',
                'image' => 'https://res.cloudinary.com/dv2lhfdnv/image/upload/v1720976348/myHome/cgyvahapaavhsqtqyc6z.png',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $images = [
            "https://res.cloudinary.com/dv2lhfdnv/image/upload/v1720976214/myHome/rwvbkq0okajbkd6trvqg.png",
            "https://res.cloudinary.com/dv2lhfdnv/image/upload/v1720976294/myHome/j1vvthfrgpavynw7ltca.png",
            "https://res.cloudinary.com/dv2lhfdnv/image/upload/v1720976294/myHome/l7c5weavuagtk0krdjum.png",
            "https://res.cloudinary.com/dv2lhfdnv/image/upload/v1720976294/myHome/a70o05johlcysoppe0gs.png",
            "https://res.cloudinary.com/dv2lhfdnv/image/upload/v1720976293/myHome/fwpj67o4ibzvnurf5zjg.png",
            "https://res.cloudinary.com/dv2lhfdnv/image/upload/v1720976292/myHome/gjbfoweby2cbrnz8qe6h.png"
        ];

        $propertyTypes = ['Apartment', 'Bungalow', 'Storey Building'];
        $listingTypes = ['Silver Listing', 'Gold Listing', 'Platinum Listing'];

        $products = [];

        for ($i = 1; $i <= 20; $i++) {
            $products[] = [
                'property_type' => $propertyTypes[array_rand($propertyTypes)],
                'price' => rand(10000000, 100000000),
                'listing_type' => $listingTypes[array_rand($listingTypes)],
                'listing_date' => now(),
                'recommended' => (bool)rand(0, 1),
                'popular' => (bool)rand(0, 1),
                'location' => 'Lekki Phase 1, Admirality way ' . $i,
                'image_path' => $images[array_rand($images)],
                'erf_size' => 1239,
                'floor_size' => 42,
                'dues_and_levies' => 10000,
                'pet_allowed' => (bool)rand(0, 1),
                'bedrooms' => rand(1, 5),
                'bathrooms' => rand(1, 3),
                'parking_lot' => rand(1, 2),
                'user_id' => rand(1, 2),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert the product records
        DB::table('products')->insert($products);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('products')->truncate();

        DB::table('users')->where('email', 'landlord2@example.com')->delete();
        DB::table('users')->where('email', 'landlord1@example.com')->delete();
    }
};
