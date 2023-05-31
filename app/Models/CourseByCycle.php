<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseByCycle extends Model
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
    use HasFactory;
}
