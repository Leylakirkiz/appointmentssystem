@extends('layoutth')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold text-dark">Hoş Geldiniz, {{ Auth::user()->name }}</h2>
            <p class="text-muted">Sistemdeki güncel durumunuz aşağıda özetlenmiştir.</p>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3">
                <div class="d-flex align-items-center">
                    <div class="p-3 bg-primary bg-opacity-10 text-primary rounded-3 me-3">
                        <i class="fas fa-calendar-check fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-0">Toplam</h6>
                        <h3 class="fw-bold mb-0">{{ $stats['total'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3">
                <div class="d-flex align-items-center text-warning">
                    <div class="p-3 bg-warning bg-opacity-10 rounded-3 me-3">
                        <i class="fas fa-hourglass-half fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-0">Bekleyen</h6>
                        <h3 class="fw-bold mb-0">{{ $stats['pending'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
        </div>

    <div class="card border-0 shadow-sm p-4">
        <h5 class="fw-bold mb-4">Son Onay Bekleyen Talepler</h5>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Öğrenci</th>
                        <th>Tarih</th>
                        <th>Saat</th>
                        <th>İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentAppointments as $app)
                        <tr>
                            <td>{{ $app->student->name }}</td>
                            <td>{{ $app->day }}</td>
                            <td><span class="badge bg-light text-dark">{{ $app->time_slot }}</span></td>
                            <td><a href="{{ route('teacher.notifications') }}" class="btn btn-sm btn-primary rounded-pill">İncele</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center py-4 text-muted">Kayıt yok.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection