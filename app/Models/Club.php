<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    protected $guarded = [];
    public function coursepercycle()
    {
        return $this->belongsTo(CoursePerCycle::class);
    }
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
    use HasFactory;
}
