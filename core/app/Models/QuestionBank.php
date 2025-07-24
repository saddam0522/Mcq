<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionBank extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];
    protected $fillable = ['name', 'year', 'created_by', 'updated_by'];

    public function questions()
    {
        return $this->belongsToMany(Question::class)->withTimestamps();
    }

    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
}
