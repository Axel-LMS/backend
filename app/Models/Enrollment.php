<?php

namespace App\Models;

use App\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Enrollment extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function cycle()
    {
        return $this->belongsTo(Cycle::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
