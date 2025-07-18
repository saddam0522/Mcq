<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $guarded = [];

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    public function scopeMcqQues($query)
    {
        return $query->whereHas('exam', function ($q)
        {
            $q->where('question_type', 1);
        });
    }
}
