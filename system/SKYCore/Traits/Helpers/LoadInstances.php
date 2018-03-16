<?php

namespace SKYCore\Traits\Helpers;

use SKYCore\{
    Cache, Session, Configuration, Database, Language, Load, Routing
};
use Symfony\Component\HttpFoundation\Request;

/**
 * @property Configuration $config
 * @property Load $load
 * @property Database $db
 * @property Language $lang
 * @property Cache $cache
 * @property Request $request
 * @property Session $session
 * @property Routing $router
 *
 * Trait LoadInstances
 * @package SKYCore\Traits\Helpers
 *
 * @version 1.0
 */
trait LoadInstances
{
    public function __construct()
    {
        foreach (Load::getLoadedStatic() as $class){
            $name = strtolower($class['name']);
            $this->$name = $class['object'];
        }
    }
}