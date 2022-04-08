<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Chapters;
use App\Models\Exams;
use App\Models\Level_subjects;

class Subject extends Model
{
    protected $fillable=['name'];

    public function chapters(){
        return $this->hasMany(Chapters::class, 'subject_id');
    }

    public function exams(){
        return $this->hasMany(Exams::class, 'subject_id');
    }

    public function level_subjects(){
        return $this->hasMany(Level_subjects::class, 'subject_id');
    }


}

