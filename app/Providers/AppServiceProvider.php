<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);

        foreach (glob(app()->path() . '/Helpers/*.php') as $file) {
            require_once($file);
        }
    }

    public function boot()
    {
        date_default_timezone_set('Asia/Novosibirsk');
    }
}
