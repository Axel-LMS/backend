<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherPerCourse extends Model
{
    protected $guarded = [];
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
    public function coursepercycle()
    {
        return $this->belongsTo(CoursePerCycle::class);
    }
    use HasFactory;
}
