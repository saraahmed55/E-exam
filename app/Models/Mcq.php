<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mcq extends Model
{
    use HasFactory;
    protected $fillable = [
        'chapters_id',
        'difficulty',
        'question_text',
        'answer1',
        'answer2',
        'answer3',
        'answer4',
        'CorrectAnswer'
    ];
}
