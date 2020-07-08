<?php


namespace App\Services\Files;


use App\Exceptions\FileTokenExpiredException;
use App\Models\FileLinkToken;
use Illuminate\Filesystem\FilesystemManager;
use Symfony\Component\HttpFoundation\StreamedResponse;

final class ReceiveFileFromStorageCommand
{
    protected FilesystemManager $filesystemManager;
    protected VerifyFileLinkCommand $verifyLink;
    protected RecordLinkVisitCommand $recordLinkVisit;

    public function __construct(VerifyFileLinkCommand $verifyLink,
                                RecordLinkVisitCommand $recordLinkVisit,
                                FilesystemManager $filesystemManager)
    {
        $this->filesystemManager = $filesystemManager;
        $this->verifyLink = $verifyLink;
        $this->recordLinkVisit = $recordLinkVisit;
    }

    /**
     * @param FileLinkToken $linkToken
     * @return StreamedResponse
     * @throws FileTokenExpiredException
     */
    public function get(FileLinkToken $linkToken): StreamedResponse
    {
        $this->verifyLink->execute($linkToken);

        $filesystem = $this->filesystemManager->disk($linkToken->file->location->storage());
        $location = $linkToken->file->location->fullPath();

        if ($filesystem->exists($location)) {
            $this->recordLinkVisit->execute($linkToken);
        }

        return $filesystem->response($location);
    }
}
