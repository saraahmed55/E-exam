<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Level_subjects;
use App\Models\Roles;

class Professor extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table='professors';
    protected $fillable = [
        'prof_code',
        'first_name',
        'last_name',
        'roles_id',
        'email',
        'department_id',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function level_subjects(){
        return $this->hasMany(Level_subjects::class, 'professor_id');
    }

    public function role()
    {
        return $this->belongsTo(Roles::class, 'roles_id');
    }
}
