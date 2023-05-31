<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class AppServiceProvider extends ServiceProvider
{
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
    Response::macro('redirectTo', function ($url, $filename) {
        $headers = [
            'Content-Disposition' => 'attachment; filename="' . $filename . '"; filename*=utf-8\'\'' . rawurlencode($filename),
            'X-Redirect-Url' => $url,
        ];

        return response()->file(Storage::path($filename), $headers)->setStatusCode(200);
    });
}
}
