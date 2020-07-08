<?php


namespace App\Events\Users;


use App\Models\Client;

abstract class ClientsRelatedEvents extends UsersRelatedEvent
{
    public function getUser(): Client
    {
        return Client::findOrFail($this->userId);
    }
}
