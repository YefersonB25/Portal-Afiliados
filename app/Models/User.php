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

class User extends Authenticatable implements MustVerifyEmail
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
        'photo_id',
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

    public function otherColors($id)
    {
        $map = [
            1  => 'red',
            2  => 'blue',
            3  => 'teal',
            4  => 'azure',
            5  => 'cyan',
            6  => 'indigo',
            7  => 'lime',
            8  => 'gray',
            9  => 'pink',
            10 => 'purlple',
        ];
        return $map[$id] ?? '';
    }

    public function rol()
    {
        return $this->belongsTo(ModelsHasRoles::class, 'id', 'model_id');
    }
}
