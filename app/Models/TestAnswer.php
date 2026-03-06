<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestAnswer extends Model
{
    protected $fillable = [
        'test_session_id',
        'test_type',
        'category_name',
        'question_type',
        'question_id',
        'answer_value',
    ];

    // Relationships
    public function testSession()
    {
        return $this->belongsTo(TestSession::class);
    }

    // Polymorphic relationship to get the actual question
    public function question()
    {
        switch ($this->question_type) {
            case 'intelligence_question':
                return $this->belongsTo(IntelligenceTestQuestion::class, 'question_id');
            case 'learning_statement':
                return $this->belongsTo(LearningStyleStatement::class, 'question_id');
            case 'interest_job':
                return $this->belongsTo(InterestJob::class, 'question_id');
            default:
                return null;
        }
    }

    // Helper method to get question model
    public function getQuestionModel()
    {
        $models = [
            'intelligence_question' => IntelligenceTestQuestion::class,
            'learning_statement' => LearningStyleStatement::class,
            'interest_job' => InterestJob::class,
        ];

        $modelClass = $models[$this->question_type] ?? null;
        
        return $modelClass ? $modelClass::find($this->question_id) : null;
    }
}
