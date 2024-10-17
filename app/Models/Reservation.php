<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;  // Pastikan menggunakan trait HasFactory

    protected $fillable = [
        'customer_name', 
        'field_id', 
        'reservation_date', 
        'start_time', 
        'end_time'
    ];

    // Definisikan relasi ke model Field
    public function field()
    {
        return $this->belongsTo(Field::class, 'field_id'); // Menghubungkan dengan field_id
    }
}
