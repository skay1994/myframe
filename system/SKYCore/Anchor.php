<?php

namespace SKYCore;

use SKYCore\Anchors\{System,Application,Modules};
use SKYCore\Interfaces\AnchorCore;
use SKYCore\Traits\Helpers\{Configurations,CurrentApp};
/**
 * Class Anchor
 * @package SKYCore
 *
 * @version 1.0
 */
class Anchor implements AnchorCore
{
    use Configurations,
        CurrentApp;

    /**
     * Class Intance;
     *
     * @var self;
     */
    private static $instance = null;

    private static $_anchor = [];

    /**
     * Anchor constructor.
     *
     * @version 1.0
     */
    function __construct()
    {
        $anchorReference = $this->getConfigs('anchor_reference');

        $anchor = [];

        if(!empty($anchorReference)){
             foreach ($anchorReference as $key => $anchorR ){

                 if(in_array('SKYCore\Interfaces\anchor',class_implements($anchorR))){
                     if(is_object($anchorR)){
                         $anchor[$key] = $anchorR;
                     } elseif (is_string($anchorR)){
                         $anchor[$key] = new $anchorR();
                     }
                 }
             }
        }

        if(!isset($anchor['system'])){
            $anchor['system'] = new System();
        }
        if(!isset($anchor['app'])){
            $anchor['app'] = new Application();
        }
        if(!isset($anchor['modules'])){
            $anchor['modules'] = new Modules();
        }


        self::$_anchor = $anchor;
    }

    /**
     * @return anchor
     *
     * @version 1.0
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param string $type
     * @param string $name
     * @param array $args
     * @return bool|mixed
     *
     * @version 1.0
     */
    public function new_anchor(string $type,string $name,array $args){

        if(isset(self::$_anchor[$type])){
            /** @var \SKYCore\Interfaces\anchor $anchors */
            $anchors = self::$_anchor[$type];
            return $anchors->execute($name,$args);
        } else {
            return false;
        }
    }

    /**
     * @param string $type
     * @param string $name
     * @param string $callback
     * @param int|null $priority
     * @return bool
     *
     * @version 1.0
     */
    public function add_callback(string $type,string $name,$callback, int $priority = 10){
        if(!isset(self::$_anchor[$type])){
            return false;
        }

        return self::$_anchor[$type]->add_callback($name,$callback,$priority);
    }

    /**
     * @param string $type
     * @param string $name
     * @param string|null $callback
     * @return bool
     *
     * @version 1.0
     */
    public function remove_callback(string $type,string $name,string $callback = null){
        if(!isset(self::$_anchor[$type])){
            return false;
        }

        if(!$callback){
            return false;
        }

        return self::$_anchor[$type]->remove_callback($name,$callback);
    }

    /**
     * @return array
     *
     * @version 1.0
     */
    public function get_anchors()
    {
        return self::$_anchor;
    }

}