<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('property_type')->default('plot');
            $table->string('region')->default('Dar es Salaam');
            $table->string('district')->nullable();
            $table->string('ward')->nullable();
            $table->string('neighbourhood')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->decimal('area_square_meters', 12, 2)->nullable();
            $table->char('currency', 3)->default('TZS');
            $table->unsignedBigInteger('price_tzs')->nullable();
            $table->string('status')->default('draft');
            $table->boolean('seller_verified')->default(false);
            $table->boolean('property_reviewed')->default(false);
            $table->timestamp('advertising_permission_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'region', 'district']);
            $table->index(['latitude', 'longitude']);
            $table->index(['price_tzs', 'property_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
