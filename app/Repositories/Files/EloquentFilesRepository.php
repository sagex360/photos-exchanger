<?php


namespace App\Repositories\Files;


use App\Models\File;
use App\Models\LinkVisit;
use App\Repositories\FileTokens\Queries\FileLinkTokenQueries;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

final class EloquentFilesRepository implements FilesRepository
{
    private FileLinkTokenQueries $linkTokenQueries;

    public function __construct(FileLinkTokenQueries $fileLinkTokenQueries)
    {
        $this->linkTokenQueries = $fileLinkTokenQueries;
    }

    public function overdue(): Collection
    {
        return File::overdue()->get();
    }

    public function findWithTokensById(int $id): File
    {
        return File::whereId($id)->with(
            [
                'linkTokens' => function ($query) {
                    $this->linkTokenQueries->withVisitsCount($query);
                }
            ]
        )->firstOrFail();
    }

    public function findByUserId(int $userId): Collection
    {
        return File::whereUserId($userId)->get();
    }

    public function findById(int $id): File
    {
        return File::findOrFail($id);
    }

    public function findForReportByUserId(int $userId): Collection
    {
        return File::whereUserId($userId)
            ->withCount(
                [
                    'views',
                    'linkTokens as disposable_links_count'      => function ($query) {
                        $this->linkTokenQueries
                            ->whereType($query, 'disposable');
                    },
                    'linkTokens as disposable_links_used_count' => function ($query) {
                        $this->linkTokenQueries
                            ->whereType($query, 'disposable')
                            ->has('visits');
                    },
                    'views as unlimited_link_views_count'       => function ($query) {
                        /**
                         * @var Builder|LinkVisit $query
                         */
                        $query->whereHas(
                            'linkToken',
                            function ($query) {
                                $this->linkTokenQueries
                                    ->whereType($query, 'unlimited');
                            }
                        );
                    }
                ]
            )->get();
    }

    public function countDeletedByUser(int $userId): int
    {
        return File::whereUserId($userId)
            ->onlyTrashed()
            ->count();
    }

    public function countNotDeletedByUser(int $userId): int
    {
        return File::whereUserId($userId)
            ->withoutTrashed()
            ->count();
    }
}
