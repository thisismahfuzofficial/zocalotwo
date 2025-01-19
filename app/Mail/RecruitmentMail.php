<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RecruitmentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nouvelle candidature',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.recruitment',
        );
    }

    public function attachments(): array
    {
        $files = [];

        if (isset($this->data['cv_file'])) {
            $files[] = Attachment::fromStorage($this->data['cv_file']);
        }

        return $files;
    }
}