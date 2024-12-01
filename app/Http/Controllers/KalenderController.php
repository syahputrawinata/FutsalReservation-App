<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Field;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

class KalenderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
            // Ambil data booking dari database (misal: model Reservation)
    $reservations = Reservation::all();

    // Kirim data ke view
    return view('calendar.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
            // Validasi data
    $validated = $request->validate([
        'customer_name' => 'required',
        'reservation_date' => 'required|date',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i',
    ]);

    // Simpan data booking
    Reservation::create($validated);

    return response()->json(['success' => 'Booking berhasil!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $reservations = Reservation::with('field')->get(); // Mengambil semua reservasi beserta data lapangan
        return view('landing-page', compact('reservations')); // Mengirim data ke view
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
