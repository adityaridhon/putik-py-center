<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class BookingController extends Controller
{
    public function create()
    {
        // Slot dianggap penuh jika sudah dibooked atau selesai dilayani.
        $bookedSlots = Booking::select('booking_date', 'booking_time', 'status')
            ->whereIn('status', ['confirmed', 'completed'])
            ->get();

        return Inertia::render('user/booking-layanan/Index', [
            'bookedSlots' => $bookedSlots
        ]);
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors([
                'auth' => 'Silakan login terlebih dahulu untuk melakukan booking.',
            ]);
        }

        // 1. Validasi input dari Vue
        $request->validate([
            'nama'       => 'required|string|max:100',
            'hp'         => 'required|string|max:20',
            'kategori'   => 'required|in:children_center,konseling_terapi,pemeriksaan_psikologi',
            'tanggal'    => 'required|date',
            'jam'        => 'required',
        ]);

        // 2. Mapping kategori frontend ke database service_id
        $serviceId = 1;
        if ($request->kategori == 'konseling_terapi') {
            $serviceId = Service::where('name', 'like', '%Konseling%')->first()->id ?? 1;
        } elseif ($request->kategori == 'pemeriksaan_psikologi') {
            $serviceId = Service::where('name', 'like', '%Psikologi%')->first()->id ?? 2;
        } elseif ($request->kategori == 'children_center') {
            $serviceId = Service::where('name', 'like', '%Children%')->first()->id ?? 3;
        }

        $normalizedTime = date('H:i:s', strtotime($request->jam));

        // Cegah booking ke slot yang sudah dibooked/selesai.
        $hasUnavailableSlot = Booking::query()
            ->where('booking_date', $request->tanggal)
            ->where('booking_time', $normalizedTime)
            ->whereIn('status', ['confirmed', 'completed'])
            ->exists();

        if ($hasUnavailableSlot) {
            return back()->withErrors([
                'jam' => 'Jadwal sudah terisi. Silakan pilih jam lain.',
            ]);
        }

        $userId = Auth::id();
        if ($userId === null) {
            return back()->withErrors([
                'auth' => 'User tidak valid. Silakan login ulang lalu coba lagi.',
            ]);
        }

        // 3. Simpan ke Database
        Booking::create([
            'user_id'          => $userId,
            'service_id'       => $serviceId,
            'customer_name'    => $request->nama,
            'customer_phone'   => $request->hp,
            'topic'            => $request->topik,
            'service_category' => $request->kategori,
            'option_type'      => strtolower($request->opsi ?? 'personal'),
            'company_name'     => $request->perusahaan,
            'booking_date'     => $request->tanggal,
            'booking_time'     => $normalizedTime,
            'status'           => 'pending' 
        ]);

        return redirect()->back()->with('success', 'Booking berhasil dibuat!');
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $allowedTransitions = [
            'pending' => ['confirmed', 'cancelled'],
            'confirmed' => ['completed', 'cancelled'],
            'completed' => ['completed'],
            'cancelled' => ['cancelled'],
        ];

        $currentStatus = $booking->status;
        $nextStatus = $validated['status'];

        if (!in_array($nextStatus, $allowedTransitions[$currentStatus] ?? [], true)) {
            return back()->withErrors([
                'status' => 'Transisi status tidak valid.',
            ]);
        }

        // Saat mengonfirmasi, pastikan tidak bentrok dengan slot yang sudah confirmed.
        if ($validated['status'] === 'confirmed') {
            $hasConflict = Booking::query()
                ->where('id', '!=', $booking->id)
                ->where('booking_date', $booking->booking_date)
                ->where('booking_time', $booking->booking_time)
                ->whereIn('status', ['confirmed', 'completed'])
                ->exists();

            if ($hasConflict) {
                return back()->withErrors([
                    'status' => 'Slot ini sudah dikonfirmasi untuk pemesan lain.',
                ]);
            }
        }

        $booking->update([
            'status' => $validated['status'],
        ]);

        return back();
    }
}