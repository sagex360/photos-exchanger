<?php

namespace App\Listeners;

use App\Events\Files\FileDeleted;
use App\Repositories\FileTokens\FileTokensRepository;
use App\Services\LinkTokens\DeleteLinkTokensCommand;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeleteFileSubordinateRelationships implements ShouldQueue
{
    /**
     * @var FileTokensRepository
     */
    private FileTokensRepository $tokensRepository;
    /**
     * @var DeleteLinkTokensCommand
     */
    private DeleteLinkTokensCommand $deleteLinkTokens;

    /**
     * Create the event listener.
     *
     * @param  FileTokensRepository  $tokensRepository
     * @param  DeleteLinkTokensCommand  $deleteLinkTokens
     */
    public function __construct(FileTokensRepository $tokensRepository, DeleteLinkTokensCommand $deleteLinkTokens)
    {
        $this->tokensRepository = $tokensRepository;
        $this->deleteLinkTokens = $deleteLinkTokens;
    }

    /**
     * Handle the event.
     *
     * @param  FileDeleted  $event
     * @return void
     * @throws Exception
     */
    public function handle(FileDeleted $event): void
    {
        $tokens = $this->tokensRepository->findByFileId($event->getFileId());

        $this->deleteLinkTokens->execute($tokens);
    }
}
