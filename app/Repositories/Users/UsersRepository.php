<?php


namespace App\Repositories\Users;


use App\Models\Client;

interface UsersRepository
{
    /**
     * @param  int  $id
     * @return Client
     */
    public function findById(int $id): Client;

    /**
     * @param  int  $fileId
     * @return Client
     */
    public function findByFileId(int $fileId): Client;
}
