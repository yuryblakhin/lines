<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
    ];

    public static array $sortable = ['id', 'code', 'name', 'created_at', 'updated_at'];

    public function warehouses(): HasMany
    {
        return $this->hasMany(Warehouse::class);
    }
}
