@extends('layout')

@section('content')
<style>
    .reserve-wrapper { margin-left: 280px; padding: 40px; width: calc(100% - 280px); }
    .calendar-table thead th { background-color: #333; color: white; text-align: center; border: none; padding: 15px; }
    .calendar-table td { vertical-align: middle; height: 80px; }
    .slot-box { min-height: 50px; display: flex; align-items: center; justify-content: center; }
    .modal-content { border-radius: 20px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.2); }
    .btn-create { background-color: #c82333; color: white; border-radius: 50px; padding: 10px 25px; font-weight: bold; border: none; transition: 0.3s; }
    .btn-create:hover { background-color: #a71d2a; color: white; transform: translateY(-2px); }
    .info-badge { background-color: rgba(200, 35, 51, 0.1); color: #c82333; padding: 10px; border-radius: 10px; font-size: 0.9rem; }
    .date-input-group { background: #fff3f3; padding: 15px; border-radius: 12px; border: 1px dashed #c82333; margin-bottom: 15px; }
</style>

<div class="reserve-wrapper">
    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
        <div class="d-flex align-items-center">
            <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:60px; height:60px; font-size: 1.5rem;">
                {{ strtoupper(substr($teacher->name, 0, 1)) }}
            </div>
            <div>
    <h3 class="mb-0 fw-bold">{{ $teacher->name }}</h3>
    <div class="d-flex align-items-center gap-3">
        <p class="text-muted mb-0"><i class="fas fa-university me-1"></i> {{ $faculty->name }}</p>
        
        @if($teacher->office_location) {{-- office yerine office_location yaptık --}}
    <span class="badge bg-light text-danger border border-danger-subtle px-3 py-2 rounded-pill">
        <i class="fas fa-map-marker-alt me-1"></i> Ofis: {{ $teacher->office_location }}
    </span>
@else
    <span class="text-muted small italic">Ofis bilgisi henüz girilmemiş.</span>
@endif
    </div>
</div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm mb-4">{{ session('error') }}</div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-bordered calendar-table mb-0">
                <thead>
                    <tr>
                        <th style="width: 150px;">Saat</th>
                        @foreach($days as $day) <th>{{ $day }}</th> @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($slots as $slot)
                    <tr>
                        <td class="text-center fw-bold bg-light">{{ $slot }}</td>
                        @foreach($days as $day)
                            @php
                                $sched = $schedules->where('day', $day)->where('time_slot', $slot)->first();
                                $isAvailable = ($sched && $sched->status == 'available');
                                $uniqueId = "popup_" . Str::slug($day) . "_" . str_replace([':', ' '], '', $slot);
                            @endphp
                            <td>
                                <div class="slot-box">
                                    @if($isAvailable)
                                        <button type="button" 
                                                class="btn btn-sm btn-success w-100 rounded-pill shadow-sm py-2 fw-bold" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#{{ $uniqueId }}">
                                            İstek Gönder
                                        </button>

                                        <div class="modal fade" id="{{ $uniqueId }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content text-start">
                                                    <div class="modal-header border-0">
                                                        <h5 class="modal-title fw-bold">Rezervasyon Talebi</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                                                    </div>

                                                    <form action="{{ route('appointment.request') }}" method="POST" onsubmit="return validateDate('{{ $day }}', '{{ $uniqueId }}')">
                                                        @csrf
                                                        <div class="modal-body p-4">
                                                            <div class="info-badge mb-3 text-center">
                                                                <i class="fas fa-clock me-2"></i>
                                                                Her <strong>{{ $day }}</strong> saat <strong>{{ $slot }}</strong> arası müsaitlik.
                                                            </div>

                                                            <div class="date-input-group">
                                                                <label class="form-label fw-bold text-dark"><i class="fas fa-calendar-alt me-1"></i> Hangi Tarih İçin?</label>
                                                                <input type="date" name="appointment_date" class="form-control border-danger appointment-date-input" 
                                                                       min="{{ date('Y-m-d') }}" required>
                                                                <small class="text-muted mt-1 d-block">Lütfen listedeki güne ({{ $day }}) uygun bir tarih seçin.</small>
                                                            </div>

                                                            <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
                                                            <input type="hidden" name="day" value="{{ $day }}">
                                                            <input type="hidden" name="time_slot" value="{{ $slot }}">

                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold small text-dark">Hocaya İletilecek Notunuz:</label>
                                                                <textarea name="student_note" class="form-control border-2 shadow-sm" rows="4" required 
                                                                          placeholder="Görüşme amacınızı kısaca belirtiniz..." 
                                                                          style="border-radius: 12px;"></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer border-0 p-3 bg-light" style="border-radius: 0 0 20px 20px;">
                                                            <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Vazgeç</button>
                                                            <button type="submit" class="btn btn-create px-4 shadow">
                                                                Talebi Gönder
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted small">Uygun Değil</span>
                                    @endif
                                </div>
                            </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Seçilen tarihin tablodaki günle eşleşip eşleşmediğini kontrol eder
    function validateDate(expectedDay, modalId) {
        const modal = document.getElementById(modalId);
        const dateInput = modal.querySelector('.appointment-date-input');
        const selectedDate = new Date(dateInput.value);
        
        // Gün isimlerini eşleştir (İngilizce formatında karşılaştırır)
        const daysMap = {
            'Sunday': 'Sunday', 'Monday': 'Monday', 'Tuesday': 'Tuesday', 
            'Wednesday': 'Wednesday', 'Thursday': 'Thursday', 'Friday': 'Friday', 'Saturday': 'Saturday'
        };

        const selectedDayName = selectedDate.toLocaleDateString('en-US', { weekday: 'long' });

        if (selectedDayName !== expectedDay) {
            alert("Hata: Seçtiğiniz tarih bir " + selectedDayName + " gününe denk geliyor. Ancak bu saat dilimi sadece " + expectedDay + " günleri için uygundur. Lütfen takvimi kontrol edin.");
            return false;
        }
        return true;
    }
</script>
@endsection