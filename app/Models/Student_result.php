<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Exams;
use App\Models\Student;

class Student_result extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'exams_id',
        'result'
    ];
    public function exam()
    {
        return $this->belongsTo(Exams::class, 'exams_id');
    }
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
