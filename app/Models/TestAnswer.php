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
        if ($this->question_type === 'intelligence_question') {
            $category = IntelligenceTestCategory::query()
                ->where('code', $this->category_name)
                ->first();

            if ($category) {
                $questionByOrder = IntelligenceTestQuestion::query()
                    ->where('category_id', $category->id)
                    ->where('order', $this->question_id)
                    ->first();

                if ($questionByOrder) {
                    return $questionByOrder;
                }
            }

            // Backward compatibility: if question_id is already the real PK.
            return IntelligenceTestQuestion::find($this->question_id);
        }

        $models = [
            'learning_statement' => LearningStyleStatement::class,
            'interest_job' => InterestJob::class,
        ];

        $modelClass = $models[$this->question_type] ?? null;
        
        return $modelClass ? $modelClass::find($this->question_id) : null;
    }
}
