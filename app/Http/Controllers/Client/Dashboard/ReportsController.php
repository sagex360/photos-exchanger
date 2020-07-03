<?php


namespace App\Http\Controllers\Client\Dashboard;


use App\Http\Controllers\Controller;
use App\Repositories\Files\FilesRepository;
use App\Services\Files\Reports\FileReportsSummaryManager;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

final class ReportsController extends Controller
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
     * @return Application|Factory|View
     * @throws BindingResolutionException
     */
    public function index()
    {
        $userId = Auth::id();

        $files = $this->filesRepository->findForReportByUserId($userId);
        $notDeletedCount = $this->filesRepository->countNotDeletedByUser($userId);
        $deletedCount = $this->filesRepository->countDeletedByUser($userId);

        /**
         * @var FileReportsSummaryManager $summaryManager
         */
        $summaryManager = app()->make(FileReportsSummaryManager::class, ['files' => $files]);

        return view('pages.client.dashboard.reports.index', [
            'currentFilesCount' => $notDeletedCount,
            'deletedFilesCount' => $deletedCount,
            'files'             => $files,

            'summaryUsedDisposableLinksCount' => $summaryManager->usedDisposableLinks(),
            'summaryDisposableLinksCount'     => $summaryManager->disposableLinks(),
            'summaryUnlimitedLinksViews'      => $summaryManager->unlimitedLinksViews(),
            'totalViewsFullCount'             => $summaryManager->totalViews()
        ]);
    }
}
