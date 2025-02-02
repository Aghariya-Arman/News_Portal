<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'image', 'category_id', 'user_id'];

    public function review()
    {
        return $this->hasMany(Review::class, 'post_id', 'id');
    }
}
