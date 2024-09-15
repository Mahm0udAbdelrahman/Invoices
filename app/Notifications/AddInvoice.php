<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AddInvoice extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
   private $invoice_id;
    public function __construct($invoice_id)
    {
        $this->invoice_id = $invoice_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {

         $url = 'http://127.0.0.1:8000/invoice_details/'.$this->invoice_id. '/edit';
        return (new MailMessage)
                    ->subject('اضافة فاتوره جديده')
                    ->line('اضافة فاتوره جديده')
                    ->action('غرض الفاتورة',  $url )
                    ->line('شكرا لاستخدامك   لادارة الفواتير');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
