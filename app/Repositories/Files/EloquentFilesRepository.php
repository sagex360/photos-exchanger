<?php


namespace App\Repositories\Files;


use App\Models\File;
use Illuminate\Database\Eloquent\Collection;

final class EloquentFilesRepository implements FilesRepository
{
    public function overdue(): Collection
    {
        return File::overdue()->get();
    }

    public function find(int $id): File
    {
        return File::findOrFail($id);
    }

    public function findByUserId(int $userId): Collection
    {
        return File::whereUserId($userId)->get();
    }
}
