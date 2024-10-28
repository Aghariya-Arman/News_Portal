<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chating extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['user_id', 'message'];
    protected $table = 'chating';
}
