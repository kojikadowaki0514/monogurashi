<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = ['group_name'];

    // リレーション: 1つのグループは複数のユーザーに所属
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_group');
    }
}
