<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price_per_hour' // atau kolom lain yang relevan
    ];

    // Definisikan relasi ke model Reservation
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'field_id'); // Menghubungkan dengan field_id
    }
}
