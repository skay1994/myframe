<?php

namespace SKYCore;

/**
 * Class Environment
 * @package SKYCore
 *
 * @version 1.0
 */
class Environment
{
    /**
     * Current environment
     *
     * @var
     */
    private $current;

    private $https = false;


    private function __construct()
    {
        if($_SERVER['SERVER_ADDR'] == '::1' && $_SERVER['REMOTE_ADDR'] == '::1'){
            if($predefined = getConfigs('environment')){
                $this->current = $predefined;
            } else {
                $this->current = 'localhost';
            }
        } else {
            if($predefined = getConfigs('environment')){
                $this->current = $predefined;
            } else {
                $this->current = 'product';
            }
        }

        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')
            $this->https = true;
    }

    public function isHTTPS()
    {
        return $this->https;
    }

    public function getEnvironment(){
        return $this->current;
    }

    public static function getInstance()
    {
        static $instance = null;

        if($instance === null)
            $instance = new self();

        return $instance;
    }

}