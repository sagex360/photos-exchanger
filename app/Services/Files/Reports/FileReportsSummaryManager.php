<?php


namespace App\Services\Files\Reports;


use App\Models\File;
use Illuminate\Database\Eloquent\Collection;

final class FileReportsSummaryManager
{
    /**
     * @var Collection|File[]
     */
    protected Collection $files;

    /**
     * FileReportsSummaryManager constructor.
     * @param  Collection|File[]  $files
     */
    public function __construct(Collection $files)
    {
        $this->files = $files;
    }

    public function usedDisposableLinks(): int
    {
        return $this->files->reduce(
            static function (int $count, File $file): int {
                return $count + $file->disposable_links_used_count;
            },
            0
        );
    }

    public function disposableLinks(): int
    {
        return $this->files->reduce(
            static function (int $count, File $file): int {
                return $count + $file->disposable_links_count;
            },
            0
        );
    }

    public function unlimitedLinksViews(): int
    {
        return $this->files->reduce(
            static function (int $views, File $file): int {
                return $views + $file->unlimited_link_views_count;
            },
            0
        );
    }

    public function totalViews(): int
    {
        return $this->files->reduce(
            static function (int $views, File $file): int {
                return $views + $file->views_count;
            },
            0
        );
    }
}
