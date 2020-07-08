<?php

namespace App\Http\Controllers\API\LinkTokens;

use App\Http\Controllers\Controller;
use App\Http\Resources\LinkToken\LinkTokenResource;
use App\Repositories\FileTokens\FileTokensRepository;
use App\ValueObjects\LinkToken\LinkTokensFactory;
use Illuminate\Auth\Access\AuthorizationException;

final class LinkTokensController extends Controller
{
    protected FileTokensRepository $tokensRepository;

    public function __construct(FileTokensRepository $tokensRepository)
    {
        $this->tokensRepository = $tokensRepository;
    }

    /**
     * @return array
     */
    public function types(): array
    {
        return LinkTokensFactory::supportedTypes();
    }

    /**
     * @param  int  $id
     * @return LinkTokenResource
     * @throws AuthorizationException
     */
    public function show(int $id): LinkTokenResource
    {
        $token = $this->tokensRepository->findById($id);
        $this->authorize('view', $token);

        return new LinkTokenResource($token);
    }
}
