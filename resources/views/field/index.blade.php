@extends('layouts.layout')

@section('content')
    <div class="container">
        <h2>Daftar Lapangan Futsal</h2>
        <a href="{{ route('fields.create') }}" class="btn btn-primary">Tambah Lapangan</a>
        <table class="table table-striped mt-4">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Harga per Jam</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($fields as $field)
                    <tr>
                        <td>{{ $field->name }}</td>
                        <td>{{ $field->description }}</td>
                        <td>{{ $field->price_per_hour }}</td>
                        <td>
                            <a href="{{ route('fields.edit', $field->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('fields.destroy', $field->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>    
    </div>
@endsection
