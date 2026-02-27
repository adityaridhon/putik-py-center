<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestTokenBatch extends Model
{
    protected $fillable = [
        'test_type',
        'total_tokens',
        'expired_at',
        'note'
    ];

    protected $casts = [
        'expired_at' => 'date'
    ];

    public function tokens()
    {
        return $this->hasMany(TestToken::class, 'batch_id');
    }
}