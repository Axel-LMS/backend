<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function coursebycycles()
    {
        return $this->hasMany(CourseByCycle::class);
    }
    public function coursepercycles()
    {
        return $this->hasMany(CoursePerCycle::class);
    }
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
    public function image()
    {
        return $this->belongsTo(File::class);
    }

}
