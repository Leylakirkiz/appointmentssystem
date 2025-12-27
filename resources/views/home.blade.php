@extends('layout')

@section('title', 'Ana Sayfa')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">Merhaba, {{ Auth::user()->name }}! 👋</h2>
            <p class="text-secondary">Bugün yeni bir görüşme planlamak ister misin?</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6 col-lg-4">
            <div class="card p-4 text-center h-100">
                <div class="mb-3 text-primary"><i class="fas fa-calendar-check fa-3x"></i></div>
                <h4>Randevu Al</h4>
                <p class="text-muted">Fakülte ve hoca seçerek yeni bir görüşme talebi oluştur.</p>
                <a href="{{ route('createreservations') }}" class="btn btn-primary mt-auto rounded-pill">Hemen Başla</a>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card p-4 text-center h-100">
                <div class="mb-3 text-success"><i class="fas fa-clock fa-3x"></i></div>
                <h4>Randevularım</h4>
                <p class="text-muted">Geçmiş ve bekleyen randevularının durumunu kontrol et.</p>
                <a href="{{ route('student.notifications') }}" class="btn btn-success mt-auto rounded-pill text-white">Listeyi Gör</a>
            </div>
        </div>
    </div>
</div>
@endsection