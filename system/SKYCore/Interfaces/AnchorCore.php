<?php

namespace SKYCore\Interfaces;

/**
 * Interface anchorCore
 * @package SKYCore\Interfaces
 *
 * @version 1.0
 */
interface AnchorCore
{
    public function __construct();

    public function new_anchor(string $type,string $name,array $args);

    public function add_callback(string $type,string $name, $callback, int $priority);

    public function remove_callback(string $type,string $name,string $callback = null);

    public static function getInstance();
}