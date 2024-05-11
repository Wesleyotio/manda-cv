<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use MailerSend\LaravelDriver\MailerSendTrait;

class SendCandidate extends Mailable
{
    use Queueable, SerializesModels, MailerSendTrait;

    protected array $candidateData;
    /**
     * Create a new message instance.
     */
    public function __construct($candidateData)
    {
        //
        $this->candidateData = $candidateData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Processo seletivo do candidato '. $this->candidateData['name'] .' iniciado',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.candidate.confirm',
            with:[
                'name' => $this->candidateData['name'],
                'email' => $this->candidateData['email'],
                'phone' => $this->candidateData['phone'],
                'job' => $this->candidateData['job'],
                'education_level' => $this->candidateData['education_level'],
                'obs' => $this->candidateData['obs'], 
    
            ]
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
