<?php

namespace SpotzCity\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserForgotPassword extends Mailable
{
    use Queueable, SerializesModels;

    protected $user, $link;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$link)
    {
        $this->user = $user;
        $this->link = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_USERNAME'), 'Demo')
            ->subject('Forgot Password Link')
            ->view('mail')
            ->with([
                'link'   => $this->link,
                'user'   => $this->user,
                'logo'   => public_path('public/assets/images/logo-color-small.png'),
            ]);
    }
}
