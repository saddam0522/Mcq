<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    public function topics()
    {
        return $this->hasManyThrough(Topic::class, Chapter::class);
    }
    
    public function exams()
    {
        return $this->hasMany(Exam::class, 'subject_id');
    }
}
