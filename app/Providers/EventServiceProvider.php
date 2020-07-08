<?php

namespace App\Providers;

use App\Events\Users\Auth\LoggedOut\ClientLoggedOut;
use App\Events\Users\Auth\Registered\ClientRegistered;
use App\Listeners\LogUserIn;
use App\Listeners\InvalidateSession;
use App\Listeners\RegenerateCsrfToken;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        ClientRegistered::class => [
            LogUserIn::class,
        ],
        ClientLoggedOut::class  => [
            InvalidateSession::class,
            RegenerateCsrfToken::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot(): void
    {
        parent::boot();

        //
    }
}
