<?php


namespace App\Repositories\Files;


use App\Models\File;

final class EloquentFilesRepository implements FilesRepository
{
    public function overdue()
    {
        return File::overdue()->get();
    }
}
