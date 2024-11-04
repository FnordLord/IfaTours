<?php

namespace Modules\IfaTours\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    protected $listen = [
        'App\Events\PirepAccepted' => [
            'Modules\IfaTours\Listeners\AwardTourCompletion',
            'Modules\IfaTours\Listeners\MarkTourFlightAsCompleted',
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot()
    {
        parent::boot();
    }
}
