<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level_subjects extends Model
{
    use HasFactory;
    protected $table='level_subjects';
    protected $fillable = [
        'level',
        'department_id',
        'subject_id',
        'professor_id',
    ];
}
