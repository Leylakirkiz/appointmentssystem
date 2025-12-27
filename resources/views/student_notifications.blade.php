@extends('layout')

@section('content')
<div class="container-fluid">
    <h3 class="fw-bold mb-4">Bildirim Merkezi</h3>

    @forelse($notifications as $notif)
        <div class="card mb-3 border-0 shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fw-bold mb-1">{{ $notif->teacher->name }} - Randevu Talebi</h6>
                    <small class="text-muted d-block mb-2">{{ $notif->day }} | {{ $notif->time_slot }}</small>
                    
                    @if($notif->status == 'pending')
                        <span class="badge bg-warning text-dark">Onay Bekliyor</span>
                    @elseif($notif->status == 'approved')
                        <span class="badge bg-success">Hoca Onayladı</span>
                    @elseif($notif->status == 'rejected')
                        <span class="badge bg-danger">Hoca Reddetti</span>
                    @elseif($notif->status == 'cancelled')
                        <span class="badge bg-secondary">Siz İptal Ettiniz</span>
                    @endif
                </div>

                @if($notif->status == 'pending' || $notif->status == 'approved')
                    <form action="{{ route('appointment.cancel', $notif->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3" onclick="return confirm('İptal edilsin mi?')">
                            İptal Et
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <p class="text-muted text-center py-5">Bildiriminiz bulunmuyor.</p>
    @endforelse
</div>
@endsection