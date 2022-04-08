<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Chapters;
use App\Models\Exams;

class Exams_Question extends Model
{
    use HasFactory;

    protected $fillable=[
        'exams_id',
        'chapters_id',
        'type',
        'difficulty',
        'Question_number'
    ];

    public function exam()
    {
        return $this->belongsTo(Exams::class, 'exams_id');
    }

    public function chapter()
    {
        return $this->belongsTo(Chapters::class, 'chapters_id');
    }
}
