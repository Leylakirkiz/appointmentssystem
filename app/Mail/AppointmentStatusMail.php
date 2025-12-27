<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    public function build()
    {
        $statusText = $this->appointment->status == 'approved' ? 'Onaylandı' : 'Reddedildi';
        
        return $this->subject('Randevu Talebiniz Hakkında: ' . $statusText)
                    ->view('emails.appointment_status'); // Birazdan bu tasarımı oluşturacağız
    }
}