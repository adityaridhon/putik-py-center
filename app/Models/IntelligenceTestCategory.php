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

    // Accessor untuk format durasi
    public function getDurationTextAttribute()
    {
        return $this->duration_minutes . ' Menit';
    }

    // Accessor untuk format jumlah soal
    public function getTotalQuestionsTextAttribute()
    {
        return $this->total_questions . ' Soal';
    }

    // Accessor untuk format tipe jawaban
    public function getAnswerTypeTextAttribute()
    {
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
