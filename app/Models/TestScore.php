<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestScore extends Model
{
    protected $guarded = [];
    use HasFactory;
    public function test()
    {
        return $this->belongsTo(Test::class);
    }
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
