<?php

namespace App\Providers;

use App\Interfaces\GenerationInterface;
use App\Services\GenerationXLS;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $singletons = [
        GenerationInterface::class => GenerationXLS::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
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
