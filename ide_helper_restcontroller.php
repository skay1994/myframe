<?php

namespace SKYCore\Controllers;

use Doctrine\ORM\EntityManager;
use SKYCore\{
    configuration, Database, language, load, cache, routing, session
};
use Symfony\Component\HttpFoundation\Request;

/**
 * @property configuration $config
 * @property load $load
 * @property Database $db
 * @property language $lang
 * @property cache $cache
 * @property Request $request
 * @property session $session
 * @property routing $router
 * @property \TJPermissions $tjp
 *
 * Class Controller
 * @package SKYCore\Controllers
 */
class RestController{
    public $model;
    public $modules;
    function __construct(){}

    /**
     * @param string $type
     * @return array|object
     *
     * @version 1.0
     */
    public function post_content(){return null;}

    /**
     * @param string $type
     * @return array|object
     *
     * @version 1.0
     */
    public function get_content(){return null;}

    /**
     * @param string $type
     * @return array|object
     *
     * @version 1.0
     */
    public function file_content(){return null;}
    /**
     * @param string $type
     *
     * @version 1.0
     */
    public function type(string $type = 'get'){return null;}

    public function index(){}

    /**
     * @param int $status
     * @param string $content
     * @param string $content_type
     *
     * @version 1.0
     */
    public function send($status, $content, $content_type ){return null;}

    /**
     * @param int $status
     * @param $content
     * @param bool $manual_json
     *
     * @version 1.0
     */
    public function sendWithJson($status, $content, $manual_json = false){return null;}
};