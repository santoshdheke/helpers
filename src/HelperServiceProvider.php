<?php

namespace SsGroup\Helper;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use SsGroup\Helper\Classes\AppHelper;
use SsGroup\Helper\Classes\ImageHelper;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        App::bind('apphelper', function()
        {
            return new AppHelper();
        });

        App::bind('imagehelper', function()
        {
            return new ImageHelper();
        });
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
