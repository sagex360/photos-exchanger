<?php

namespace App\Listeners;

use App\Events\Users\Auth\LoggedOut\ClientLoggedOut;
use Illuminate\Session\Store as Session;

final class InvalidateSession
{
    private Session $session;

    /**
     * Create the event listener.
     *
     * @param  Session  $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * Handle the event.
     *
     * @param  ClientLoggedOut  $event
     * @return void
     */
    public function handle(ClientLoggedOut $event): void
    {
        $this->session->invalidate();
    }
}
