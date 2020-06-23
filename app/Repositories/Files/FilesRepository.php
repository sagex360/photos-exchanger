<?php


namespace App\Repositories\Files;


use App\Models\File;
use Illuminate\Database\Eloquent\Collection;

interface FilesRepository
{
    /**
     * @return Collection|File[]
     */
    public function overdue(): Collection;

    /**
     * @param int $id
     * @return File
     */
    public function find(int $id) : File;
}
