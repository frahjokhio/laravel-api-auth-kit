<?php

namespace App\Modules\Auth;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutes();
    }

    protected function loadRoutes(): void
    {
        $routeFile = base_path('app/Modules/Auth/Routes/api.php');

        if (file_exists($routeFile)) {
            Route::prefix('api')
                ->middleware('api')
                ->group($routeFile);
        }
    }
}
