<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['category_image', 'category_name'];
    
    // カテゴリーは複数のアイテムを持つ
    public function items()
    {
        return $this->hasMany(Item::class, 'category_id');
    }

    // カテゴリーは複数のタグを持つ
    public function tags()
    {
        return $this->hasMany(Tag::class, 'category_id');
    }
}
