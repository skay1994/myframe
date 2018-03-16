<?php

namespace SKYCore;

use SKYCore\Traits\Helpers\CurrentApp;
use Symfony\Component\Filesystem\Filesystem;
/**
 * Class ModuleHelper
 * @package SKYCore
 *
 * @version 1.0
 */
class ModuleHelper
{
    use CurrentApp;
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var string
     */
    private $apppath;

    /**
     * @var string
     */
    private $modulepath;

    public function __construct(string $module)
    {
        $this->filesystem = new Filesystem();

        $this->apppath = APPPATH.$this->currentApp().DS;

        $this->modulepath = APPPATH.$this->currentApp().DS.'modules'.DS.$module.DS;
    }

    /**
     * @return Filesystem
     */
    public function getFilesystem(): Filesystem
    {
        return $this->filesystem;
    }

    /**
     * @return string
     */
    public function getApppath(): string
    {
        return $this->apppath;
    }

    /**
     * @return string
     */
    public function getModulepath(): string
    {
        return $this->modulepath;
    }

    /**
     * @param string $locale
     * @param int $posix
     *
     * @version 1.0
     */
    public function mkdir(string $locale,int $posix = 0777)
    {
        $locale = $this->apppath.$locale;
        $this->filesystem->mkdir($locale,$posix);
    }

    /**
     * @param $files
     * @return bool
     *
     * @version 1.0
     */
    public function exists(string $path,$file)
    {
        $app_path = $this->apppath.$path;

        $files = [];

        if(is_array($file)){
            foreach ($file as $value){
                $files[] = $app_path.$value;
            }
        } else {
            $files[] = $app_path.$file;
        }

        return $this->filesystem->exists($files);
    }

    /**
     * @param string $files
     * @param int $mode
     * @param int $umask
     * @param bool $recursive
     *
     * @version 1.0
     */
    function chmod(string $files,int $mode, int $umask = 0000, bool $recursive = false){
        $this->filesystem->chmod($files, $mode, $umask, $recursive);
    }

    /*******************************************************************************************************************/
    /*********************************** Copy Files to Application *****************************************************/
    /*******************************************************************************************************************/

    /**
     * @param array $setting_file
     *
     * @version 1.0
     */
    public function copySetting(array $setting_file)
    {
        foreach ($setting_file as $value){
            $config_exists = $this->exists('config',$value['config_path']);

            if(!$config_exists){
                $this->filesystem->copy($this->modulepath.$value['module_path'],$this->apppath.'config'.DS.$value['config_path']);
            }
        }
    }

    /**
     * @param array $controller_file
     *
     * @version 1.0
     */
    public function copyController(array $controller_file){
        foreach ($controller_file as $value){
            $config_exists = $this->exists('controller',$value['config_path']);

            if(!$config_exists){
                $this->filesystem->copy($this->modulepath.$value['module_path'],$this->apppath.'controller'.DS.$value['config_path']);
            }
        }
    }

    /**
     * @param array $controller_file
     *
     * @version 1.0
     */
    public function copyCore(array $controller_file){
        foreach ($controller_file as $value){
            $config_exists = $this->exists('core',$value['config_path']);

            if(!$config_exists){
                $this->filesystem->copy($this->modulepath.$value['module_path'],$this->apppath.'core'.DS.$value['config_path']);
            }
        }
    }

    /**
     * @param array $controller_file
     *
     * @version 1.0
     */
    public function copyTemplate(array $controller_file){
        foreach ($controller_file as $value){
            $config_exists = $this->exists('template',$value['config_path']);

            if(!$config_exists){
                $this->filesystem->copy($this->modulepath.$value['module_path'],$this->apppath.'template'.DS.$value['config_path']);
            }
        }
    }

    /**
     * @param array $controller_file
     *
     * @version 1.0
     */
    public function copyView(array $controller_file){
        foreach ($controller_file as $value){
            $config_exists = $this->exists('view',$value['config_path']);

            if(!$config_exists){
                $this->filesystem->copy($this->modulepath.$value['module_path'],$this->apppath.'view'.DS.$value['config_path']);
            }
        }
    }
}