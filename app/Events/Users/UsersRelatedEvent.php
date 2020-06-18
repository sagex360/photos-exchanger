<?php


namespace App\Events\Users;


abstract class UsersRelatedEvent
{
    protected $userId;

    /**
     * UserRegistered constructor.
     * @param $userId
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public abstract function getUser();
}
