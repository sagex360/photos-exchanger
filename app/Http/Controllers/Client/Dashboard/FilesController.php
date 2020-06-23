<?php

namespace App\Http\Controllers\Client\Dashboard;

use App\Exceptions\CouldNotSaveFileException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Files\StoreFileRequest;
use App\Http\Requests\Dashboard\Files\UpdateFileRequest;
use App\Repositories\Files\FilesRepository;
use App\Services\Files\CreateFileCommand;
use App\Services\Files\DeleteFilesCompletelyCommand;
use App\Services\Files\UpdateFileCommand;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

final class FilesController extends Controller
{
    /**
     * @var FilesRepository
     */
    protected FilesRepository $filesRepository;

    public function __construct(FilesRepository $filesRepository)
    {
        $this->filesRepository = $filesRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
//        return view('pages.client.dashboard.files.index', [
//            'files' => $this->filesRepository->all()
//        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('pages.client.dashboard.files.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreFileRequest  $request
     * @param CreateFileCommand $command
     * @return RedirectResponse
     * @throws CouldNotSaveFileException
     */
    public function store(StoreFileRequest $request, CreateFileCommand $command)
    {
        $file = $command->create($request->createDto());

        return redirect()->route('dashboard.files.edit', $file);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        dd($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit(int $id)
    {
        return view('pages.client.dashboard.files.edit', [
            'file' => $this->filesRepository->find($id)
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
     */
    public function update(int $id, UpdateFileRequest $request, UpdateFileCommand $command)
    {
        $file = $command->execute($request->createDto($id));

        return redirect()->route('dashboard.files.show', $file);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int                          $id
     * @param DeleteFilesCompletelyCommand $command
     * @return RedirectResponse
     */
    public function destroy(int $id, DeleteFilesCompletelyCommand $command)
    {
        $command->execute(Collection::make([$this->filesRepository->find($id)]));

        return redirect()->route('dashboard.files.index');
    }
}
