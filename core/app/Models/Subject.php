<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $guarded = ['id'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_subject');
    }

    public function getFirstCategoryName()
    {
        return $this->categories()->first()?->name ?? 'Uncategorized';
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
