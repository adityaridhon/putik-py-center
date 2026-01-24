<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    // Masukkan semua nama kolom tabel bookings di sini
    protected $fillable = [
        'service_id', 'user_id', 'psychologist_id', 'recorded_by',
        'customer_name', 'customer_phone', 'topic', 
        'service_category', 'option_type', 'company_name',
        'booking_date', 'booking_time', 'status', 'notes'
    ];

    // Relasi: Satu booking memiliki satu Service
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    // Relasi: Satu booking dimiliki satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
