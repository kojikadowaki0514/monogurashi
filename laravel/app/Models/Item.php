<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'category_id', 'item_image', 'item_name', 'location', 'description', 'is_favorite'];

    // リレーション: アイテムは1人のユーザーに属する
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // リレーション: アイテムは1つのカテゴリーに属する
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // リレーション: アイテムは複数のTagを持つ
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'item_tag');
    }
}
