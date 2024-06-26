<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Mensaje;
use App\Models\daf;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        /**$this ->app->bind('path.public', function(){
           return base_path('public_html');
       });*/
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $mensajes = Mensaje::all();

        $daf = daf::all();

        View::share(['mensajes' => $mensajes, 'daf' => $daf]);
    }
}
