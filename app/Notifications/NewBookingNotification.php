<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewBookingNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $booking;

    /**
     * Create a new notification instance.
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Booking Baru Masuk')
            ->greeting('Halo Admin,')
            ->line('Ada booking baru yang masuk:')
            ->line('Nama Pelanggan: ' . $this->booking->customer_name)
            ->line('Nomor HP: ' . $this->booking->customer_phone)
            ->line('Kategori Layanan: ' . $this->booking->service_category)
            ->line('Tanggal: ' . $this->booking->booking_date)
            ->line('Jam: ' . $this->booking->booking_time)
            ->line('Topik: ' . ($this->booking->topic ?? 'Tidak ada'))
            ->action('Lihat Detail Booking', url('/admin/bookings/' . $this->booking->id))
            ->line('Silakan periksa dan konfirmasi booking ini.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'customer_name' => $this->booking->customer_name,
            'booking_date' => $this->booking->booking_date,
            'booking_time' => $this->booking->booking_time,
            'target_url' => '/admin/bookings/' . $this->booking->id,
        ];
    }
}
