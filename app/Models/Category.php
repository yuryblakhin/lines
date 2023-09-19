<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    use HasFactory, NodeTrait;

    protected $fillable = [
        'name',
        'code',
        'description',
        'parent_id',
    ];

    public function getLftName(): string
    {
        return 'left';
    }

    public function getRgtName(): string
    {
        return 'right';
    }

    public static array $sortable = ['id', 'name', 'code', 'created_at', 'updated_at'];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
