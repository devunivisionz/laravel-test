<?php

namespace App\Listeners;

use Illuminate\Auth\Events\CreateUserEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendCreateUserSMS{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\CreateUserEvent  $event
     * @return void
     */
    public function handle(CreateUserEvent $event){
        try {
            $user = $event->info;
            if(env('SMS_NOTIFICATION_ENABLE') != true){
                Log::info("SMS NOTIFICATION DISABLED");
            }
        } catch (\Throwable $e) {
            
            $log = [
                'file' => __FILE__,
                'line' => $e->getLine(),
                'function' => __FUNCTION__,
                'msg' => $e->getMessage()
            ];

            Log::error(json_decode($log));
        }
    }
}
