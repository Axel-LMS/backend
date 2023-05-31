<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $guarded = [];
    use HasFactory;
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function club()
    {
        return $this->belongsTo(Club::class);
    }
}
