<?php

namespace SKYCore;

use SKYCore\Traits\Helpers\{CurrentApp,Configurations};
/**
 * Class Modules
 * @package SKYCore
 *
 * @version 1.0
 */
class modules
{
    use CurrentApp,Configurations;

    /**
     * @var array
     */
    private static $modules = [];

    /**
     * @var string
     */
    private $apppath = '';

    /**
     * @var string
     */
    private $globalpath = '';

    /**
     * @version 1.0
     */
    private static $instance = null;

    public function __construct()
    {
        $this->apppath = APPPATH.$this->currentApp().DS.'modules'.DS;
        $this->globalpath = APPPATH.'global'.DS.'modules'.DS;
    }

    /**
     * @return modules
     *
     * @version 1.0
     */
    public static function getInstance()
    {
        if(self::$instance === null){
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @version 1.0
     */
    public function load()
    {
        $modules = $this->getConfigs('modules_list') ?? [];

        if($this->getConfigs('use_global_modules')){
            $modules_global = $this->getConfigs('modules_list_global') ?? [];

            $modules['global'] = array_merge($modules_global,$modules['global'] ?? []);
        }

        foreach ($modules as $key => $module){
            $module_load_data = [];

            switch ($key){
                case 'app':

                    if(is_array($module)){

                        foreach ($module as $module_key => $module_name){
                            if(!is_integer($module_key)){
                                $module_load = [];

                                $path = $this->apppath.$module_name.'/load_module.php';

                                if(file_exists($path)){

                                    $module_data = require_once $path;
                                    $module_callback_start_data = null;

                                    if(!isset($module_data['class_name'])){
                                        continue;
                                    }

                                    $module_load['class_name'] = $module_data['class_name'];

                                    $module_load['user_class_shotcut'] = $module_key;

                                    if(is_array($module_data)){
                                        if(isset($module_data['callbacks'])){
                                            $callbacks = $module_data['callbacks'];

                                            if(isset($callbacks['module_configuration']) && is_callable($callbacks['module_configuration'])){
                                                call_user_func_array($callbacks['module_configuration'],[load::getInstance(),new moduleHelper($module_name)]);
                                            }

                                            if(isset($callbacks['module_load']) && is_callable($callbacks['module_load'])){
                                                $module_callback_start_data = call_user_func($callbacks['module_load']);
                                            }
                                        }

                                        $module_load['module_data'] = $module_callback_start_data;
                                    }

                                    $module_load_data[$module_load['class_name']] = $module_load;
                                }
                            } else {
                                $module_load = [];

                                $path = $this->apppath.$module_name.'/load_module.php';

                                if(file_exists($path)){

                                    $module_data = require_once $path;
                                    $module_callback_start_data = null;

                                    if(!isset($module_data['class_name'])){
                                        continue;
                                    }

                                    $module_load['class_name'] = $module_data['class_name'];

                                    if(is_array($module_data)){
                                        if(isset($module_data['callbacks'])){
                                            $callbacks = $module_data['callbacks'];

                                            if(isset($callbacks['module_configuration']) && is_callable($callbacks['module_configuration'])){
                                                call_user_func_array($callbacks['module_configuration'],[load::getInstance(),new moduleHelper($module_name)]);
                                            }

                                            if(isset($callbacks['module_load']) && is_callable($callbacks['module_load'])){
                                                $module_callback_start_data = call_user_func($callbacks['module_load']);
                                            }
                                        }

                                        $module_load['module_data'] = $module_callback_start_data;
                                    }

                                    $module_load_data[$module_load['class_name']] = $module_load;
                                }
                            }
                        }
                    } else {
                        $path = $this->apppath.$module.'/load_module.php';

                        if(file_exists($path)){
                            $module_load = [];

                            $module_data = require_once $path;
                            $module_callback_start_data = null;

                            if(!isset($module_data['class_name'])){
                                continue;
                            }

                            $module_load['class_name'] = $module_data['class_name'];

                            if(is_array($module_data)){
                                if(isset($module_data['callbacks'])){
                                    $callbacks = $module_data['callbacks'];

                                    if(isset($callbacks['module_configuration']) && is_callable($callbacks['module_configuration'])){
                                        call_user_func($callbacks['module_configuration'],[load::getInstance(),new moduleHelper($module)]);
                                    }

                                    if(is_callable($callbacks['module_load'])){
                                        $module_callback_start_data = call_user_func($callbacks['module_load']);
                                    }
                                }

                                $module_load['module_data'] = $module_callback_start_data;
                            }

                            $module_load_data[$module_load['class_name']] = $module_load;
                        }
                    }

                    break;
                case 'global':
                    if(is_array($module)){

                        foreach ($module as $module_key => $module_name){

                            if(!is_integer($module_key)){
                                $module_load = [];

                                $path = $this->globalpath.$module_name.'/load_module.php';

                                if(file_exists($path)){
                                    $module_data = require_once $path;
                                    $module_callback_start_data = null;

                                    if(!isset($module_data['class_name'])){
                                        continue;
                                    }

                                    $module_load['class_name'] = $module_data['class_name'];

                                    $module_load['user_class_shotcut'] = $module_key;

                                    if(is_array($module_data)){

                                        if(isset($module_data['callbacks'])){
                                            $callbacks = $module_data['callbacks'];

                                            if(isset($callbacks['module_configuration']) && is_callable($callbacks['module_configuration'])){
                                                call_user_func_array($callbacks['module_configuration'],[load::getInstance(),new moduleHelper($module_name)]);
                                            }

                                            if(is_callable($callbacks['module_load'])){
                                                $module_callback_start_data = call_user_func($callbacks['module_load']);
                                            }
                                        }

                                        $module_load['module_data'] = $module_callback_start_data;
                                    }

                                    $module_load_data[$module_load['class_name']] = $module_load;
                                }
                            } else {
                                $module_load = [];

                                $path = $this->globalpath.$module_name.'/load_module.php';

                                if(file_exists($path)){
                                    $module_data = require_once $path;
                                    $module_callback_start_data = null;

                                    $module_load['class_name'] = $module_data['class_name'];

                                    if(is_array($module_data)){

                                        if(isset($module_data['callbacks'])){
                                            $callbacks = $module_data['callbacks'];

                                            if(isset($callbacks['module_configuration']) && is_callable($callbacks['module_configuration'])){
                                                call_user_func_array($callbacks['module_configuration'],[load::getInstance(),new moduleHelper($module_name)]);
                                            }

                                            if(is_callable($callbacks['module_load'])){
                                                $module_callback_start_data = call_user_func($callbacks['module_load']);
                                            }
                                        }

                                        $module_load['module_data'] = $module_callback_start_data;
                                    }

                                    $module_load_data[$module_load['class_name']] = $module_load;
                                }
                            }
                        }
                    } else {
                        $module_load = [];

                        $path = $this->globalpath.$module.'/load_module.php';

                        if(file_exists($path)){
                            $module_data = require_once $path;
                            $module_callback_start_data = null;

                            if(!isset($module_data['class_name'])){
                                continue;
                            }

                            $module_load['class_name'] = $module_data['class_name'];

                            if(is_array($module_data)){
                                if(isset($module_data['callbacks'])){

                                    $callbacks = $module_data['callbacks'];

                                    if(isset($callbacks['module_configuration']) && is_callable($callbacks['module_configuration'])){
                                        call_user_func($callbacks['module_configuration'],[load::getInstance(),new moduleHelper($module)]);
                                    }

                                    if(is_callable($callbacks['module_load'])){
                                        $module_callback_start_data = call_user_func($callbacks['module_load']);
                                    }
                                }

                                $module_load['module_data'] = $module_callback_start_data;
                            }

                            if(isset($module_load['class_name'])){
                                $module_load_data[$module_load['class_name']] = $module_load;
                            }
                        }
                    }
                    break;
                default:

                    if(in_array($key,$this->getConfigs('apps'))){
                        if(is_array($module)){

                            foreach ($module as $module_key => $module_name){
                                $module_load = [];

                                $path = APPPATH.$key.DS.$module_name.'/load_module.php';

                                if(file_exists($path)){
                                    $module_data = require_once $path;
                                    $module_callback_start_data = null;

                                    if(!isset($module_data['class_name'])){
                                        continue;
                                    }

                                    $module_load['class_name'] = $module_data['class_name'];

                                    $module_load['user_class_shotcut'] = $module_key;

                                    if(is_array($module_data)){
                                        if(isset($module_data['callbacks'])){
                                            $callbacks = $module_data['callbacks'];

                                            if(isset($callbacks['module_configuration']) && is_callable($callbacks['module_configuration'])){
                                                call_user_func_array($callbacks['module_configuration'],[load::getInstance(),new moduleHelper($module_name)]);
                                            }

                                            if(is_callable($callbacks['module_load'])){
                                                $module_callback_start_data = call_user_func($callbacks['module_load']);
                                            }
                                        }

                                        $module_load['module_data'] = $module_callback_start_data;
                                    }

                                    $module_load_data[$module_load['class_name']] = $module_load;
                                }

                            }

                        } elseif(is_string($module)) {
                            $path = APPPATH.$key.DS.$module.'/load_module.php';

                            if(file_exists($path)){

                                $module_load = [];

                                $module_data = require_once $path;
                                $module_callback_start_data = null;

                                $module_load['class_name'] = $module['class_name'];

                                if(is_array($module_data)){
                                    if(isset($module_data['callbacks'])){
                                        $callbacks = $module_data['callbacks'];

                                        if(isset($callbacks['module_configuration']) && is_callable($callbacks['module_configuration'])){
                                            call_user_func_array($callbacks['module_configuration'],[load::getInstance(),new moduleHelper($module)]);
                                        }

                                        if(is_callable($callbacks['module_load'])){
                                            $module_callback_start_data = call_user_func($callbacks['module_load']);
                                        }
                                    }

                                    $module_load['module_data'] = $module_callback_start_data;
                                }

                                if(isset($module_load['class_name'])){
                                    $module_load_data[$module_load['class_name']] = $module_load;
                                }
                            }
                        }
                    }
                    break;
            }

            if(!empty($module_load_data)){
                self::$modules = $module_load_data;
            }

            if((isset($module_load_data['class_name']) && !empty($module_load_data['class_name'])) &&
                (isset($module_load_data['module_data']) && !empty($module_load_data['module_data'])) &&
                (isset($module_load_data['module_data']['name']) && !empty($module_load_data['module_data']['name']) && is_string($module_load_data['module_data']['name'])) &&
                (isset($module_load_data['module_data']['object']) && !empty($module_load_data['module_data']['object']) && is_object($module_load_data['module_data']['object'])))
            {
                load::addLoadedInstanceStatic($module_load_data['class_name'],$module_load_data['module_data']);
            }
        }
    }

    /**
     * @return array
     */
    public function getModules(string $module_name = ''): array
    {
        if(!empty($module_name)){
            if(isset(self::$modules[$module_name])){
                return self::$modules[$module_name];
            } else {
                return [];
            }
        } else {
            return self::$modules;
        }
    }
}