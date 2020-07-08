<?php

namespace App\Providers;

use App\Http\Controllers\API\Files\FileLinkTokensController;
use App\Http\Controllers\API\Files\FileRelationshipsController;
use App\Http\Controllers\API\Files\FilesController as ApiFilesController;
use App\Http\Controllers\API\LinkTokens\LinkTokensController as ApiLinkTokensController;
use App\Http\Controllers\API\UsersController as ApiUsersController;
use App\Http\Controllers\Client\Dashboard\FilesController;
use App\Http\Controllers\Client\Dashboard\LinksController;
use App\Http\Controllers\Client\Dashboard\ReportsController;
use App\Http\Controllers\Guest\ViewFilesController;
use App\Jobs\DeleteOverdueFilesJob;
use App\Repositories\Files\EloquentFilesRepository;
use App\Repositories\Files\FilesRepository;
use App\Repositories\FileTokens\EloquentFileTokensRepository;
use App\Repositories\FileTokens\FileTokensRepository;
use App\Repositories\Users\EloquentUsersRepository;
use App\Repositories\Users\UsersRepository;
use App\Services\Files\DeleteFilesCompletelyCommand;
use App\Services\Files\UpdateFileCommand;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(IdeHelperServiceProvider::class);
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }

        $this->registerBindings();
    }

    protected function registerBindings(): void
    {
        /**
         * @var Container $app
         */
        $app = $this->app;

        $app->bindMethod(
            DeleteOverdueFilesJob::class.'@handle',
            static function (DeleteOverdueFilesJob $job, Container $app) {
                $filesRepo = $app->make(EloquentFilesRepository::class);
                $deleteFilesCommand = $app->make(DeleteFilesCompletelyCommand::class);

                $job->handle($filesRepo, $deleteFilesCommand);
            }
        );

        $this->registerFileRepositoryBindings();
        $this->registerFileTokensRepositoryBindings();
        $this->registerUsersRepositoryBindings();
    }

    protected function registerFileRepositoryBindings(): void
    {
        $this->app->when(
            [
                FilesController::class,
                UpdateFileCommand::class,
                LinksController::class,
                ReportsController::class,
                ViewFilesController::class,
                ApiFilesController::class,
                FileRelationshipsController::class,
                FileLinkTokensController::class,
            ]
        )
            ->needs(FilesRepository::class)
            ->give(EloquentFilesRepository::class);
    }

    protected function registerFileTokensRepositoryBindings(): void
    {
        $this->app->when(
            [
                ViewFilesController::class,
                ApiFilesController::class,
                LinksController::class,
                FileRelationshipsController::class,
                ApiLinkTokensController::class,
                FileLinkTokensController::class,
            ]
        )
            ->needs(FileTokensRepository::class)
            ->give(EloquentFileTokensRepository::class);
    }

    protected function registerUsersRepositoryBindings(): void
    {
        $this->app->when(
            [
                FileRelationshipsController::class,
                ApiUsersController::class,
            ]
        )
            ->needs(UsersRepository::class)
            ->give(EloquentUsersRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
