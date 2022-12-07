<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


//Agregamos spatie
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use SoftDeletes;
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'photo',
        'name',
        'document_type',
        'number_id',
        'phone',
        'status',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getIdeintifier()
    {
        return $this->getKey();
    }

    public function getCustomCleaims()
    {
        return [];
    }


    public function estadoname()
    {
        return $this->belongsTo(estado::class, 'status', 'id');
    }

    public function badges($status)
    {
        $map = [
            'NUEVO'      => 'warning',
            'CONFIRMADO' => 'primary',
            'RECHAZADO'  => 'danger',
            'ASOCIADO'   => 'info',
        ];
        return $map[$status] ?? '';
    }
}
