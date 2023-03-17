<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use App\Events\addNewTextBlog;
use App\Jobs\sendMails;

class sendEmailsToAuthUsers
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(addNewTextBlog $event)
    {
         $authUsers = User::get();
        foreach($authUsers as $_user)
                dispatch(new sendMails($_user->email));


    }
}
