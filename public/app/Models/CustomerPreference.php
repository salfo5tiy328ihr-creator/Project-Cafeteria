<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerPreference extends Model
{
    protected $fillable = [
        'user_id',
        'favorite_food',
        'favorite_beverage',
        'likes_spicy',
        'dietary_preference',
    ];

    protected $casts = [
        'likes_spicy' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}