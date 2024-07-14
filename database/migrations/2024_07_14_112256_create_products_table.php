<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('property_type');
            $table->integer('price');
            $table->string('listing_type');
            $table->timestamp('listing_date');
            $table->boolean('recommended')->default(false)->nullable();
            $table->boolean('popular')->default(false)->nullable();
            $table->string('location');
            $table->string('image_path');
            $table->string('erf_size');
            $table->string('floor_size');
            $table->integer('dues_and_levies');
            $table->boolean('pet_allowed')->default(false);
            $table->integer('bedrooms');
            $table->integer('bathrooms');
            $table->integer('parking_lot');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
