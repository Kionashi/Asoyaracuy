<?php
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RetrievePasswordMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->from(('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
        ->subject('Welcome to Enterprise Solutions!')
        ->view('emails.welcome_client');

        return $this;
    }
}