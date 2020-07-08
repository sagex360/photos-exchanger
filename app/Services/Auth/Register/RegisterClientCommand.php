<?php


namespace App\Services\Auth\Register;


use App\DTO\Auth\Register\RegisterClientDto;
use App\Events\Users\Auth\Registered\ClientRegistered;
use App\Exceptions\UserWithGivenEmailAlreadyExists;
use App\Models\Client;
use App\ValueObjects\ApiToken;
use Illuminate\Contracts\Events\Dispatcher;

final class RegisterClientCommand
{
    protected Dispatcher $dispatcher;

    /**
     * RegisterClientCommand constructor.
     * @param  Dispatcher  $dispatcher
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param  RegisterClientDto  $dto
     * @throws UserWithGivenEmailAlreadyExists
     */
    public function register(RegisterClientDto $dto): void
    {
        $email = $dto->getLogin();
        if (Client::whereEmail($email)->exists()) {
            throw new UserWithGivenEmailAlreadyExists("Email {$email} has already been taken.");
        }

        $client = new Client();
        $client->name = $dto->getName();
        $client->email = $dto->getLogin();
        $client->password = $dto->getPassword();
        $client->api_token = ApiToken::generate();

        if ($client->save()) {
            $this->dispatcher->dispatch(new ClientRegistered($client->id));
        }
    }
}
