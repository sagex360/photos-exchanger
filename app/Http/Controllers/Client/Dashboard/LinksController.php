<?php

namespace App\Http\Controllers\Client\Dashboard;

use App\Exceptions\CouldNotSaveLinkTokenException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Links\CreateLinkRequest;
use App\Repositories\Files\FilesRepository;
use App\Repositories\FileTokens\FileTokensRepository;
use App\Services\LinkTokens\CreateLinkCommand;
use App\Services\LinkTokens\DeleteLinkTokensCommand;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

final class LinksController extends Controller
{
    /**
     * @var FilesRepository
     */
    protected FilesRepository $filesRepository;
    /**
     * @var FileTokensRepository
     */
    protected FileTokensRepository $tokensRepository;

    public function __construct(FilesRepository $filesRepository, FileTokensRepository $tokensRepository)
    {
        $this->filesRepository = $filesRepository;
        $this->tokensRepository = $tokensRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $fileId
     * @return Application|Factory|View
     */
    public function index(int $fileId)
    {
        $file = $this->filesRepository->findWithTokensById($fileId);

        return view('pages.client.dashboard.links.of-file', [
            'linkTokens' => $file->linkTokens,
            'file'       => $file,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int $fileId
     * @return Application|Factory|View
     */
    public function create(int $fileId)
    {
        $file = $this->filesRepository->findById($fileId);

        return view('pages.client.dashboard.links.create', [
            'file' => $file
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param int               $fileId
     * @param CreateLinkRequest $request
     * @param CreateLinkCommand $command
     * @return RedirectResponse
     * @throws CouldNotSaveLinkTokenException
     */
    public function store(int $fileId,
                          CreateLinkRequest $request,
                          CreateLinkCommand $command)
    {
        $file = $this->filesRepository->findById($fileId);
        $command->execute($request->makeDto($file));

        return redirect()->route('dashboard.links.index', $file);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int                     $fileId
     * @param int                     $linkId
     * @param DeleteLinkTokensCommand $command
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(int $fileId, int $linkId, DeleteLinkTokensCommand $command)
    {
        $token = $this->tokensRepository->findWithTrashedById($linkId);

        if ($token->file_id !== $fileId) {
            throw new ModelNotFoundException("Token with id {$linkId} exists, but is not related to {$fileId} file.");
        }

        $command->execute(Collection::wrap($token));

        return redirect()->route('dashboard.links.index', $fileId);
    }
}
