<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\newBlogCreated;
use Mail;
use App\Models\TextBlogs;


class sendMails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $userEmail;
    public function __construct($userEmail)
    {
        $this->userEmail = $userEmail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //here send the email
        $email = new newBlogCreated();
        Mail::to($this->userEmail)->send($email);
    }
}
