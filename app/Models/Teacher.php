<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $guarded = [];
    public function teacherpercourses()
    {
        return $this->hasMany(TeacherPerCourse::class);
    }
    public function clubs()
    {
        return $this->hasMany(Club::class);
    }
    use HasFactory;
}
