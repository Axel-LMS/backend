<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursePerCycle extends Model
{
    protected $guarded = [];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function cycle()
    {
        return $this->belongsTo(Cycle::class);
    }
    public function teacherpercouses()
    {
        return $this->hasMany(TeacherPerCourse::class);
    }
    public function club()
    {
        return $this->hasMany(Club::class);
    }
    public function tests()
    {
        return $this->hasMany(Test::class);
    }
    use HasFactory;
}
