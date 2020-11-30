<?php

namespace App\Providers;

use Queue;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        error_reporting(E_ALL ^ E_NOTICE);
        define('NOW_TIME', time());
        date_default_timezone_set('PRC');

        Queue::after(function (JobProcessed $event){
//            echo '\n queue:after';
        });
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
