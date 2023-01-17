<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Relationship extends Model
{
    use HasFactory, SoftDeletes;

    protected $table    = 'relationship';
    protected $fillable = ['user_id', 'user_assigne_id', 'deleted_status'];
}
