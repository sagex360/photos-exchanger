<?php

namespace App\Jobs;

use App\Repositories\Files\FilesRepository;
use App\Services\Files\DeleteFilesCompletelyCommand;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class DeleteOverdueFilesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @param FilesRepository              $filesRepository
     * @param DeleteFilesCompletelyCommand $deleteFilesCommand
     * @return void
     */
    public function handle(FilesRepository $filesRepository, DeleteFilesCompletelyCommand $deleteFilesCommand)
    {
        $deleteFilesCommand->execute($filesRepository->overdue());
    }
}
