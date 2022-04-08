<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Department;
use App\Models\Student_result;


class Student extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table='students';
    protected $fillable = [
        'student_code',
        'first_name',
        'last_name',
        'email',
        'level',
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

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function student_results()
    {
        return $this->hasMany(Student_result::class, 'student_id');
    }
}
