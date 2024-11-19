<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['category_image', 'category_name'];
    
    // リレーション: 1つのカテゴリーは複数のアイテムを持つ、1つのアイテムは1つのカテゴリーを持つ（1対多）
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
