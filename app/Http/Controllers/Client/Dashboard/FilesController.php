<?php

namespace App\Http\Controllers\Client\Dashboard;

use App\Exceptions\CouldNotSaveFileException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Files\StoreFileRequest;
use App\Http\Requests\Dashboard\Files\UpdateFileRequest;
use App\Models\File;
use App\Repositories\Files\FilesRepository;
use App\Services\Files\CreateFileCommand;
use App\Services\Files\DeleteFilesCompletelyCommand;
use App\Services\Files\UpdateFileCommand;
use Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class FilesController extends Controller
{
    protected FilesRepository $filesRepository;

    public function __construct(FilesRepository $filesRepository)
    {
        $this->filesRepository = $filesRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $files = $this->filesRepository->findByUserId(Auth::id());

        return view('pages.client.dashboard.files.index', [
            'filesCount' => $files->count(),
            'files'      => $files,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     * @throws AuthorizationException
     */
    public function create(): View
    {
        $this->authorize('create', File::class);

        return view('pages.client.dashboard.files.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreFileRequest  $request
     * @param CreateFileCommand $command
     * @return RedirectResponse
     * @throws CouldNotSaveFileException
     * @throws AuthorizationException
     */
    public function store(StoreFileRequest $request, CreateFileCommand $command): RedirectResponse
    {
        $this->authorize('create', File::class);

        $file = $command->create($request->createDto());

        return redirect()->route('dashboard.files.show', $file);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return View
     * @throws AuthorizationException
     */
    public function show(int $id): View
    {
        $file = $this->filesRepository->findById($id);
        $this->authorize('view', $file);

        return view('pages.client.dashboard.files.show', [
            'file' => $file
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View
     * @throws AuthorizationException
     */
    public function edit(int $id): View
    {
        $file = $this->filesRepository->findById($id);
        $this->authorize('update', $file);

        return view('pages.client.dashboard.files.edit', [
            'file' => $file
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int               $id
     * @param UpdateFileRequest $request
     * @param UpdateFileCommand $command
     * @return RedirectResponse
     * @throws CouldNotSaveFileException
     * @throws AuthorizationException
     */
    public function update(int $id, UpdateFileRequest $request, UpdateFileCommand $command): RedirectResponse
    {
        $file = $this->filesRepository->findById($id);
        $this->authorize('update', $file);

        $command->execute($request->createDto($file));

        return redirect()->route('dashboard.files.show', $file);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int                          $id
     * @param DeleteFilesCompletelyCommand $command
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(int $id, DeleteFilesCompletelyCommand $command): RedirectResponse
    {
        $file = $this->filesRepository->findById($id);
        $this->authorize('delete', $file);

        $command->execute(Collection::wrap($file));

        return redirect()->route('dashboard.files.index');
    }
}
