<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;


class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // リレーション: 1人のユーザーは複数のアイテムを持てる、1つのアイテムは1人のユーザーをもつ（1対多）
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    // リレーション: 1人のユーザーは複数のGroupに所属、1つのグループは複数のユーザーをもつ（多対多）
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'user_group');
    }

    // リレーション: 1人のユーザーは複数のお気に入りを持てる、1つお気に入りは、1人のユーザーを持つ（1対多）
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function categories()
    {
        return $this->hasManyThrough(
            Category::class,  // 最終的に参照するモデル
            Item::class,      // 中間テーブルとなるモデル
            'user_id',        // itemsテーブルでusersを参照する外部キー
            'id',             // categoriesテーブルでitemsを参照する外部キー
            'id',             // usersテーブルのローカルキー
            'category_id'     // itemsテーブルのローカルキー
        );
    }

    public function tags()
    {
        return $this->hasManyThrough(Tag::class, Item::class, 'user_id', 'id', 'id', 'id');
    }

    // public function notifications()
    // {
    //     return $this->morphMany(Notification::class, 'notifiable');
    // }

    public function hasFavorited(Item $item)
    {
        return $this->favoriteItems()->where('item_id', $item->id)->exists();
    }

    public function favoriteItems()
    {
        return $this->belongsToMany(Item::class, 'favorites');
    }
}
