<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['tag_name', 'category_id'];

    // リレーション: タグは1つのカテゴリーに属する
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // リレーション: タグは複数のアイテムに関連付けられる
    public function items()
    {
        return $this->belongsToMany(Item::class, 'item_tag', 'item_id', 'tag_id');
    }
}
