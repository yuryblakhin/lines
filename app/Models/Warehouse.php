<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'address',
        'phones',
        'active',
    ];

    protected $casts = [
        'phones' => 'array',
        'active' => 'boolean',
    ];

    public static array $sortable = ['id', 'code', 'name', 'created_at', 'updated_at'];

    public function getPhones(): string
    {
        return implode(', ', $this->phones);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }
}
