<?php

namespace App\Listeners;

use Illuminate\Auth\Events\RemoveUserEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendRemoveUserNotification
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
     * @param  \Illuminate\Auth\Events\RemoveUserEvent  $event
     * @return void
     */
    public function handle(RemoveUserEvent $event)
    {
        //
    }
}
