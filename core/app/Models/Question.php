<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    
    public function topics()
    {
        return $this->belongsToMany(Topic::class)->withTimestamps();
    }

    public function chapters()
    {
        return $this->belongsToMany(Chapter::class)->withTimestamps();
    }

    public function questionBanks()
    {
        return $this->belongsToMany(QuestionBank::class)->withTimestamps();
    }

}
