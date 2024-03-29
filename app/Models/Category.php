<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
    public function image()
    {
        return $this->belongsTo(File::class);
    }
}
