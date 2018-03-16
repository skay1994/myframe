<?php

namespace SKYCore;

use SKYCore\Traits\Helpers\{CurrentApp,Configurations};
/**
 * Class Session
 * @package SKYCore
 *
 * @version 1.0
 */
class Session
{
    use CurrentApp,Configurations;

    function __construct()
    {
        $options = $this->getConfigs('session_options');

        $session['cookie_httponly'] = 1;
        $session['cookie_secure'] = 1;

        $session = array_merge($session,$options ?? []);

        session_start($session);
    }

    /**
     * @return session
     *
     * @version 1.0
     */
    public static function getInstance()
    {
        static $instance;

        if($instance === null)
            $instance = new self();

        return $instance;
    }

    /**
     * @param string $value
     * @return null
     *
     * @version 1.0
     */
    public function get(string $value = '')
    {
        if(!empty($value)){
            if(isset($_SESSION[$value])){
                return $_SESSION[$value];
            } else {
                return null;
            }
        } else {
            return $_SESSION;
        }
    }

    /**
     * @param $name
     * @return bool
     *
     * @version 1.0
     */
    public function __get($name)
    {
        if(isset($_SESSION[$name])){
            return $_SESSION[$name];
        } else{
            return false;
        }
    }

    /**
     * @param $name
     * @param $value
     *
     * @version 1.0
     */
    public function __set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    /**
     * @param array $data
     *
     * @version 1.0
     */
    public function setSession(array $data)
    {
        foreach ($data as $key => $value){
            $_SESSION[$key] = $value;
        }
    }

    /**
     * @version 1.0
     */
    public function sessionDestroy()
    {
        unset($_SESSION);
        session_destroy();
    }

    public function user_valid()
    {
        if($user_valid = $this->getConfigs('default_user_session')){
            if(!is_string($user_valid)){
                return false;
            }

            if(!$this->$user_valid){
                return false;
            }

            return true;
        } else {
            return false;
        }
    }
}