<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Untuk ambil ID user yg login

class BookingController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi Input (Cek kelengkapan data)
        $request->validate([
            'service_id'       => 'required|exists:services,id',
            'customer_name'    => 'required|string|max:100',
            'booking_date'     => 'required|date',
            'booking_time'     => 'required',
            'service_category' => 'required|in:children_center,konseling_terapi,pemeriksaan_psikologi',
            'option_type'      => 'required|in:personal,klasikal',
        ]);

        // 2. Simpan ke Database
        Booking::create([
            'user_id'          => Auth::id(), // Ambil ID user otomatis
            'service_id'       => $request->service_id,
            'customer_name'    => $request->customer_name,
            'customer_phone'   => $request->customer_phone,
            'topic'            => $request->topic,
            'service_category' => $request->service_category,
            'option_type'      => $request->option_type,
            'company_name'     => $request->company_name,
            'booking_date'     => $request->booking_date,
            'booking_time'     => $request->booking_time,
            'status'           => 'pending' // Default status
        ]);

        // 3. Balikkan respon sukses
        return redirect()->back()->with('success', 'Booking berhasil dibuat!');
    }
}