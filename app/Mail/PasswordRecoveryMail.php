<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PasswordRecoveryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $template;
    public $data;
    public $fromAddress;
    public $fromName;
    public $adminUser;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($template, $data, $fromAddress, $fromName, $adminUser)
    {
        $this->template = $template;
        $this->data = $data;
        $this->fromAddress = $fromAddress;
        $this->fromName = $fromName;
        $this->adminUser = $adminUser;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->fromAddress, $this->fromName)
            ->to($this->adminUser->email, $this->adminUser->fullName())
            ->subject('Password recovery')
            ->view($this->template)
        ;
    }
}
