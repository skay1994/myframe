<?php

namespace SKYCore\Anchors;

use SKYCore\Interfaces\Anchor;
/**
 * Class modules
 * @package SKYCore\Anchors
 */
class Modules implements Anchor
{
    private $callbacks = [];

    public function __construct()
    {
    }

    /**
     * @param string $name
     * @param $callback
     * @param int $priority
     * @return bool
     *
     * @version 1.0
     */
    function add_callback(string $name ,$callback, int $priority)
    {
        if(is_array($callback)){
            $callback = [
                'callback' => $callback
            ];

            $this->callbacks[$name][$priority][] = $callback;
        } elseif(is_callable($callback)){
            $callback = [
                'callback' => $callback
            ];

            $this->callbacks[$name][$priority][] = $callback;
        } else {
            return false;
        }
    }

    /**
     * @param string $name
     * @param string $callback
     *
     * @version 1.0
     */
    function remove_callback(string $name, string $callback, int $priority)
    {
    }

    /**
     * @param string $name
     * @param array $args
     * @return array|mixed|null
     *
     * @version 1.0
     */
    function execute(string $name,array $args)
    {
        $return_args = null;

        if(isset($this->callbacks[$name])){
            $priorities = array_keys($this->callbacks[$name]);

            if($priorities){
                foreach ($priorities as $priority){
                    foreach ($this->callbacks[$name][$priority] as $callback){;
                        if($return_args === null){
                            $return_args = call_user_func_array($callback['callback'],$args);
                        } else {
                            $return_args = call_user_func_array($callback['callback'],[$return_args]);
                        }
                    }
                }
            }

            return $return_args;
        } else {
            if(empty($args)){
                return [];
            }

            if(count($args) === 1){
                return $args[0];
            } else {
                return $args;
            }
        }

    }

}