<?php

namespace App\Http\Controllers\Guest;

use App\Exceptions\FileTokenExpiredException;
use App\Http\Controllers\Controller;
use App\Repositories\Files\FilesRepository;
use App\Repositories\FileTokens\FileTokensRepository;
use App\Services\Files\VerifyFileLinkCommand;
use Illuminate\View\View;

final class ViewFilesController extends Controller
{
    protected FileTokensRepository $tokensRepository;
    protected FilesRepository $filesRepository;

    public function __construct(FileTokensRepository $fileTokensRepository, FilesRepository $filesRepository)
    {
        $this->tokensRepository = $fileTokensRepository;
        $this->filesRepository = $filesRepository;
    }

    /**
     * @param  string  $token
     * @param  VerifyFileLinkCommand  $verifyLink
     * @return View
     * @throws FileTokenExpiredException
     */
    public function show(string $token, VerifyFileLinkCommand $verifyLink): View
    {
        $fileLinkToken = $this->tokensRepository->findByToken($token);
        $verifyLink->execute($fileLinkToken);

        return view(
            'pages.guest.files.visit',
            [
                'fileLinkToken' => $fileLinkToken
            ]
        );
    }
}
