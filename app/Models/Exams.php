<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subject;
use App\Models\Exams_Question;
use App\Models\Student_result;

class Exams extends Model
{
    use HasFactory;

    protected $fillable=[
        'subject_id',
        'start_time',
        'end_time',
        'duration_minutes'
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function exams_questions()
    {
        return $this->hasMany(Exams_Question::class, 'exams_id');
    }
    public function student_results()
    {
        return $this->hasMany(Student_result::class, 'exams_id');
    }
}
