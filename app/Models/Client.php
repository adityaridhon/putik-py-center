<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients';

    protected $appends = [
        'logo_url',
    ];

    protected $fillable = [
        'name',
        'logo',
        'location',
    ];

    public function getLogoUrlAttribute(): ?string
    {
        if (!$this->logo) {
            return null;
        }

        if (str_starts_with($this->logo, 'http://') || str_starts_with($this->logo, 'https://')) {
            return $this->logo;
        }

        if (str_starts_with($this->logo, '/storage/') || str_starts_with($this->logo, 'storage/')) {
            return asset(ltrim($this->logo, '/'));
        }

        return asset('storage/' . ltrim($this->logo, '/'));
    }
}
