<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ServiceController extends Controller
{
    private function growthPercent(int $current, int $previous): float
    {
        if ($previous === 0) {
            return $current === 0 ? 0.0 : 100.0;
        }

        return (($current - $previous) / $previous) * 100;
    }

    public function index()
    {
        $services = Service::all();
        // Tarik data booking terbaru
        $bookings = Booking::orderBy('booking_date', 'asc')->orderBy('booking_time', 'asc')->get();

        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $previousStartOfWeek = Carbon::now()->subWeek()->startOfWeek();
        $previousEndOfWeek = Carbon::now()->subWeek()->endOfWeek();

        $upcomingCurrentWeek = Booking::query()
            ->whereIn('status', ['pending', 'confirmed'])
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->count();

        $upcomingPreviousWeek = Booking::query()
            ->whereIn('status', ['pending', 'confirmed'])
            ->whereBetween('created_at', [$previousStartOfWeek, $previousEndOfWeek])
            ->count();

        $completedCurrentWeek = Booking::query()
            ->where('status', 'completed')
            ->whereBetween('updated_at', [$startOfWeek, $endOfWeek])
            ->count();

        $completedPreviousWeek = Booking::query()
            ->where('status', 'completed')
            ->whereBetween('updated_at', [$previousStartOfWeek, $previousEndOfWeek])
            ->count();

        $serviceTrends = [
            'janjiMendatang' => $this->growthPercent($upcomingCurrentWeek, $upcomingPreviousWeek),
            'janjiSelesai' => $this->growthPercent($completedCurrentWeek, $completedPreviousWeek),
        ];

        return Inertia::render('admin/manajemen-layanan/Index', [
            'services' => $services,
            'bookings' => $bookings,
            'serviceTrends' => $serviceTrends,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'sometimes|in:0,1,true,false',
        ]);

        $data = [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            // Convert to boolean: 1, "1", true -> 1; 0, "0", false -> 0; default true
            'is_active' => $request->has('is_active') 
                ? (filter_var($request->input('is_active'), FILTER_VALIDATE_BOOLEAN) ? 1 : 0)
                : 1,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        $service = Service::create($data);

        return back()->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'sometimes|in:0,1,true,false',
        ]);

        $data = [];
        
        if ($request->has('name')) {
            $data['name'] = $request->input('name');
        }
        
        if ($request->has('description')) {
            $data['description'] = $request->input('description');
        }
        
        if ($request->has('is_active')) {
            // Convert to boolean: 1, "1", true -> 1; 0, "0", false -> 0
            $data['is_active'] = filter_var($request->input('is_active'), FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
        }

        if ($request->hasFile('image')) {
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        $service->update($data);

        return back()->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(Service $service)
    {
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();

        return back()->with('success', 'Layanan berhasil dihapus.');
    }
}
