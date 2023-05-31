<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $guarded = [];
    use HasFactory;
    public function coursepercycle()
    {
        return $this->belongsTo(coursepercycle::class);
    }
    public function testscores()
    {
        return $this->hasMany(TestScore::class);
    }
}
