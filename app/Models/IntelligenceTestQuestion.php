<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntelligenceTestQuestion extends Model
{
    protected $fillable = [
        'category_id',
        'question_text',
        'question_image',
        'question_data',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'option_e',
        'correct_answer',
        'explanation',
        'order',
        'is_active',
    ];

    protected $casts = [
        'question_data' => 'array',
        'is_active' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(IntelligenceTestCategory::class, 'category_id');
    }
}
