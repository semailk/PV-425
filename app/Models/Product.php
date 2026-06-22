<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $category_id
 * @property string $name
 * @property string $description
 * @property string $image
 * @property float $price
 */
class Product extends Model
{
    use HasFactory, SoftDeletes;

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
}
