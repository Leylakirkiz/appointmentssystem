<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #e0e0e0; border-radius: 15px; }
        .header { background-color: #f8f9fa; padding: 15px; border-radius: 10px; text-align: center; margin-bottom: 20px; }
        .content { padding: 10px; }
        .details { background-color: #fff9f9; border: 1px dashed #c82333; padding: 15px; border-radius: 10px; margin: 20px 0; }
        .status { font-weight: bold; text-transform: uppercase; padding: 5px 10px; border-radius: 5px; }
        .approved { background-color: #d4edda; color: #155724; }
        .rejected { background-color: #f8d7da; color: #721c24; }
        .footer { font-size: 12px; color: #777; text-align: center; margin-top: 30px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 style="color: #c82333; margin: 0;">Randevu Bildirimi</h2>
        </div>
        
        <div class="content">
            <p>Merhaba <strong>{{ $appointment->student->name }}</strong>,</p>
            
            <p><strong>{{ $appointment->teacher->name }}</strong> ile olan randevu talebiniz hoca tarafından değerlendirildi:</p>

            <div class="details text-center">
                <p><strong>Durum:</strong> 
                    <span class="status {{ $appointment->status == 'approved' ? 'approved' : 'rejected' }}">
                        {{ $appointment->status == 'approved' ? 'Onaylandı' : 'Reddedildi' }}
                    </span>
                </p>
                <p><strong>Tarih:</strong> {{ $appointment->day }}</p>
                <p><strong>Saat:</strong> {{ $appointment->time_slot }}</p>
            </div>

            @if($appointment->status == 'approved')
                <p>✅ Randevunuz onaylanmıştır. Lütfen belirtilen saatte hocanın odasında veya belirtilen platformda hazır bulunun.</p>
            @else
                <p>❌ Üzgünüz, talebiniz şu an için uygun görülmedi. Farklı bir saat dilimi için tekrar talep oluşturabilirsiniz.</p>
            @endif

            <p>İyi çalışmalar dileriz.</p>
        </div>

        <div class="footer">
            <p>Bu mail otomatik olarak gönderilmiştir, lütfen yanıtlamayınız.<br>
            © {{ date('Y') }} {{ config('app.name') }} Randevu Sistemi</p>
        </div>
    </div>
</body>
</html>