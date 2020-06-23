<?php

namespace App\Http\Controllers\Client\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Files\StoreFileRequest;
use App\Services\Files\CreateFileCommand;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

final class FilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

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
     * @throws BindingResolutionException
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
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
