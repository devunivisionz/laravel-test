<?php

namespace App\Listeners;

use Illuminate\Auth\Events\RemoveUserEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendRemoveUserSMS{
    
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\RemoveUserEvent  $event
     * @return void
     */
    public function handle(RemoveUserEvent $event){

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
