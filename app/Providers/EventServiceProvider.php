<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        \App\Events\AppointmentCompleted::class => [
            \App\Listeners\GenerateBilling::class,
        ],
        \App\Events\UserActionOccurred::class => [
            \App\Listeners\LogUserAction::class,
        ],
    ];

    // Disable event discovery
    public function shouldDiscoverEvents()
    {
        return false;
    }

    public function boot()
    {
        //
        \Log::info('EventServiceProvider booted for request: ' . request()->fullUrl());
        \Log::info('Registered listeners:', $this->listen);
    }
}