@extends('layoutth')

@section('content')
<style>
    .teacher-wrapper { margin-left: 280px; padding: 40px; width: calc(100% - 280px); }
    .card { border-radius: 15px; border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.05); overflow: hidden; }
    .status-none { background-color: #f8f9fa !important; }
    .status-available { background-color: #d1e7dd !important; color: #0f5132; font-weight: bold; }
    .status-busy { background-color: #f8d7da !important; color: #842029; }
    .status-lesson { background-color: #fff3cd !important; color: #664d03; }
    .schedule-select { border: none; background: transparent; cursor: pointer; width: 100%; height: 45px; text-align: center; font-weight: inherit; }
    .schedule-select:focus { box-shadow: none; }
    .table thead th { background-color: #212529; color: white; border: none; padding: 15px; }
</style>

<div class="teacher-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0 text-dark">Haftalık Çalışma Programım</h2>
            <p class="text-muted mb-0">Öğrenciler burada "Müsait" olarak işaretlediğiniz saatlere randevu alabilir.</p>
        </div>
        <button id="save-all-btn" class="btn btn-danger rounded-pill px-4 shadow-sm fw-bold">
            <i class="fas fa-save me-2"></i>Değişiklikleri Kaydet
        </button>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-bordered mb-0 text-center align-middle">
                <thead>
                    <tr>
                        <th style="width: 150px;">Saat Aralığı</th>
                        @foreach($days as $day) 
                            <th>{{ \Carbon\Carbon::parse($day)->translatedFormat('l') }}</th> 
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($slots as $slot)
                    <tr>
                        <td class="fw-bold bg-light small text-secondary">{{ $slot }}</td>
                        @foreach($days as $day)
                            @php
                                $current = $schedules->where('day', $day)->where('time_slot', $slot)->first();
                                $status = $current ? $current->status : 'none';
                            @endphp
                            <td class="status-{{ $status }} p-0" style="transition: 0.3s;">
                                <select class="form-select form-select-sm schedule-select" 
                                        data-day="{{ $day }}" 
                                        data-slot="{{ $slot }}">
                                    <option value="none" {{ $status == 'none' ? 'selected' : '' }}>- Kapalı -</option>
                                    <option value="available" {{ $status == 'available' ? 'selected' : '' }}>Müsait (Randevu Alınabilir)</option>
                                    <option value="busy" {{ $status == 'busy' ? 'selected' : '' }}>Meşgul</option>
                                    <option value="lesson" {{ $status == 'lesson' ? 'selected' : '' }}>Ders</option>
                                </select>
                            </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Renk değişimini anlık yap
    $('.schedule-select').on('change', function() {
        let status = $(this).val();
        $(this).closest('td').removeClass('status-none status-available status-busy status-lesson').addClass('status-' + status);
    });

    // Toplu kaydetme butonu
    $('#save-all-btn').on('click', function() {
        let scheduleData = [];
        $('.schedule-select').each(function() {
            scheduleData.push({
                day: $(this).data('day'),
                time_slot: $(this).data('slot'),
                status: $(this).val()
            });
        });

        const btn = $(this);
        btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Kaydediliyor...').prop('disabled', true);

        $.ajax({
            url: "{{ route('teacher.update.schedule.bulk') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                schedules: scheduleData
            },
            success: function(response) {
                alert("Haftalık programınız başarıyla güncellendi.");
                btn.html('<i class="fas fa-save me-2"></i>Değişiklikleri Kaydet').prop('disabled', false);
            },
            error: function(xhr) {
                alert("Bir hata oluştu: " + (xhr.responseJSON?.message || "Sunucu hatası"));
                btn.html('<i class="fas fa-save me-2"></i>Değişiklikleri Kaydet').prop('disabled', false);
            }
        });
    });
</script>
@endsection