<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'image',
        'price',
        'stock_quantity',
    ];

    public static array $sortable = ['id', 'name', 'code', 'created_at', 'updated_at'];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function getImagePath(): string
    {
        return Storage::disk(config('filesystems.default'))->url($this->image);
    }

    public function getCategoryNames(): string
    {
        return $this->categories->pluck('name')->implode(', ');
    }
}
