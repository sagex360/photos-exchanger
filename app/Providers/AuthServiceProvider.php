<?php

namespace App\Providers;

use App\Models\File;
use App\Models\FileLinkToken;
use App\Policies\FileLinksPolicy;
use App\Policies\FilesPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        File::class          => FilesPolicy::class,
        FileLinkToken::class => FileLinksPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
