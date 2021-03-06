<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
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

        Response::macro('successWithPaginate', function($data, $paginateData, $status_code = 200){
            return response()->json([
                'success'       => true,
                'data'          => $data,
                'pages'         => $paginateData['pages'],
                'current_page'  => $paginateData['current_page'],
                'has_next'      => $paginateData['has_next'],
                'has_prev'      => $paginateData['has_prev'],
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
