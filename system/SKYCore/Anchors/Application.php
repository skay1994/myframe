<?php

namespace SKYCore\Anchors;


use SKYCore\Interfaces\Anchor;
/**
 * Class Application
 * @package SKYCore\Anchors
 *
 * @version 1.0
 */
class Application implements Anchor
{
    private $callbacks = [];

    public function __construct()
    {
    }

    function add_callback(string $name ,$callback, int $priority)
    {
        if(is_callable($callback)){
            $callback = [
                'callback' => $callback
            ];

            $this->callbacks[$name][$priority][] = $callback;
        } else {
            return false;
        }
    }

    function remove_callback(string $name, string $callback, int $priority)
    {
        // TODO: Implement remove_callback() method.
    }

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