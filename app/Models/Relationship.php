<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relationship extends Model
{
    use HasFactory;
    protected $table    = 'relationship';
    protected $fillable = ['user_id', 'user_assigne_id'];
}
