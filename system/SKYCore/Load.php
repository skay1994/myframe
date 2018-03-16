<?php

declare(strict_types=1);

namespace SKYCore;

use SKYCore\Traits\Helpers\CurrentApp;
/**
 * Class Load
 * @package SKYCore
 */
class Load{
    /**
     * @var array
     */
    public static $loaded = [];

    /**
     * @var self
     */
    private static $instance = null;

    const CORE_NAMESPACE = '\SKYCore\\',
        APP_NAMESPACE = '\App\\';

    use CurrentApp;

    /**
     * @param $load
     * @param string|null $app
     * @return $this
     *
     * @version 1.0
     */
    public function libary($load,string $app = null)
    {

        if(!$app)
            $app = getConfigs('app_folder');
        $patch = APPPATH.$app.DS.'model'.DS;

        if(is_array($load)){
            $class = array_keys($load)[0];
            $newName = array_values($load)[0];

            if(file_exists($patch.$class.'.php')){
                $this->$newName = new $class();
            }
        }

        if(is_string($load)){
            if(file_exists($patch.$load.'.php')){
                $this->$load = new $load();
            }
        }

        return $this;
    }

    /**
     * @param $load
     * @param bool $loadClass
     * @return $this
     *
     * @version 1.0
     */
    public function customLoad($load,$loadClass = true)
    {
        if($loadClass){
            if(is_array($load)){
                if(count($load) == 1){
                    $dir = array_keys($load)[0];
                    $class = explode(DS,$dir);
                    $class = end($class);
                    $newName = array_values($load)[0];

                    if(file_exists(APPPATH.$dir.'.php')){
                        $this->$newName = new $class();
                    }

                    return $this;
                } else {
                    foreach ($load as $key => $value){
                        $dir = $key;
                        $class = explode(DS,$dir);
                        $class = end($class);
                        $newName = $value;

                        if(file_exists(APPPATH.$dir.'.php')){
                            $this->$newName = new $class();
                        }
                    }
                }
            }

            if(is_string($load)){
                $class = explode(DS,$load);
                $class = end($class);

                $this->$class = new $class();

                return $this;
            }
        } else {
            if(file_exists(APPPATH.$load.'.php')){
                require_once APPPATH.$load.'.php';
            }
        }

        return $this;
    }

    /**
     * @param string $class
     * @param string $path
     * @param string $app
     *
     * @version 1.0
     */
    public function load($class,string $path,string $app = '')
    {

        $name = '';

        if(is_array($class)){
            $name = $class[1];
            $class = $class[0];
        } elseif (is_string($class)){
            $name = $class;
        }

        $name = strtolower($name);

        if(!array_key_exists($class,self::$loaded)){

            $class_path = '';

            if(!empty($app)){
                $app = ucfirst($app);
            } else {
                $app = $this->currentApp();
            }

            if($app){
                if ($path == 'modules' || $path == 'module'){
                    $class_path = self::APP_NAMESPACE.$app.'\Modules\\';
                } elseif ($path == 'helpers' || $path == 'helper'){
                    $class_path = self::APP_NAMESPACE.$app.'\Helpers\\';
                }
            }

            if($path == 'core'){
                $class_path = self::CORE_NAMESPACE;
            } elseif($path == 'core-modules'){
                $class_path = self::CORE_NAMESPACE.'Modules\\';
            } elseif($path == 'app'){
                $class_path = self::APP_NAMESPACE;
            } elseif ($path == 'global_modules'){
                $class_path = self::APP_NAMESPACE.'\Modules\\';
            }

            $class_path = $class_path . ucfirst($class);

            if(class_exists($class_path,false) === false){
                if(method_exists($class_path, 'getInstance')){
                    self::$loaded[$class]['name'] = $name;
                    self::$loaded[$class]['object'] = call_user_func($class_path.'::getInstance');
                    return self::$loaded[$class]['object'];
                } else {
                    self::$loaded[$class]['name'] = $name;
                    self::$loaded[$class]['object'] = new $class_path();
                    return self::$loaded[$class]['object'];
                }

            }
        } else {
            return self::$loaded[$class];
        }
    }

    /**
     * @param $class
     * @param array $object
     *
     * @version 1.0
     */
    public function addLoadedInstance($class, array $object){
        self::$loaded[$class]['name'] = $object['name'] ?? $class;
        self::$loaded[$class]['object'] = $object['object'];
    }

    /**
     * @param $class
     * @param array $object
     *
     * @version 1.0
     */
    public static function addLoadedInstanceStatic($class, array $object){
        self::$loaded[$class]['name'] = $object['name'] ?? $class;
        self::$loaded[$class]['object'] = $object['object'];
    }

    /**
     * @param $class
     * @param string $path
     * @param string $app
     * @return mixed
     *
     * @version 1.0
     */
    public static function loadStatic($class,string $path,string $app = '')
    {
        /** @var self $self */
        $self = self::$instance;
        if(is_object($self->load($class,$path,$app)))
            return self::$loaded[$class];
        else
            false;
    }

    /**
     * @return load
     *
     * @version 1.0
     */
    public static function getInstance()
    {
        if(self::$instance === null)
            self::$instance = new self();

        return self::$instance;
    }

    /**
     * @param string $class
     * @return array
     *
     * @version 1.0
     */
    public function getLoaded(string $class = ''): array
    {
        if(!empty($class)){
            if(isset(self::$loaded[$class]))
                return self::$loaded[$class];
            else
                return [];
        }
        else
            return self::$loaded;
    }

    /**
     * @param string $class
     * @return array
     *
     * @version 1.0
     */
    public static function getLoadedStatic(string $class = ''): array
    {
        if(!empty($class)){
            if(isset(self::$loaded[$class]))
                return self::$loaded[$class];
            else
                return [];
        }
        else
            return self::$loaded;
    }

}