<?php


namespace App\Services\Auth\Login;


use App\DTO\Auth\Login\LoginClientDto;
use App\Events\Users\Auth\LoggedIn\ClientLoggedIn;
use App\Events\Users\Auth\LoggedOut\ClientLoggedOut;
use App\Exceptions\UserAuthenticationFailed;
use App\Exceptions\UserNotFoundException;
use App\Models\Client;
use App\Services\Auth\GuardResolver;
use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Events\Dispatcher;

final class LoginClientCommand
{
    protected Dispatcher $dispatcher;
    protected AuthManager $authManager;
    protected GuardResolver $guardResolver;

    protected ?string $guard;

    public function __construct(AuthManager $authManager,
                                GuardResolver $guardResolver,
                                Dispatcher $dispatcher)
    {
        $this->authManager = $authManager;
        $this->guardResolver = $guardResolver;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param LoginClientDto $dto
     * @return Client
     * @throws UserNotFoundException
     * @throws UserAuthenticationFailed
     */
    public function login(LoginClientDto $dto): Client
    {
        $user = Client::whereEmail($dto->getLogin())->first();

        if ($user === null) {
            throw new UserNotFoundException("User with login {$dto->getLogin()} not found.");
        }

        if (!$this->authManager->guard($this->resolveGuard($user))
            ->attempt($dto->credentials(), $dto->remember())
        ) {
            throw new UserAuthenticationFailed("Authentication Failed. Wrong login or password.");
        }

        $this->dispatcher->dispatch(new ClientLoggedIn($user->getAuthIdentifier()));

        return $user;
    }

    public function logout(?Authenticatable $user): void
    {
        $this->authManager->guard($this->resolveGuard($user))->logout();

        $this->dispatcher->dispatch(new ClientLoggedOut(optional($user)->getAuthIdentifier()));
    }

    public function getGuard(): string
    {
        return $this->guard;
    }

    protected function resolveGuard(?Authenticatable $user): ?string
    {
        $this->guard = ($user === null) ? null : $this->guardResolver->resolveGuard($user);

        return $this->guard;
    }
}
