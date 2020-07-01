<?php


namespace App\Repositories\Users;


use App\Models\Client;
use App\Models\File;
use Illuminate\Database\Query\Builder;

final class EloquentUsersRepository implements UsersRepository
{
    public function findByFileId(int $fileId): Client
    {
        return Client::whereHas('files', function ($query) use ($fileId) {
            /**
             * @var Builder|File $query
             */
            return $query->whereId($fileId);
        })->firstOrFail();
    }

    public function findById(int $id): Client
    {
        return Client::findOrFail($id);
    }
}
