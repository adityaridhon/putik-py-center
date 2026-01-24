<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class CompanyProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name', 'headline', 'about', 'logo', 'landing_image',
        'phone', 'email', 'instagram', 'address'
    ];
    protected $appends = ['logo_url', 'landing_image_url'];

    public function getLogoUrlAttribute()
    {
        return $this->logo; // Mengembalikan string path, misal: "company/logo.png"
    }

    public function getLandingImageUrlAttribute()
    {
        return $this->landing_image;
    }
}

