<?php

namespace SKYCore\Interfaces;

/**
 * Interface anchor
 * @package SKYCore\Interfaces
 *
 * @version
 */
interface Anchor
{
    public function __construct();

    function add_callback(string $name, $callback, int $priority);

    function remove_callback(string $name, string $callback, int $priority);

    function execute(string $name,array $args);

}