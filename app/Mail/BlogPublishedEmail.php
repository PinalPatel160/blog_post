<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BlogPublishedEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $blog_detail;

    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($blog_detail,$user)
    {
        $this->blog_detail = $blog_detail;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $blog_detail = $this->blog_detail;
        $user = $this->user;
        return $this->subject('BlogPost: Blog Published')->markdown('mail.blog_published_email', compact(['blog_detail','user']));
    }
}
