@extends('layout')

@section('content')
<style>
    /* Content Area Styling */
    .schedule-container { padding: 20px 0; }
    
    /* Table Styling */
    .calendar-table thead th { 
        background-color: #1e3a8a; 
        color: white; 
        text-align: center; 
        border: none; 
        padding: 15px; 
    }
    .calendar-table td { vertical-align: middle; height: 80px; }
    .slot-box { min-height: 50px; display: flex; align-items: center; justify-content: center; }
    
    /* Modal & Buttons */
    .modal-content { border-radius: 20px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.2); }
    .btn-create { 
        background-color: #1e3a8a; 
        color: white; 
        border-radius: 50px; 
        padding: 10px 25px; 
        font-weight: bold; 
        border: none; 
        transition: 0.3s; 
    }
    .btn-create:hover { background-color: #3b82f6; color: white; transform: translateY(-2px); }
    
    .info-badge { background-color: rgba(30, 58, 138, 0.08); color: #1e3a8a; padding: 12px; border-radius: 10px; font-size: 0.9rem; }
    .date-input-group { background: #f0f7ff; padding: 15px; border-radius: 12px; border: 1px dashed #1e3a8a; margin-bottom: 15px; }
</style>

<div class="schedule-container">
    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
        <div class="d-flex align-items-center">
            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                 style="width:65px; height:65px; font-size: 1.6rem; background: linear-gradient(135deg, #1e3a8a, #3b82f6) !important;">
                {{ strtoupper(substr($teacher->name, 0, 1)) }}
            </div>
            <div>
                <h3 class="mb-0 fw-bold">{{ $teacher->name }}</h3>
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <p class="text-muted mb-0"><i class="fas fa-university me-1"></i> {{ $faculty->name }}</p>
                    @if($teacher->office_location)
                        <span class="badge bg-light text-primary border border-primary-subtle px-3 py-2 rounded-pill">
                            <i class="fas fa-map-marker-alt me-1"></i> Office: {{ $teacher->office_location }}
                        </span>
                    @else
                        <span class="text-muted small fst-italic">Office location not specified.</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm mb-4"><i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}</div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-bordered calendar-table mb-0">
                <thead>
                    <tr>
                        <th style="width: 150px;">Time Slot</th>
                        @foreach($days as $day) <th>{{ $day }}</th> @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($slots as $slot)
                    <tr>
                        <td class="text-center fw-bold bg-light text-dark">{{ $slot }}</td>
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
                                                class="btn btn-sm btn-outline-primary w-100 rounded-pill shadow-sm py-2 fw-bold" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#{{ $uniqueId }}">
                                            Send Request
                                        </button>

                                        <div class="modal fade" id="{{ $uniqueId }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content text-start">
                                                    <div class="modal-header border-0">
                                                        <h5 class="modal-title fw-bold">Request Appointment</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    <form action="{{ route('appointment.request') }}" method="POST" onsubmit="return validateDate('{{ $day }}', '{{ $uniqueId }}')">
                                                        @csrf
                                                        <div class="modal-body p-4">
                                                            <div class="info-badge mb-3 text-center">
                                                                <i class="fas fa-info-circle me-2"></i>
                                                                Available every <strong>{{ $day }}</strong> between <strong>{{ $slot }}</strong>.
                                                            </div>

                                                            <div class="date-input-group">
                                                                <label class="form-label fw-bold text-dark"><i class="fas fa-calendar-alt me-1"></i> Specific Date:</label>
                                                                <input type="date" name="appointment_date" class="form-control border-primary appointment-date-input" 
                                                                       min="{{ date('Y-m-d') }}" required>
                                                                <small class="text-muted mt-1 d-block">Please choose a date that falls on a <strong>{{ $day }}</strong>.</small>
                                                            </div>

                                                            <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
                                                            <input type="hidden" name="day" value="{{ $day }}">
                                                            <input type="hidden" name="time_slot" value="{{ $slot }}">

                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold small text-dark">Reason for Meeting:</label>
                                                                <textarea name="student_note" class="form-control border-2 shadow-sm" rows="4" required 
                                                                          placeholder="Briefly describe the purpose of your visit..." 
                                                                          style="border-radius: 12px;"></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer border-0 p-3 bg-light" style="border-radius: 0 0 20px 20px;">
                                                            <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-create px-4 shadow">
                                                                Submit Request
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted small">Not Available</span>
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
    function validateDate(expectedDay, modalId) {
        const modal = document.getElementById(modalId);
        const dateInput = modal.querySelector('.appointment-date-input');
        const selectedDate = new Date(dateInput.value);
        
        // Maps Javascript day index to English day names
        const selectedDayName = selectedDate.toLocaleDateString('en-US', { weekday: 'long' });

        if (selectedDayName !== expectedDay) {
            alert("Error: The date you selected is a " + selectedDayName + ". However, this slot is only available on " + expectedDay + "s. Please pick the correct date.");
            return false;
        }
        return true;
    }
</script>
@endsection