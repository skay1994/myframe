<?php

declare(strict_types=1);

namespace SKYCore;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class Configuration
 * @package SKYCore
 *
 * @version 1.0
 */
class Configuration
{
    /**
     * @var null
     */
    static private $_configs = null;

    /**
     * @var null
     */
    static private $instance = null;

    public function __construct()
    {
        if (self::$_configs === null) {
            $this->global();
        }
        
    }

    /**
     * @return null
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function load(string $app, bool $not_merge = false)
    {
        if ($app == 'app_error') {
            return false;
        }

        $global = new \FileSystemIterator(APPPATH.ucfirst($app).DS.'config', \FilesystemIterator::SKIP_DOTS);

        $A = [];

        foreach ($global as $key => $value) {
            if ($value->isFile()) {
                include $value->getPathname();
            }
        }

        if (isset($A['apps'])) {
            unset($A['apps']);
        }
        if (isset($A['default_app'])) {
            unset($A['default_app']);
        }
        if (isset($A['multiapp'])) {
            unset($A['multiapp']);
        }

        if ((isset($A['global_config']) && is_bool($A['global_config'])) && !$A['global_config']) {
            self::$_configs = [];
        }

        if ($not_merge) {
            self::$_configs = $A;
        } else {
            self::$_configs = array_merge(self::$_configs, $A);
        }

        return self::$_configs;
    }

    static function load_config_not_merge(string $app)
    {
        return self::$instance->load($app, true);
    }

    private function global()
    {
        $global = null;

        try {
            $global = new \FileSystemIterator(APPPATH.'global'.DS.'config', \FilesystemIterator::SKIP_DOTS);
            sLog_info('Loaded global configuration file');
        } catch (\Exception $e) {
            sLog_critical($e->getMessage());
        }

        $C = [];

        foreach ($global as $key => $value) {
            if ($value->isFile()) {
                include $value->getPathname();
            }
        }

        self::$_configs = $C;
    }

    public function config()
    {

        $configs = self::$_configs;
        if (is_string($configs['apps'])) {
            $this->load($configs['apps']);
        } elseif ((isset($configs['apps']) && is_array($configs['apps'])) &&
            (is_bool($configs['multiapp'] && $configs['multiapp']))
        ) {
        };
    }

    /**
     * @return array
     */
    public static function getConfigs()
    {
        return self::$_configs;
    }

    public function __get($name)
    {
        $configs = self::getConfigs();
        if (isset($configs[$name])) {
            return $configs[$name];
        } else {
            return null;
        }
    }

    public function __set($name, $value)
    {
        $protects = [
            'apps','multiapps',
            'global_config',
            'default_app','autoload_language',
            'autoload_modules',
            'default_controller','default_action',
            'app_folder',
            'autoload',
            'use_composer','composer_path',
            'enable_db','db_connect','db_user','db_password'
        ];

        if (!array_search($name, $protects)) {
            self::$_configs[$name] = $value;
        }
    }
}
