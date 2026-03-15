<?php

namespace App\Mail;

use App\Models\CustomerData;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoicePdfMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $invoice;
    protected $pdfData;

    public function __construct(CustomerData $customerData, $pdfData = null)
    {
        $this->invoice = $customerData;
        $this->pdfData = $pdfData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invoice Pdf Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.invoice-pdf-mail',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        if ($this->pdfData) {
            return [
                Attachment::fromData(fn() => $this->pdfData, 'Faktura.pdf')
                    ->withMime('application/pdf'),
            ];
        }
        return [];
    }
}
