<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Route;

class BladeDirectivesServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('ifroute', function ($routeName) {
            return Str::startsWith(Route::currentRouteName(), $routeName);
        });

        $this->registerSectionOnce();
    }

    protected function registerSectionOnce()
    {
        Blade::directive('sectionOnce', function ($name) {
            return Blade::compileString(<<<EOT
@hasSection($name)
@else
@section($name)
EOT
            );
        });

        Blade::directive('showSectionOnce', function () {
            return Blade::compileString(<<< EOT
@show
@endif
EOT
            );
        });
    }
}
