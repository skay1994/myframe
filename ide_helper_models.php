<?php

namespace SKYCore\Models;

use SKYCore\{
    Configuration, Database, Language, Load, Cache, Routing, Session
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
 * Class Models
 * @package SKYCore\Models
 */
class Models{
    function __construct()
    {
    }
}