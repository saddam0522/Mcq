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
        return $this->belongsToMany(Chapter::class, 'question_chapter')->withTimestamps();
    }

    public function questionBanks()
    {
        return $this->belongsToMany(QuestionBank::class)->withTimestamps();
    }
    /**
     * Store a new question with its relations.
     *
     * @param array $data
     * @param int $adminId
     * @return self
     */
    public static function storeWithRelations(array $data, $adminId): self
    {
        // Create the question
        $question = self::create([
            'question_text'   => $data['question_text'],
            'options'         => json_encode($data['options']), // Encode options as JSON
            'correct_answer'  => $data['correct_answer'],
            'explanation'     => $data['explanation'] ?? null,
            'created_by'      => $adminId,
            'updated_by'      => $adminId,
        ]);

        // Attach topics if provided
        if (!empty($data['topic_ids'])) {
            $question->topics()->attach($data['topic_ids'], ['created_by' => $adminId]);
        }

        // Attach chapters if provided
        if (!empty($data['chapter_ids'])) {
            $question->chapters()->attach($data['chapter_ids'], ['created_by' => $adminId]);
        }

        // Attach question banks if provided
        if (!empty($data['question_bank_ids'])) {
            $question->questionBanks()->attach($data['question_bank_ids'], ['created_by' => $adminId]);
        }

        session()->push('questions', $data);
        return $question;
    }

}
