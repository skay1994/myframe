<?php

namespace SKYCore\Traits\Helpers;

use SKYCore\Load;
/**
 * Trait configurations
 * @package SKYCore\Traits\Helpers
 *
 * @version 1.0
 */
trait Configurations
{
    public function getConfigs(string $param = '') {
        $configs = Load::getLoadedStatic('Configuration')['object']->getConfigs();

        if(empty($param))
            return $configs;
        else {
            if(isset($configs[$param]))
                return $configs[$param];
            else
                null;
        }
    }
}