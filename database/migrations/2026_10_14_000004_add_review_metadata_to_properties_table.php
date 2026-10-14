<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table): void {
            $table->foreignId('seller_verified_by')->nullable()->after('seller_verified')->constrained('users')->nullOnDelete();
            $table->timestamp('seller_verified_at')->nullable()->after('seller_verified_by');
            $table->string('seller_verification_reference', 255)->nullable()->after('seller_verified_at');
            $table->foreignId('property_reviewed_by')->nullable()->after('property_reviewed')->constrained('users')->nullOnDelete();
            $table->timestamp('property_reviewed_at')->nullable()->after('property_reviewed_by');
            $table->text('admin_review_notes')->nullable()->after('property_reviewed_at');
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('seller_verified_by');
            $table->dropColumn(['seller_verified_at', 'seller_verification_reference']);
            $table->dropConstrainedForeignId('property_reviewed_by');
            $table->dropColumn(['property_reviewed_at', 'admin_review_notes']);
        });
    }
};
