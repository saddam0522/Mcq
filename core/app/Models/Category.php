<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'category_subject');
    }
    
    /**
     * Assign subjects to the category.
     *
     * @param array $subjectIds
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function assignSubjects($subjectIds)
    {
        return $this->subjects()->syncWithoutDetaching($subjectIds);
    }
    /**
     * Sync subjects to the category (remove all existing and assign current).
     *
     * @param array $subjectIds
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function syncSubjects($subjectIds)
    {
        return $this->subjects()->sync($subjectIds);
    }
}
