<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['tag_name'];

    // リレーション: 1つのタグは複数のアイテムをもつ
    public function items()
    {
        return $this->belongsToMany(Item::class, 'item_tag');
    }
}
