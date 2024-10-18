<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\Field;
use Illuminate\Support\Facades\Log;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $reservations = Reservation::with('field')->get(); // Memuat relasi field
        return view('reservations.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    $reservations = Field::all();
    return view('reservations.create', compact('reservations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        
            // Validasi Input
            $request->validate([
                'customer_name' => 'required|string',
                'field_id' => 'required|exists:fields,id',
                'reservation_date' => 'required|date',
                'start_time' => 'required',
                'end_time' => 'required|after:start_time',
            ]);
        
            // Cek apakah ada booking yang bentrok
            $conflict = Reservation::where('field_id', $request->field_id)
                        ->where('reservation_date', $request->reservation_date)
                        ->where(function($query) use ($request) {
                            $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                                  ->orWhereBetween('end_time', [$request->start_time, $request->end_time]);
                        })->exists();
        
            if ($conflict) {
                return redirect()->route('reservations.index')->with('failed', 'Booking gagal, Lapangan sudah di pesan!');
            }
        
            // Simpan booking jika tidak ada bentrok
            Reservation::create($request->all());
        
            return redirect()->route('reservations.index')->with('success', 'Booking berhasil!');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
public function edit($id)
{
    $reservation = Reservation::findOrFail($id);
    $fields = Field::all(); // Ambil semua lapangan

    return view('reservations.edit', compact('reservation', 'fields'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Temukan reservasi berdasarkan ID
        $reservation = Reservation::findOrFail($id);
        
        // Validasi Input
        $validatedData = $request->validate([
            'customer_name' => 'required|string|max:255',
            'field_id' => 'required|exists:fields,id',
            'reservation_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);
        
        // Cek apakah ada booking yang bentrok
        $conflict = Reservation::where('field_id', $validatedData['field_id'])
            ->where('reservation_date', $validatedData['reservation_date'])
            ->where(function($query) use ($validatedData) {
                $query->whereBetween('start_time', [$validatedData['start_time'], $validatedData['end_time']])
                      ->orWhereBetween('end_time', [$validatedData['start_time'], $validatedData['end_time']])
                      ->orWhere(function($query) use ($validatedData) {
                          $query->where('start_time', '<=', $validatedData['start_time'])
                                ->where('end_time', '>=', $validatedData['end_time']);
                      });
            })->exists();
        
        // Jika ada bentrok
        if ($conflict) {
            return redirect()->route('reservations.edit', $reservation->id)
                             ->with('failed', 'Booking gagal, Lapangan sudah dipesan!');
        }

        // Simpan perubahan booking jika tidak ada bentrok
        $reservation->customer_name = $validatedData['customer_name'];
        $reservation->field_id = $validatedData['field_id'];
        $reservation->reservation_date = $validatedData['reservation_date'];
        $reservation->start_time = $validatedData['start_time'];
        $reservation->end_time = $validatedData['end_time'];
        $reservation->save(); // Menyimpan perubahan

        // Redirect dengan pesan sukses
        return redirect()->route('reservations.edit', $reservation->id)
                         ->with('success', 'Booking Berhasil Diperbarui!');
    }
    


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        //
        $reservation->delete();
        return redirect()->route('reservations.index')->with('deleted', 'Reservasi berhasil dihapus!');
    }
}
