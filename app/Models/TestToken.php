<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestToken extends Model
{
    protected $fillable = [
        'batch_id',
        'token',
        'is_used',
        'used_at'
    ];

    protected $casts = [
        'is_used' => 'boolean',
        'used_at' => 'datetime'
    ];

    public function batch()
    {
        return $this->belongsTo(TestTokenBatch::class, 'batch_id');
    }
}