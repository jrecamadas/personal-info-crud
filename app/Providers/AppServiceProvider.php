<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Dingo\Api\Transformer\Adapter\Fractal;
use League\Fractal\Manager;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['Dingo\Api\Transformer\Factory']->setAdapter(function () {
            $manager = new Manager();
            return new Fractal($manager, 'include', ',');
        });

        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
