<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'item_id','notification_type', 'is_read'];

    // リレーション: お気に入りは1人のユーザーをもつ
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
