<?php


namespace App\Repositories\FileTokens;


use App\Models\FileLinkToken;

abstract class FileTokensRepository
{
    public abstract function find(string $token): FileLinkToken;
}
