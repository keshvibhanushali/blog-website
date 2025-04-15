<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function favouritedByUser(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favourites', 'post_id', 'user_id');
    }
}
