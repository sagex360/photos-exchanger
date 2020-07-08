<?php


namespace App\Events\Users;


abstract class UsersRelatedEvent
{
    protected int $userId;

    /**
     * UserRegistered constructor.
     * @param $userId
     */
    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    abstract public function getUser();
}
