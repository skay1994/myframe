<?php

namespace SKYCore\Controllers;

use SKYCore\{
    Cache, Configuration, Database, Interfaces, Language, load, Routing, Session, Traits\Helpers\CurrentApp
};
use Symfony\Component\HttpFoundation\Request;

/**
 * @property Configuration $config
 * @property Load $load
 * @property Database $db
 * @property Language $lang
 * @property Cache $cache
 * @property Request $request
 * @property Session $session
 * @property Routing $router
 *
 * Class Controller
 * @package SKYCore\Controllers
 *
 * @version 1.0
 */
class Controller implements Interfaces\Controller {

    private static $instance;

    public $modules;

    protected $disable_cache = false;

    use CurrentApp;

    public function __construct()
    {

        foreach (Load::getLoadedStatic() as $class){
            $name = strtolower($class['name']);
            $this->$name = $class['object'];
        }
    }

    /**
     * @return controller
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
     * Load class or files to use in system
     *
     * @param string $type
     * @param string $file
     * @param string|null $app
     * @throws \Exception
     *
     * @version 1.0
     */
    public function load(string $type,string $file,string $app = null)
    {
        if(!$app)
            $app = $this->currentApp();

        if ($type == 'module'){
            if($app == 'global')
                $load = load::loadStatic($file,'global_modules');
            else
                $load = load::loadStatic($file,'modules',$app);

            if($load){
                $name = $load['name'];
                $this->modules->$name = $load['object'];
            }
        } elseif($type == 'helper'){

            $file = str_replace('.php','',$file).'.php';

            if($app == 'global'){
                $path = APPPATH.'global'.DS.'helper'.DS;
            } else {
                $path = APPPATH.$app.DS.'helper'.DS;;
            }

            $file = $path.$file;

            if(file_exists($file)){
                include_once $file;
            } else {
                throw new \Exception(sprintf(getLangGroup('system','helpers','nofile'),$file,$file));
            }
        }
    }

    /**
     * Set file to load in view on return method
     *
     * @param string $view
     * @param array $data
     * @param bool $disableTemplate
     *
     * @version 1.0
     */
    public function view(string $view,array $data = [],bool $disableTemplate = false){
        Load::getLoadedStatic('Output')['object']->setView($view,$data,$disableTemplate);
    }

    /**
     * Get the $_POSTS contents
     *
     * @return mixed
     *
     * @version 1.0
     */
    public function post_content(){
        return $this->request->request->all();
    }

    /**
     * Get the $_GET contents
     *
     * @return mixed
     *
     * @version 1.0
     */
    public function get_content(){
        return $this->request->query->all();
    }

    /**
     * Get the $_FILES content
     *
     * @return mixed
     *
     * @version 1.0
     */
    public function file_content(){
        return $this->request->files->all();
    }

    /**
     * @return bool
     */
    public function status_cache():bool
    {
        if(property_exists($this,'disable_cache')){
            return !$this->disable_cache;
        } else {
            return (is_bool(getConfigs('enable_cache')) && getConfigs('enable_cache'));
        }
    }

    /**
     * @return bool
     */
    public function view_by_folder():bool
    {
        if(isset($this->view_by_folder)){
            return $this->view_by_folder;
        } else {
            return (is_bool(getConfigs('view_by_folder')) && getConfigs('view_by_folder'));
        }
    }

    /**
     * @return string|null
     */
    public function custom_view_folder()
    {
        if(isset($this->custom_view_folder)){
            return $this->custom_view_folder;
        } else {
            return null;
        }
    }

    /**
     * @return bool
     */
    public function disable_all_template()
    {
        if(isset($this->disable_all_template)){
            return !$this->disable_all_template;
        } else {
            return null;
        }
    }
}