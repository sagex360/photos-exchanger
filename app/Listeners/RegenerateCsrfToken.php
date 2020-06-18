<?php

namespace App\Listeners;

use App\Events\Users\Auth\ClientLoggedOut;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Session\Store as Session;

class RegenerateCsrfToken
{
    /**
     * @var Session
     */
    protected $session;

    /**
     * Create the event listener.
     *
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * Handle the event.
     *
     * @param ClientLoggedOut $event
     * @return void
     */
    public function handle(ClientLoggedOut $event)
    {
        $this->session->regenerateToken();
    }
}
