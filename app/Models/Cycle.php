<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cycle extends Model
{
    protected $guarded = [];

    public function coursebycycles()
    {
        return $this->hasMany(CourseByCycle::class);
    }
    public function coursepercyeles()
    {
        return $this->hasMany(CoursePerCycle::class);
    }
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
    // public function coursebycycles()
    // {
    //     return $this->belongsToMany(Course::class, 'course_by_cycles', 'cycle_id', 'course_id');
    // }
    use HasFactory;
}
