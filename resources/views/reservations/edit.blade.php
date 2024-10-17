@extends('layouts.template')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Reservasi</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('failed'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('reservations.update', $reservation->id) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="mb-3">
            <label for="customer_name" class="form-label">Nama Pelanggan</label>
            <input type="text" name="customer_name" id="customer_name" class="form-control" value="{{ old('customer_name', $reservation->customer_name) }}" required>
        </div>

        <div class="mb-3">
            <label for="field_id" class="form-label">Nama Lapangan</label>
            <select name="field_id" id="field_id" class="form-select" required>
                <option value="">Pilih Lapangan</option>
                @foreach($fields as $field)
                    <option value="{{ $field->id }}" {{ $field->id == $reservation->field_id ? 'selected' : '' }}>{{ $field->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="reservation_date" class="form-label">Tanggal Reservasi</label>
            <input type="date" name="reservation_date" id="reservation_date" class="form-control" value="{{ old('reservation_date', $reservation->reservation_date) }}" required>
        </div>

        <div class="mb-3">
            <label for="start_time" class="form-label">Waktu Mulai</label>
            <input type="time" name="start_time" id="start_time" class="form-control" value="{{ old('start_time', $reservation->start_time) }}" required>
        </div>

        <div class="mb-3">
            <label for="end_time" class="form-label">Waktu Selesai</label>
            <input type="time" name="end_time" id="end_time" class="form-control" value="{{ old('end_time', $reservation->end_time) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('reservations.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
