<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Authenticated;
use App\Http\Controllers\MenuController;

class UpdateMenuAfterLogin
{
    public function handle(Authenticated $event)
    {
        $menuController = new MenuController();
        $menuController->getMenuUser();
    }
}
