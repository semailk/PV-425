<?php

namespace App\Models;

use App\Traits\ScopeFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

/**
 * @property string $category_id
 * @property string $name
 * @property string $description
 * @property string $image
 * @property float $price
 * @method static Builder Filter(Request $request)
 */
class Product extends Model
{
    use HasFactory, SoftDeletes, ScopeFilters;

    protected $fillable = [
      'category_id',
      'name',
      'description',
      'price',
      'image'
    ];

    public function category(): belongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getImageAttribute(): string
    {
        if (!$this->attributes['image']) {
            // http://localhost:8000/ps5i.webp
            return 'ps5i.webp';
        }

        // http://localhost:80000/storage/products/kmckwncknw12cm.jpg
        return $this->attributes['image'];
    }
}
