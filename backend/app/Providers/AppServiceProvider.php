<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Events\ReservationCreated;
use App\Listeners\UpdateUserAndCar;
use Illuminate\Support\Facades\Event;


class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Register event and listener manually
        Event::listen(
            ReservationCreated::class,
            UpdateUserAndCar::class
        );
    }
}
