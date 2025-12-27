<!DOCTYPE html>
<html>
<head>
    <style>
        .card { border: 1px solid #eee; padding: 20px; font-family: sans-serif; border-radius: 10px; }
        .status-approved { color: #198754; font-weight: bold; }
        .status-rejected { color: #dc3545; font-weight: bold; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Merhaba {{ $appointment->student->name }},</h2>
        <p><strong>{{ $appointment->teacher->name }}</strong> ile olan randevu talebiniz güncellendi.</p>
        
        <p>Durum: 
            <span class="{{ $appointment->status == 'approved' ? 'status-approved' : 'status-rejected' }}">
                {{ $appointment->status == 'approved' ? 'ONAYLANDI' : 'REDDEDİLDİ' }}
            </span>
        </p>

        <p><strong>Tarih:</strong> {{ $appointment->day }}</p>
        <p><strong>Saat:</strong> {{ $appointment->time_slot }}</p>

        <hr>
        <p>Sisteme giriş yaparak detayları kontrol edebilirsiniz.</p>
    </div>
</body>
</html>