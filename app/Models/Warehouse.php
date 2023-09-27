<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'currency_id',
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

    public static array $sortable = ['id', 'currency_id', 'code', 'name', 'created_at', 'updated_at'];

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

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function getBadgeForActiveStatus(): string
    {
        return $this->active ? 'bg-green' : 'bg-red';
    }
}
