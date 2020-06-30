<?php


namespace App\Repositories\Files;


use App\Models\File;
use App\Repositories\FileTokens\Queries\FileLinkTokenQueries;
use Illuminate\Database\Eloquent\Collection;

final class EloquentFilesRepository implements FilesRepository
{
    protected FileLinkTokenQueries $fileLinkTokenQueries;

    public function __construct(FileLinkTokenQueries $fileLinkTokenQueries)
    {
        $this->fileLinkTokenQueries = $fileLinkTokenQueries;
    }

    public function overdue(): Collection
    {
        return File::overdue()->get();
    }

    public function findWithTokensById(int $id): File
    {
        return File::whereId($id)->with([
            'linkTokens' => function ($query) {
                $this->fileLinkTokenQueries->withVisitsCount($query);
            }
        ])->firstOrFail();
    }

    public function findByUserId(int $userId): Collection
    {
        return File::whereUserId($userId)->get();
    }

    public function findById(int $id): File
    {
        return File::findOrFail($id);
    }
}
