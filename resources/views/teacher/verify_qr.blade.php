@extends('layout')

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height: 80vh; margin-left: 0; width: 100%;">
    <div class="card shadow-lg border-0 text-center p-4" style="border-radius: 25px; max-width: 400px; width: 100%;">
        
        @if($appointment->status == 'approved')
            <div class="mb-3">
                <i class="fas fa-check-circle fa-5x text-success"></i>
            </div>
            <h3 class="fw-bold text-success">Geçerli Randevu</h3>
        @elseif($appointment->status == 'completed')
            <div class="mb-3">
                <i class="fas fa-history fa-5x text-info"></i>
            </div>
            <h3 class="fw-bold text-info">Tamamlanmış</h3>
        @else
            <div class="mb-3">
                <i class="fas fa-times-circle fa-5x text-danger"></i>
            </div>
            <h3 class="fw-bold text-danger">Geçersiz Durum</h3>
        @endif

        <hr>

        <div class="text-start mb-4 bg-light p-3 rounded-3">
            <p class="mb-1"><strong>Öğrenci:</strong> {{ $appointment->student->name }}</p>
            <p class="mb-1"><strong>Hoca:</strong> {{ $appointment->teacher->name }}</p>
            <p class="mb-1"><strong>Tarih:</strong> {{ $appointment->day }}</p>
            <p class="mb-1"><strong>Saat:</strong> {{ $appointment->time_slot }}</p>
        </div>

        @if($appointment->status == 'approved')
            <form action="{{ route('appointment.complete', $appointment->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success btn-lg w-100 rounded-pill shadow">
                    <i class="fas fa-user-check me-2"></i> Görüşmeyi Tamamla
                </button>
            </form>
        @endif

        <a href="/" class="btn btn-link text-muted mt-3 text-decoration-none small">Anasayfaya Dön</a>
    </div>
</div>
@endsection