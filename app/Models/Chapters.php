<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subject;
use App\Models\Exams_Question;
use App\Models\Mcq;
use App\Models\TrueOrFalse;

class Chapters extends Model
{
    protected $fillable=[
        'chapter_number',
        'chapter_name',
        'subject_id'
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function exams_questions()
    {
        return $this->hasMany(Exams_Question::class, 'chapters_id');
    }

    public function mcqs()
    {
        return $this->hasMany(Mcq::class, 'chapters_id');
    }

    public function true_or_falses()
    {
        return $this->hasMany(TrueOrFalse::class, 'chapters_id');
    }
}
