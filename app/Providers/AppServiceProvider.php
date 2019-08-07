<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Console\Commands\ApiCrudGenerator;
use Illuminate\Support\Facades\Schema; //NEW: Import Schema
use App\Models\Notification;
use App\Observers\NotificationObserver;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadViewsFrom(__DIR__.'/resources/stubs', 'CrudGenerator');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->commands([
           ApiCrudGenerator::class,
        ]);

        Schema::defaultStringLength(191); //NEW: Increase StringLength
        \App\Observers\Kernel::make()->observes();
        //Notification::observe(NotificationObserver::class);

    }
}
