<?php

declare(strict_types=1);

namespace SKYCore;

use SKYCore\Controllers\controller;
use SKYCore\Interfaces\Routing as RoutingI;
use Symfony\Component\HttpFoundation\Request;
/**
 * @method getPath()
 * @method getQuery()
 * @method getScheme()
 * @method getHost()
 * @method getSiteURI()
 * @method getApplication()
 * @method getType()
 * @method getController()
 * @method getAction()
 * @method getArgs()
 *
 * @property string $path
 * @property string $query
 * @property string $scheme
 * @property string $host
 * @property string $site_uri
 * @property string $application
 * @property string $type
 * @property string $controller
 * @property string $action
 * @property array  $args
 * @property string $cache_key
 * @property bool   $view_by_folder
 * @property bool   $disable_all_template
 * @property bool   $is_internal_rest;
 *
 * Class Routing
 * @package SKYCore
 *
 * @version 1.0
 */
class Routing implements RoutingI {

    private $path;
    private $query;
    private $scheme;
    private $host;
    private $site_uri;

    private $application;
    private $type;
    private $controller;
    private $action;
    private $args;
    private $cache_key = '';
    private $view_by_folder;
    private $disable_all_template;
    private $is_internal_rest = false;
    private $custom_view = null;

    static private $instance;

    /**
     * Routing constructor.
     */
    public function __construct(){
        $this->parse();
    }

    /**
     * @return mixed
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
     * @version 1.0
     */
    public function parse()
    {
        /** @var Request $request */
        $request = Load::getLoadedStatic('Request')['object'];

        $this->site_uri = $request->getSchemeAndHttpHost().'/';

        $this->path = $request->server->get('REDIRECT_URL') ?? '';

        $this->currentApp();

        $this->query = $request->getQueryString() ?? '';
        $this->host = $request->getHttpHost();
        $this->scheme = $request->getScheme();
    }

    /**
     * @version 1.0
     */
    public function router()
    {
        /** @var cache $cache */
        $cache = Load::getLoadedStatic('Cache')['object'];

        $url = explode('/',$this->path);
        $url = array_values(array_filter($url));

        $app = $this->application;

        $default_app = [
            getConfigs('default_app'),
            getConfigs('default_controller'),
            getConfigs('default_action')
        ];
        $default_rest = [
            getConfigs('default_rest_controller'),
            getConfigs('default_rest_action')
        ];

        $error_data = [];

        /**
         * Change the folder for current app
         */
        if($app != getConfigs('app_folder')){
            $this->current_application = $app;
            $this->current_folder = getConfigs('app_folder');;
        }

        $this->application = $app;

        /**
         * Internal Rest Server
         */
        $rest_intertnal = null;

        if(getConfigs('use_internal_rest_server')){
            $folder = getConfigs('internal_rest_server_base_folder');
            $rest_uri = getConfigs('internal_rest_server_base_uri');

            if(!$rest_uri){
                $rest_uri = $folder;
            }

            if(!empty($url) && ($rest_uri === $url[0])){
                unset($url[0]);
                $url = array_values($url);

                if(!empty($url)){
                    $controller = $url[0];
                } else {
                    $controller = $default_rest[0];
                }

                $this->is_internal_rest = true;

                $rest_intertnal = '\App\\'.ucwords($app).'\Controllers\\'.$folder.'\\'.ucwords($controller);
            }
        }

        if(isset($url[0])){
            $controller = $this->controller =  $url[0];
            array_shift($url);
        } else {
            $controller = $this->controller = $default_app[1];
        }

        $class = '\App\\'.ucfirst($app).'\Controllers\\'.ucfirst($controller);

        $args = [];

        if ($rest_intertnal){

            if(file_exists(str_replace('\\',DS,BASEPATH.$rest_intertnal.'.php'))){

                if(is_subclass_of($rest_intertnal, '\SKYCore\Controllers\RestController')){
                    $this->type = 'RESTFull Application';

                    $action = $this->action = $url[0] ?? $default_rest[1];
                    array_shift($url);
                    $args = $this->args = $url;

                    if(method_exists($rest_intertnal,$action)){
                        call_user_func_array(array(new $rest_intertnal,$action),$args);
                    } else {
                        error_page('404');
                    }

                } else {
                    error_page('404');
                }
            }
        } elseif(file_exists(str_replace('\\',DS,BASEPATH.$class.'.php'))){

            $type = '';
            $action = '';

            $pageCache = false;

            if(is_subclass_of($class, '\SKYCore\Controllers\RestController')){
                $type = $this->type = 'RESTFull Application';

                $action = $this->action = $url[0] ?? $default_rest[1];
                array_shift($url);
                $args = $this->args = $url;

            } elseif (is_subclass_of($class, '\SKYCore\Modules\SimpleView')){
                $type = $this->type = 'SimpleView Application';
                $action = $this->action = $url[0];
                array_shift($url);
                $args = $this->args = $url;
                array_shift($url);
            } elseif (is_subclass_of($class, '\SKYCore\Controllers\Controller')){
                $type = $this->type = 'MVC Application';
            }

            if($type == 'SimpleView Application')
                new $class($args);
            elseif ($type == 'RESTFull Application'){

                if(method_exists($class,$action)){
                    call_user_func_array(array(new $class,$action),$args);
                } else {
                    call_user_func_array(array(new $class,'index'),$args);
                }

            } elseif ($type == 'MVC Application'){
                /** @var Controller $c */
                $c = new $class();

                if(!isset($url[0])){
                    $url[0] = $action;
                }

                if(method_exists($c,$url[0])){
                    $action = $this->action = $url[0];
                    array_shift($url);
                } else {

                    if(method_exists($c,$default_app[2])){
                        $action = $this->action = $default_app[2];
                    } else {
                        $error_data['error_page']['type'] = $type;
                        $error_data['error_page']['controller'] = $controller;
                        $error_data['error_page']['action'] = $action;
                        $error_data['error_page']['application'] = $app;

                        error_page('404',$error_data);
                    }

                }

                $args = $this->args = $url;

                $this->view_by_folder = $c->view_by_folder();

                /**
                 * Cache
                 */
                $this->cache_key = $this->createCacheKey();

                $statusCache = $this->isCache = $c->status_cache();
                $this->disable_all_template = $c->disable_all_template();
                $this->custom_view = $c->custom_view_folder();

                if($statusCache){
                    $pageCache = $cache->checkCache($this->cache_key);
                }

                if($pageCache){
                    $this->page_cache = $pageCache;
                } else {
                    call_user_func_array(array($c,$action),$args);
                }
            }
        } else {
            error_page('404');
        }
    }

    /**
     * @version 1.0
     */
    private function currentApp()
    {
        $default = Load::getLoadedStatic('Configuration')['object'];
        $app = explode('/', $this->path);
        array_shift($app);

        if (isset($app[0])) {
            $app = $app[0];
        }

        if(!empty($app)){
            if(is_bool($default->multiapps) && $default->multiapps){

                if(is_array($default->apps)){
                    if(in_array($app,$default->apps)){
                        $this->application = $app;
                        $this->path = str_replace('/'.$app,'',$this->path);
                    } else {
                        $this->application = $default->default_app;
                    }

                } elseif(is_string($default->apps) && $app == $default->apps) {
                    $this->application = $app;
                } else {
                    $this->application = $default->default_app;
                }

            } else {
                if(is_string($default->apps))
                    $this->application = $default->apps;
                elseif (is_array($default->apps))
                    $this->application = $default->default_app;
                else
                    $this->application = $default->default_app;
            }
        } else {
            $this->application = $default->default_app;
        }
    }

    /**
     * @return string
     *
     * @version 1.0
     */
    private function createCacheKey():string {
        $cacheKeyFormat = getConfigs('cache_key_format');

        if(empty($cacheKeyFormat)){
            $cacheKeyFormat = '%application%.%controller%[%action%]';
        }

        $keyWord = array(
            '%host%',
            '%httpscheme%',
            '%app_type%',
            '%application%',
            '%controller%',
            '%action%'
        );
        $keyWord = new_app_anchor('custom_cachekey_keywords',[$keyWord]);

        $replace = array(
            $this->host,
            $this->scheme,
            $this->type,
            $this->application,
            $this->controller,
            $this->action
        );
        $replace = new_app_anchor('custom_cachekey_replace',[$replace]);

        $cacheKeyFormat = str_replace($keyWord,$replace,$cacheKeyFormat);

        return $cacheKeyFormat;
    }

    /**
     * @return mixed
     */
    public function getPageCache()
    {
        return $this->page_cache;
    }

    /**
     * @return string
     *
     * @version 1.0
     */
    public function getCacheKey()
    {
        return $this->cache_key;
    }

    /**
     * @return mixed
     */
    public function getViewByFolder()
    {
        return $this->view_by_folder;
    }

    /**
     * @return mixed
     */
    public function getDisableAllTemplate()
    {
        return $this->disable_all_template;
    }

    /**
     * @return string
     *
     * @version 1.0
     */
    public function getBaseUri()
    {
        $scheme = (is_bool(getConfigs('force_https')) && getConfigs('force_https')) ? 'https' : 'http';

        if(!getConfigs('force_https')){
            $scheme = $this->scheme;
        }

        return $scheme.'://'.$this->host;
    }

    /**
     * @return bool
     */
    public function getInternalRest(): bool
    {
        return $this->is_internal_rest;
    }

    /**
     * @return null
     */
    public function getCustomView()
    {
        return $this->custom_view;
    }

    /**
     * @return null
     */
    public function getIsCache()
    {
        return $this->isCache;
    }

    /**
     * @param $name
     * @return bool
     *
     * @version 1.0
     */
    public function __get($name)
    {
        if(isset($this->$name))
            return $this->$name;
        else
            return false;
    }

    /**
     * @param $name
     * @param $arguments
     * @return bool|string|null
     *
     * @version 1.0
     */
    public function __call($name, $arguments)
    {
        if(strpos($name,'get') !== false){
            $original = $name;
            $name = 'get';
        }

        switch ($name){
            case 'get':
                $field = strtolower(substr($original,3));

                if(property_exists(get_called_class(),$field)){
                    return $this->$field;
                } else {
                    return false;
                }

                break;
        }
    }

}