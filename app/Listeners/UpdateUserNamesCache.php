<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\UserChanged;
use Illuminate\Support\Facades\Cache;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateUserNamesCache
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
     * @param  \App\Events\UserChanged  $event
     * @return void
     */
    public function handle(UserChanged $event)
    {
        $user_names = User::select('name')->get()->pluck('name')->toArray();
    
        Cache::put('user_names', $user_names, 60);
    }
}
