<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Chapters;

class TrueOrFalse extends Model
{
    use HasFactory;
    protected $fillable = [
        'chapters_id',
        'difficulty',
        'question_text',
        'grade',
        'CorrectAnswer'
    ];

    public function chapter()
    {
        return $this->belongsTo(Chapters::class, 'chapters_id');
    }
}
