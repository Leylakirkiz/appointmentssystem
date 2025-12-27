@extends('layoutth')

@section('content')
<style>
    /* Sidebar genişliğine uyum */
    .reservation-page-wrapper {
        margin-left: 280px; 
        padding: 40px;
        width: calc(100% - 280px);
        background-color: #f8f9fa;
        min-height: 100vh;
    }
    
    .date-card {
        border-radius: 20px;
        overflow: hidden;
        transition: transform 0.3s ease;
    }
    
    .date-card:hover {
        transform: translateY(-5px);
    }

    .date-header {
        background: linear-gradient(135deg, #e63946 0%, #b91c1c 100%);
        color: white;
        padding: 15px 20px;
        border: none;
    }

    .time-badge {
        background-color: #fff5f5;
        color: #e63946;
        border: 1px solid #feb2b2;
        font-weight: 700;
        padding: 8px 12px;
        border-radius: 10px;
        min-width: 110px;
        text-align: center;
    }

    .student-info-name {
        font-weight: 700;
        color: #2d3436;
        font-size: 1.05rem;
    }

    .empty-state {
        background: white;
        border-radius: 30px;
        padding: 60px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
</style>

<div class="reservation-page-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold text-dark mb-1">Onaylı Randevu Takvimim</h2>
            <p class="text-muted">Öğrencilerle planlanmış tüm görüşmelerinizi buradan takip edebilirsiniz.</p>
        </div>
        <div class="text-end">
            <span class="badge bg-danger px-3 py-2 rounded-pill shadow-sm">
                <i class="fas fa-calendar-day me-2"></i>Bugün: {{ now()->translatedFormat('d F Y') }}
            </span>
        </div>
    </div>
    
    @if($reservations->isEmpty())
        <div class="empty-state text-center">
            <div class="mb-4">
                <i class="fas fa-calendar-times fa-4x text-light"></i>
            </div>
            <h4 class="fw-bold text-secondary">Henüz Kayıtlı Randevu Yok</h4>
            <p class="text-muted">Onayladığınız randevular burada tarih sırasına göre listelenecektir.</p>
        </div>
    @else
        <div class="row">
            @foreach($reservations as $dayGroup => $dayReservations)
                @php
                    $firstRes = $dayReservations->first();
                    $dateObj = \Carbon\Carbon::parse($firstRes->appointment_date);
                @endphp
                
                <div class="col-xl-4 col-lg-6 mb-4">
                    <div class="card date-card shadow-sm border-0 h-100">
                        <div class="card-header date-header d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-calendar-check me-2"></i>
                                <span class="fs-5">{{ $dateObj->format('d.m.Y') }}</span>
                            </div>
                            <span class="text-uppercase small fw-bold" style="letter-spacing: 1px;">
                                {{ $dateObj->translatedFormat('l') }}
                            </span>
                        </div>

                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                @foreach($dayReservations as $res)
                                    <div class="list-group-item p-3 border-0 border-bottom">
                                        <div class="d-flex align-items-center">
                                            <div class="time-badge me-3 shadow-sm">
                                                <i class="far fa-clock me-1"></i> {{ $res->time_slot }}
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="student-info-name">{{ $res->student->name }}</div>
                                                <div class="d-flex align-items-center">
                                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill" style="font-size: 0.7rem;">
                                                        <i class="fas fa-check-circle me-1"></i>Onaylı
                                                    </span>
                                                    @if($res->student_note)
                                                        <button class="btn btn-link btn-sm text-info p-0 ms-2 text-decoration-none" 
                                                                title="{{ $res->student_note }}">
                                                            <i class="fas fa-comment-alt"></i> Not
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection