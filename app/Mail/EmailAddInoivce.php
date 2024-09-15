<?php

namespace App\Mail;

use App\Models\Section;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailAddInoivce extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    private $invoice_id;
    public function __construct($invoice_id)
    {
        $this->$invoice_id = $invoice_id;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Email Add Inoivce',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
{
    $sections = Section::all();

    return new Content(
        view: 'invoices.add_invoice',
        with: ['sections' => $sections]
    );
}

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
