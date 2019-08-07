<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Console\Commands\ApiCrudGenerator;
use App\Models\Notification;
use App\Observers\NotificationObserver;

use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadViewsFrom(__DIR__ . '/resources/stubs', 'CrudGenerator');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        \App\Observers\Kernel::make()->observes();
        $this->commands([
            ApiCrudGenerator::class,
        ]);

        Schema::defaultStringLength(191); //NEW: Increase StringLength
        \App\Observers\Kernel::make()->observes();
        //Notification::observe(NotificationObserver::class);

    }
}
