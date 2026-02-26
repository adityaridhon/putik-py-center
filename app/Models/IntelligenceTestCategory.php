<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntelligenceTestCategory extends Model
{
    protected $fillable = [
        'code',
        'name',
        'question_type',
        'answer_type',
        'total_questions',
        'duration_minutes',
        'description',
        'instruction',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $appends = [
        'duration_text',
        'total_questions_text',
        'answer_type_text',
    ];

    public function questions()
    {
        return $this->hasMany(IntelligenceTestQuestion::class, 'category_id')->orderBy('order');
    }

    public function getDurationTextAttribute()
    {
        return $this->duration_minutes . ' Menit';
    }

    public function getTotalQuestionsTextAttribute()
    {
        return $this->total_questions . ' Soal';
    }

    public function getAnswerTypeTextAttribute()
    {
        // Jika text/isian
        if ($this->answer_type === 'text') {
            return 'Isian Singkat';
        }
        
        // Jikapilgan
        $types = [
            'text' => 'Pilihan Ganda (Teks)',
            'numeric' => 'Pilihan Ganda (Numerik)',
            'series' => 'Pilihan Ganda (Deret Angka)',
            'image' => 'Pilihan Ganda (Gambar)',
            'classification' => 'Pilihan Ganda (Klasifikasi Kata)',
            'memory' => 'Pilihan Ganda (Memori)',
        ];
        
        return $types[$this->question_type] ?? 'Pilihan Ganda (Teks)';
    }
}
