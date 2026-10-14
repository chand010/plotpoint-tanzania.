<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Property extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'seller_id',
        'title',
        'slug',
        'description',
        'property_type',
        'region',
        'district',
        'ward',
        'neighbourhood',
        'latitude',
        'longitude',
        'area_square_meters',
        'currency',
        'price_tzs',
        'status',
        'seller_verified',
        'property_reviewed',
        'advertising_permission_at',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'area_square_meters' => 'decimal:2',
            'price_tzs' => 'integer',
            'seller_verified' => 'boolean',
            'property_reviewed' => 'boolean',
            'advertising_permission_at' => 'datetime',
        ];
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function media(): HasMany
    {
        return $this->hasMany(PropertyMedia::class);
    }
}
