@extends('layouts.template')

@section('content')
<div class="jumbotron py-4 px-5">
    <h1 class="display-4">
        @if(Auth::check())
        Selamat Datang {{Auth::User()->name}}!
        @else
        Selamat Datang!
        @endif
    </h1>
    <hr class="my-4">
    <p>Tempat terbaik untuk bermain futsal bersama teman atau tim Anda.
    Nikmati fasilitas lengkap dan lapangan berkualitas dengan harga terjangkau.
    Pesan lapangan sekarang dan rasakan pengalaman bermain futsal yang tak terlupakan!.</p>
</div>
@endsection

{{-- <script>
     var calendarEl = document.getElementById('calendar');

     var calendar = new FullCalendar.Calendar(calendarEl, {
         initialView: 'dayGridMonth',
         events: [
             @foreach($reservations as $reservation)
                 {
                     title: '{{ $reservation->customer_name }}',
                     start: '{{ $reservation->reservation_date }}T{{ $reservation->start_time }}',
                     end: '{{ $reservation->reservation_date }}T{{ $reservation->end_time }}',
                     description: 'Lapangan: {{ $reservation->field->name }}',
                     color: 'green'  // Kamu bisa mengubah warna berdasarkan jenis reservasi
                 },
             @endforeach
         ],
         editable: true, // Agar bisa diubah
         droppable: true, // Agar bisa drag-and-drop
     });

     calendar.render();
</script> --}}
