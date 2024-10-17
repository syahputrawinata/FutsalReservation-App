<!-- resources/views/reservations/create.blade.php -->
@extends('layouts.template')

@section('content')
<div class="container">
    <h2>Booking Lapangan Futsal</h2>

    <form action="{{ route('reservations.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="customer_name" class="form-label">Nama Pelanggan</label>
            <input type="text" name="customer_name" class="form-control" id="customer_name" required>
        </div>
        <div class="mb-3">
            <label for="reservation_date" class="form-label">Tanggal Reservasi</label>
            <input type="date" name="reservation_date" class="form-control" id="reservation_date" required>
        </div>
        <div class="mb-3">
            <label for="start_time" class="form-label">Waktu Mulai</label>
            <input type="time" name="start_time" class="form-control" id="start_time" required>
        </div>
        <div class="mb-3">
            <label for="end_time" class="form-label">Waktu Selesai</label>
            <input type="time" name="end_time" class="form-control" id="end_time" required>
        </div>
        <div class="mb-3">
            <label for="field_id" class="form-label">Pilih Lapangan</label>
            <select name="field_id" class="form-control" id="field_id" required>
                @foreach($reservations as $field)
                    <option value="{{ $field->id }}">{{ $field->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Booking</button>
    </form>
</div>
@endsection
