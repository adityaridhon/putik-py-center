<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestSession extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'booking_id',
        'test_token_id',
        'test_type',
        'status',
        'started_at',
        'completed_at',
        'completion_time_minutes',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function token()
    {
        return $this->belongsTo(TestToken::class, 'test_token_id');
    }

    public function answers()
    {
        return $this->hasMany(TestAnswer::class);
    }

    public function report()
    {
        return $this->hasOne(PsychologicalReport::class);
    }

    // Scopes
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePendingAnalysis($query)
    {
        return $query->where('status', 'pending_analysis');
    }

    public function scopeReported($query)
    {
        return $query->where('status', 'reported');
    }

    // Accessors
    public function getHasReportAttribute()
    {
        return $this->report !== null;
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'in_progress' => 'Sedang Berlangsung',
            'completed' => 'Selesai',
            'pending_analysis' => 'Menunggu Analisis',
            'reported' => 'Sudah Dilaporkan',
        ];
        
        return $badges[$this->status] ?? 'Unknown';
    }
}
