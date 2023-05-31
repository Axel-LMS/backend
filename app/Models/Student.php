<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Enrollment;

class Student extends Model
{
    protected $guarded = [];
    use HasFactory;
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
