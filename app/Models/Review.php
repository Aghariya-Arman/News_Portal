<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $table = 'review';
    protected $fillable = ['name', 'review_text', 'rate', 'post_id'];

    // public function post()
    // {
    //     return $this->belongsTo(Post::class, 'post_id', 'id');
    // }
}
