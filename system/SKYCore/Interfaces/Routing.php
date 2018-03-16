<?php

namespace SKYCore\Interfaces;

/**
 * Interface Routing
 * @package SKYCore\Interfaces
 *
 * @version 1.0
 */
interface Routing
{

    /**
     * Treats the requested url and sets the routing properties for the system
     *
     * @return mixed
     */
    function parse();

    /**
     * Take care of routing to system
     *
     * @param array $configs
     * @return mixed
     */
    function router();

    static public function getInstance();

}