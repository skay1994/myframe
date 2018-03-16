<?php

namespace SKYCore\Interfaces;

/**
 * Interface Controller
 * @package SKYCore\Interfaces
 *
 * @version 1.0
 */
interface Controller
{
    public function load(string $type, string $class, string $app = '');
}