<?php

namespace App\Providers;

use App\Http\Controllers\Client\Dashboard\FilesController;
use App\Jobs\DeleteOverdueFilesJob;
use App\Repositories\Files\EloquentFilesRepository;
use App\Repositories\Files\FilesRepository;
use App\Services\Files\DeleteFilesCompletelyCommand;
use App\Services\Files\UpdateFileCommand;
use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }

        $this->registerBindings();
    }

    protected function registerBindings()
    {
        /**
         * @var Container $app
         */
        $app = $this->app;

        $app->bindMethod(DeleteOverdueFilesJob::class . '@handle', function (DeleteOverdueFilesJob $job, Container $app) {
            $filesRepo = $app->make(EloquentFilesRepository::class);
            $deleteFilesCommand = $app->make(DeleteFilesCompletelyCommand::class);

            $job->handle($filesRepo, $deleteFilesCommand);
        });

        /**************************** FilesRepository bindings ********************************/
        $app->when(FilesController::class)
            ->needs(FilesRepository::class)
            ->give(EloquentFilesRepository::class);

        $app->when(UpdateFileCommand::class)
            ->needs(FilesRepository::class)
            ->give(EloquentFilesRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
