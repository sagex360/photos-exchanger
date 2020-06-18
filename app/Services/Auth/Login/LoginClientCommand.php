<?php


namespace App\Services\Auth\Login;


use App\DTO\Auth\Login\LoginClientDto;
use App\Events\Users\Auth\LoggedIn\ClientLoggedIn;
use App\Exceptions\UserAuthenticationFailed;
use App\Exceptions\UserNotFoundException;
use App\Models\Client;
use App\Services\Auth\GuardResolver;
use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Events\Dispatcher;

final class LoginClientCommand
{
    /** @var Dispatcher */
    protected $dispatcher;

    /** @var AuthManager */
    protected $authManager;

    /** @var GuardResolver */
    protected $guardResolver;

    /** @var string */
    protected $guard;

    public function __construct(AuthManager $authManager, GuardResolver $guardResolver, Dispatcher $dispatcher)
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
            throw new UserNotFoundException();
        }

        if (!$this->authManager->guard($this->resolveGuard($user))
            ->attempt($dto->credentials(), $dto->remember())
        ) {
            throw new UserAuthenticationFailed();
        }

        $this->dispatcher->dispatch(new ClientLoggedIn($user->id));

        return $user;
    }

    public function getGuard()
    {
        return $this->guard;
    }

    protected function resolveGuard(Client $user)
    {
        $this->guard = $this->guardResolver->resolveGuard($user);

        return $this->guard;
    }
}
