@extends('layouts.template')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Pengguna</h1>
    
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('failed'))
        <div class="alert alert-danger">{{ session('failed') }}</div>
    @endif

    <a class="btn btn-primary mb-3" href="{{ route('user.create')}}">Tambah Pengguna</a>

    <table class="table table-bordered table-striped">
        <thead class="thead-light">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($users as $user)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>
                    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('user.delete', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger btn-sm" onclick="showModalDelete('{{ $user->id }}', '{{ $user->name }}')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="">
            @csrf
            @method('DELETE')
            <div class="modal-header">
                <h5 class="modal-title" id="modalDeleteLabel">Hapus Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus pengguna <b id="name-pengguna"></b>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger">Hapus</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('script')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    function showModalDelete(id, name) {
        $('#name-pengguna').text(name);
        $('#modalDelete').modal('show');
        let url = "{{ route('user.delete', ':id') }}";
        url = url.replace(':id', id);
        $("form").attr('action', url);
    }
</script>
@endpush
