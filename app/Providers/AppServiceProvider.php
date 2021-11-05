<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
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
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //responses
        Response::macro('success', function($data, $status_code = 200){
            return response()->json([
                'success' => true,
                'data'    => $data
            ], $status_code);
        });

        Response::macro('successWithPaginate', function($data, $status_code = 200){
            return response()->json([
                'success' => true,
                'data'    => $data['data'],
                'links'   => $data['links'],
                'meta'    => $data['meta'],
            ], $status_code);
        });

        Response::macro('error', function($error_msg, $status_code = 404){
            return response()->json([
                'success' => false,
                'message'    => $error_msg
            ], $status_code);
        });
    }
}
