<?php

namespace SKYCore\Controllers;

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
 * @property \TJPermissions $tjp
 *
 * Class Controller
 * @package SKYCore\Controllers
 */
class Controller{
    public $model;
    public $modules;
    function __construct(){}

    function view_by_folder(){}

    function status_cache(){}

    function disable_all_template(){}

    function view(){}
};