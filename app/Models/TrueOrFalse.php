<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrueOrFalse extends Model
{
    use HasFactory;
    protected $fillable = [
        'chapters_id',
        'difficulty',
        'question_text',
        'CorrectAnswer'
    ];
}
