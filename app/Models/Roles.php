<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Professor;


class Roles extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];

    public function professors()
    {
        return $this->hasMany(Professor::class, 'roles_id');
    }
}
