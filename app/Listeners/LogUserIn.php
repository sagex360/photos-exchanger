<?php

namespace App\Listeners;

use App\Events\Users\UsersRelatedEvent;
use App\Services\Auth\GuardResolver;
use Illuminate\Auth\AuthManager;

final class LogUserIn
{
    /**
     * @var AuthManager
     */
    protected $authManager;

    /**
     * @var GuardResolver
     */
    protected $guardResolver;

    /**
     * Create the event listener.
     *
     * @param AuthManager $authManager
     * @param GuardResolver $guardResolver
     */
    public function __construct(AuthManager $authManager, GuardResolver $guardResolver)
    {
        $this->authManager = $authManager;
        $this->guardResolver = $guardResolver;
    }

    /**
     * Handle the event.
     *
     * @param UsersRelatedEvent $event
     * @return void
     */
    public function handle(UsersRelatedEvent $event)
    {
        $user = $event->getUser();

        $this->authManager->guard(
            $this->guardResolver->resolveGuard($user)
        )->login($user);
    }
}
