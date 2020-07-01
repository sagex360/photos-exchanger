<?php

namespace App\Http\Controllers\API\LinkTokens;

use App\Http\Controllers\Controller;
use App\Http\Resources\LinkToken\LinkTokenResource;
use App\Repositories\FileTokens\FileTokensRepository;

final class LinkTokensController extends Controller
{
    /**
     * @var FileTokensRepository
     */
    protected FileTokensRepository $tokensRepository;

    public function __construct(FileTokensRepository $tokensRepository)
    {
        $this->tokensRepository = $tokensRepository;
    }

    public function show(int $id)
    {
        return new LinkTokenResource(
            $this->tokensRepository->findById($id)
        );
    }
}
