<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Level_subjects;
use App\Models\Student;

class Department extends Model
{
    protected $fillable=['name'];

    public function level_subjects(){
        return $this->hasMany(Level_subjects::class, 'department_id');
    }

    public function students(){
        return $this->hasMany(Student::class, 'department_id');
    }
}
