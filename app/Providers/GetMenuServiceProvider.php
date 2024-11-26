<?php

namespace App\Providers;

use App\Http\Controllers\MenuController;
use Illuminate\Support\ServiceProvider;

class GetMenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
      // $menuController = new MenuController();
      // $menuController->getMenuUser();
    }
}
