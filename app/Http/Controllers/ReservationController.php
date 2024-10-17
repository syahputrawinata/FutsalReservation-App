<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\Field;

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
    public function update(Request $request, Reservation $reservation)
    {
        // Validasi Input
        
        $request->validate([
            'customer_name' => 'required|string|max:255', // menambahkan max length
            'field_id' => 'required|exists:fields,id',
            'reservation_date' => 'required|date',
            'start_time' => 'required|date_format:H:i', // memastikan format waktu benar
            'end_time' => 'required|date_format:H:i|after:start_time', // memastikan format dan urutan waktu
        ]);
    
        // Cek apakah ada booking yang bentrok
        $conflict = Reservation::where('field_id', $request->field_id)
                    ->where('reservation_date', $request->reservation_date)
                    ->where(function($query) use ($request) {
                        // Memeriksa apakah ada waktu yang tumpang tindih
                        $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                              ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                              ->orWhere(function($query) use ($request) {
                                  $query->where('start_time', '<=', $request->start_time)
                                        ->where('end_time', '>=', $request->end_time);
                              });
                    })->exists();
    
        // Jika ada bentrok
        if ($conflict) {
            return redirect()->route('reservations.edit', $reservation->id)
                             ->with('failed', 'Booking gagal, Lapangan sudah dipesan!');
        }
    
        // Simpan perubahan booking jika tidak ada bentrok
        $reservation->update($request->only(['customer_name', 'field_id', 'reservation_date', 'start_time', 'end_time']));
    
        // Redirect dengan pesan sukses
        return redirect()->route('reservations.edit', $reservation->id)->with('success', 'Booking berhasil!');
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
