<?php

namespace App\Jobs;

use App\Mail\BlogPublishedEmail;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class BlogPublishMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $blogPost;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($blogPost)
    {
        $this->blogPost = $blogPost;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = User::get();

        foreach ($users as $user) {
            Mail::to($user->email)->send(new BlogPublishedEmail($this->blogPost, $user));
        }
    }
}
