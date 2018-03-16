<?php

namespace SKYCore;

use SKYCore\Modules\LanguageReplacer;
use SKYCore\Traits\Helpers\Configurations;
use Symfony\Component\Cache\CacheItem;
use Symfony\Component\Templating\{
    Loader\FilesystemLoader,
    PhpEngine,
    TemplateNameParser
};
/**
 * Class Output
 * @package SKYCore
 *
 * @version 1.0
 */
class Output
{
    use configurations;

    /**
     * @var PhpEngine
     */
    private $templating;

    /**
     * @var string
     */
    private $view_path = '';

    /**
     * @var
     */
    private $template_path = '';

    /**
     * @var array
     */
    private $template = [];

    /**
     * @var bool
     */
    private $use_template = false;

    /**
     * @var array
     */
    private $data = [];

    /**
     * @var cache
     */
    private $cache;

    /**
     * @var FilesystemLoader
     */
    private $filesystem;

    private $disableTemplateByView = false;

    /**
     * Output constructor.
     */
    public function __construct()
    {
        $this->cache = Load::getLoadedStatic('Cache')['object'];
        $this->data = (array) $this->getConfigs('view_data') ?? [];
    }

    /**
     * @version 1.0
     */
    private function view_template(){
        $template = [];

        $user_view = null;

        if(isset($this->template['view'])){
            $user_view = $this->template['view'];
        }

        if($this->use_template){

            $configTemplate = (array) $this->getConfigs('view_template') ?? [];

            $template = [];

            if(!isset($configTemplate['view'])){
                $template['header'] = $configTemplate['header'] ?? '';
                $template['view'] = '';
                $template['footer'] = $configTemplate['footer'] ?? '';
            } else {
                $template = $configTemplate;
            }

        } else {
            $template['view'] = '';
        }

        if($user_view){
            $template['view'] = $user_view;
        }

        $this->template = $template;
    }

    /**
     * @param array $view_template
     * @return array
     * @version 1.0
     */
    private function view_data(array $view_template){
        $router = Load::getLoadedStatic('Routing')['object'];
        $config = Load::getLoadedStatic('Configuration')['object'];

        $data = new_system_anchor('view_data_content',[$this->data]);

        if(isset($data['all'])){
            $all = $data['all'];
            unset($data['all']);
        }

        if(isset($all) && is_array($all)){
            foreach($view_template as $key => $values){
                $data[$key] = array_merge($all,$data[$key] ?? []);
            }
        }

        $data['lang'] = $config->html_lang;
        $data['base'] = $router->site_uri;

        if(!isset($data['title'])){
            $data['title'] = '%app-controller% - %app-name%';
        }

        $strings = [
            '%app-controller%',
            '%app-name%',
            '%app-folder%',
            '%app-view%',
            '%app-type%'
        ];
        $strings = new_system_anchor('view_data_keywords',[$strings]);

        $replace = [
            ucfirst($router->controller),
            ucfirst($config->app_name),
            ucfirst($config->app_folder),
            ucfirst($router->action),
            ucfirst($router->type),
        ];
        $replace = new_system_anchor('view_data_keywords_replacement',[$replace]);

        foreach ($data as $key => $value){
            if(is_array($value)){
                foreach ($value as $key2 => $value2){
                    $data[$key][$key2] = str_replace($strings,$replace,$value2);
                }
            } else {
                $data[$key] = str_replace($strings,$replace,$value);
            }
        }

        return $data;
    }

    /**
     * @param string $file
     * @param array $data
     * @param bool $disableTemplate
     *
     * @version 1.0
     */
    public function setView(string $file, array $data = [], bool $disableTemplate = true){
        $this->data = array_merge($this->data,$data);

        $this->template['view'] = $file;

        if($disableTemplate){
            $this->use_template = false;
            $this->disableTemplateByView = true;
        }
    }

    /**
     * @version 1.0
     */
    public function setting_template()
    {
        /** @var Routing $router */
        $router = Load::getLoadedStatic('Routing')['object'];

        $app = $router->getApplication();
        $controller = $router->getController();
        $view_by_folder = $router->getViewByFolder();
        $use_template = $router->getDisableAllTemplate();
        $custom_view = $router->getCustomView();

        if(!$this->disableTemplateByView){
            if($use_template !== null && is_bool($use_template)){
                $this->use_template = $use_template;
            } else {
                $this->use_template = is_bool($this->getConfigs('use_template')) && $this->getConfigs('use_template');
            }
        }

        if(!$custom_view){
            if($view_by_folder){
                $this->view_path = APPPATH.ucfirst($app).DS.'views'.DS.$controller.DS;
            } else {
                $this->view_path = APPPATH.ucfirst($app).DS.'views'.DS;
            }
        } else {
            if(is_string($custom_view)){
                $this->view_path = APPPATH.ucfirst($app).DS.'views'.DS.$custom_view;
            } else {
                $this->view_path = APPPATH.ucfirst($app).DS.'views'.DS;
            }
        }

        $this->template_path = APPPATH.ucfirst($app).DS.'template'.DS;

        $loader = $this->filesystem = new FilesystemLoader([
            $this->view_path.'%name%',
            $this->template_path.'%name%'
        ]);

        $this->templating = new PhpEngine(new TemplateNameParser,$loader);
    }

    /**
     * @throws \Exception
     *
     * @version 1.0
     */
    public function output(){
        $this->setting_template();
        $this->view_template();

        $templating = $this->templating;

        /** @var routing $router */
        $router = Load::getLoadedStatic('Routing')['object'];

        $isCache = $router->getIsCache();
        $pageCache = $router->getPageCache();
        $cacheKey = $router->getCacheKey();

        $data = $this->view_data($this->template);

        foreach ($data as $key => $value){
            if(!is_array($value)){
                $templating->addGlobal($key,$value);
            }
        }

        if($isCache){

            if($pageCache) {
                /** @var CacheItem $cache */
                $cache = $pageCache;
                echo $cache->get();

            } else {

                $cache = $this->cache->getItem($cacheKey);

                foreach ($this->template as $key => $value){
                    $name = str_replace('.php','',$value);

                    if(!empty($value)){

                        try{
                            $this->checkFileExists($value);

                            if(isset($data[$name])){
                                echo $templating->render($value,$data[$name]);
                            } else {
                                echo $templating->render($value,[]);
                            }

                        } catch (\Exception $e){
                            throw new \Exception(sprintf(getLangGroup('system','views','not_exists'),$this->view_path.$value));
                        }
                    }
                }

                $html = ob_get_contents();
                ob_end_clean();

                if(is_bool($this->getConfigs('language_replacer')) && $this->getConfigs('language_replacer')){
                    $html = $this->langReplacer($html);
                }

                $cache->set($html);
                $this->cache->save($cache);

                echo $html;
            }

        } else {

            extract($this->view_data($this->template));

            foreach ($this->template as $key => $value){
                $name = str_replace('.php','',$value);

                if(!empty($value)){

                    try{
                        $this->checkFileExists($value);

                        if(isset($data[$name])){
                            echo $templating->render($value,$data[$name]);
                        } else {
                            echo $templating->render($value,[]);
                        }

                    } catch (\Exception $e){
                        ob_end_clean();
                        throw new \Exception(sprintf(getLangGroup('system','views','not_exists'),$this->view_path.$value));
                    }

                }
            }

            $html = ob_get_contents();
            ob_end_clean();

            if(is_bool($this->getConfigs('language_replacer')) && $this->getConfigs('language_replacer')){
                $html = $this->langReplacer($html);
            }

            echo $html;
        }

    }

    /**
     * @param string $html
     * @return string
     *
     * @version 1.0
     */
    private function langReplacer(string $html):string
    {
        $lr = null;

        if($this->getConfigs('custom_language_replace_class')){
            $classLR = $this->getConfigs('custom_language_replace_class');

            if(class_exists($classLR,false) == false){
                $class = new $classLR();

                if($class instanceof \SKYCore\Interfaces\LanguageReplacer){
                    $lr = $class;
                } else {
                    $lr = new LanguageReplacer();
                }
            } else {
                $lr = new LanguageReplacer();
            }
        } else {
            /**
             * Language Replace
             * @var LanguageReplacer $lr
             */
            $lr = new LanguageReplacer();
        }

        $lr->getModels();
        $lr->getTexts();

        $lr = new_system_anchor('application_langreplace',[$lr]);
        new_system_anchor('application_langreplace_debug',[$lr->models,$lr->texts]);

        return $lr->result($html);
    }

    /**
     * @param $filename
     * @return bool|\Symfony\Component\Templating\Storage\Storage
     * 
     * @version 1.0
     */
    private function checkFileExists($filename){
        $parser = new TemplateNameParser;
        $file = $parser->parse($filename);

        return $this->filesystem->load($file);
    }

}