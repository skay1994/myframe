<?php

namespace SKYCore\Traits\Helpers;

use SKYCore\load;
/**
 * Trait CurrentApp
 * @package SKYCore\Traits\Helpers
 *
 * @version 1.0
 */
trait CurrentApp
{
    protected function currentApp()
    {
        if($router = Load::getLoadedStatic('Routing')) {
            $router = $router['object'];
            return $router->application;
        } else {
            return false;
        }
    }
}