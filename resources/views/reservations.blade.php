@extends('layout')

@section('content')
<div class="container-fluid">
    <h3 class="fw-bold mb-4">Onaylı Randevularım</h3>

    <div class="row">
        @forelse($appointments as $app)
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card border-0 shadow-sm border-start border-5 border-success">
                    <div class="card-body">
                        <h5 class="fw-bold mb-1 text-dark">{{ $app->teacher->name }}</h5>
                        <p class="mb-3 text-muted small">
                            <i class="fas fa-calendar-check me-2 text-success"></i>{{ $app->day }} <br>
                            <i class="fas fa-clock me-2 text-success"></i>{{ $app->time_slot }}
                        </p>
                        
                        {{-- Sadece İptal Butonu Kalsın --}}
                        <form action="{{ route('appointment.cancel', $app->id) }}" method="POST" 
                              onsubmit="return confirm('Bu randevuyu iptal etmek istediğinize emin misiniz?')">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill w-100">
                                <i class="fas fa-times me-1"></i> Randevuyu İptal Et
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <p class="text-muted">Şu an onaylanmış bir randevunuz bulunmuyor.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection