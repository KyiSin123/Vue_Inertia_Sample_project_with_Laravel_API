<?php

namespace App\Listeners;

use App\Events\UpdateHistory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PostUpdateHistory
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UpdateHistory $event): void
    {
        info('Post Updated');
    }
}
