@extends('layouts.template')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Reservasi</h1>
    
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('failed'))
        <div class="alert alert-danger">{{ session('failed') }}</div>
    @endif
    @if (session('deleted'))
        <div class="alert alert-warning">{{ session('deleted') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="thead-light">
            <tr>
                <th>Nama Pelanggan</th>
                <th>Nama Lapangan</th>
                <th>Tanggal Reservasi</th>
                <th>Waktu Mulai</th>
                <th>Waktu Selesai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservations as $reservation)
            <tr>
                <td>{{ $reservation->customer_name }}</td>
                <td>{{ $reservation->field->name }}</td>
                <td>{{ $reservation->reservation_date }}</td>
                <td>{{ $reservation->start_time }}</td>
                <td>{{ $reservation->end_time }}</td>
                <td>
                    <a href="{{ route('reservations.edit', $reservation->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('reservations.delete', $reservation->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
