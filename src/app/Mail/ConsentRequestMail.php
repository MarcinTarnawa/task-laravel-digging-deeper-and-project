<?php

namespace App\Mail;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
// use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConsentRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    public $consentUrl;

    public function __construct(Customer $customer, $consentUrl)
    {
        $this->customer = $customer;
        $this->consentUrl = $consentUrl;
    }

    public function build()
    {
        return $this->subject('Potwierdzenie zgody na otrzymywanie faktur drogą elektroniczną')
                    ->markdown('mail.consent-request');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Consent Request Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
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
