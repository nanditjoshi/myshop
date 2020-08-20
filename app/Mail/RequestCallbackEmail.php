<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestCallbackEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The demo object instance.
     *
     * @var ReqeustCallback
     */
    public $reqeustCallback;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reqeustCallback)
    {
        $this->reqeustCallback = $reqeustCallback;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //return $this->view('view.name');
        return $this->from(config('site-config.fromemail'))
            ->view('mails.reqeustcallback');
    }
}
