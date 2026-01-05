@extends('layoutth')

@section('content')
<style>
    
    .teacher-container { padding: 20px 0; }
    
    
    .card { border-radius: 15px; border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.05); overflow: hidden; }
    .table thead th { background-color: #1e3a8a; color: white; border: none; padding: 15px; font-weight: 600; }
    
   
    .status-none { background-color: #f8f9fa !important; color: #6c757d; }
    .status-available { background-color: #d1e7dd !important; color: #0f5132; font-weight: bold; }
    .status-busy { background-color: #f8d7da !important; color: #842029; }
    .status-lesson { background-color: #fff3cd !important; color: #664d03; }
    
    
    .schedule-select { 
        border: none; 
        background: transparent; 
        cursor: pointer; 
        width: 100%; 
        height: 50px; 
        text-align: center; 
        font-weight: inherit; 
        font-size: 0.85rem;
    }
    .schedule-select:focus { box-shadow: none; outline: 2px solid #1e3a8a; }
    
    .save-btn {
        background: linear-gradient(135deg, #1e3a8a, #3b82f6);
        border: none;
        transition: all 0.3s ease;
    }
    .save-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(30, 58, 138, 0.3);
    }
</style>

<div class="teacher-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0 text-dark">My Weekly Working Schedule</h2>
            <p class="text-muted mb-0">Students can only book appointments for slots marked as <span class="text-success fw-bold">"Available"</span>.</p>
        </div>
        <button id="save-all-btn" class="btn btn-primary btn-lg save-btn rounded-pill px-4 shadow-sm fw-bold">
            <i class="fas fa-save me-2"></i> Save All Changes
        </button>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-bordered mb-0 text-center align-middle">
                <thead>
                    <tr>
                        <th style="width: 140px;">Time Slot</th>
                        @foreach($days as $day) 
                           
                            <th>{{ $day }}</th> 
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
                            <td class="status-{{ $status }} p-0" style="transition: background 0.3s ease;">
                                <select class="form-select form-select-sm schedule-select" 
                                        data-day="{{ $day }}" 
                                        data-slot="{{ $slot }}">
                                    <option value="none" {{ $status == 'none' ? 'selected' : '' }}>- Off -</option>
                                    <option value="available" {{ $status == 'available' ? 'selected' : '' }}>Available for Booking</option>
                                    <option value="busy" {{ $status == 'busy' ? 'selected' : '' }}>Busy / Personal</option>
                                    <option value="lesson" {{ $status == 'lesson' ? 'selected' : '' }}>Class / Lecture</option>
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
    // Live color update when select value changes
    $('.schedule-select').on('change', function() {
        let status = $(this).val();
        $(this).closest('td').removeClass('status-none status-available status-busy status-lesson').addClass('status-' + status);
    });

    // Bulk Save Logic
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
        const originalHtml = btn.html();
        btn.html('<i class="fas fa-spinner fa-spin me-2"></i> Saving...').prop('disabled', true);

        $.ajax({
            url: "{{ route('teacher.update.schedule.bulk') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                schedules: scheduleData
            },
            success: function(response) {
                alert("Your weekly schedule has been successfully updated.");
                btn.html(originalHtml).prop('disabled', false);
            },
            error: function(xhr) {
                alert("Error: " + (xhr.responseJSON?.message || "Internal Server Error"));
                btn.html(originalHtml).prop('disabled', false);
            }
        });
    });
</script>
@endsection