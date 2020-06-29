<?php

namespace App\Http\Controllers\Guest;

use App\Exceptions\FileTokenExpiredException;
use App\Http\Controllers\Controller;
use App\Repositories\Files\FilesRepository;
use App\Repositories\FileTokens\FileTokensRepository;
use App\Services\Files\VerifyFileLinkCommand;

final class ViewFilesController extends Controller
{
    /**
     * @var FileTokensRepository
     */
    protected FileTokensRepository $tokensRepository;

    /**
     * @var FilesRepository
     */
    protected FilesRepository $filesRepository;

    public function __construct(FileTokensRepository $fileTokensRepository, FilesRepository $filesRepository)
    {
        $this->tokensRepository = $fileTokensRepository;
        $this->filesRepository = $filesRepository;
    }

    /**
     * @param string                $token
     * @param VerifyFileLinkCommand $verifyLink
     * @return string
     * @throws FileTokenExpiredException
     */
    public function show(string $token, VerifyFileLinkCommand $verifyLink)
    {
        $fileLinkToken = $this->tokensRepository->find($token);
        $verifyLink->execute($fileLinkToken);

        return view('pages.guest.files.visit', [
            'fileLinkToken' => $fileLinkToken
        ]);
    }
}
