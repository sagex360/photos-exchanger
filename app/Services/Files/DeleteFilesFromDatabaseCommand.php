<?php


namespace App\Services\Files;


use App\Models\File;
use Illuminate\Database\Eloquent\Collection;

final class DeleteFilesFromDatabaseCommand
{
    /**
     * @param  Collection|File[]  $files
     */
    public function execute(Collection $files): void
    {
        File::whereIn('id', $files->pluck('id'))->delete();
    }
}
