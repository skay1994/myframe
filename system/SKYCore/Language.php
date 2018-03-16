<?php

namespace SKYCore;
use SKYCore\Traits\Helpers\CurrentApp;

/**
 * @method system
 *
 * Class Language
 * @package SKYCore
 *
 * @version 1.0
 */
class Language
{
    use CurrentApp;

    private $_language = array();
    private $_type;
    private $_text = null;
    private $_return = '';
    static $files = array();

    /**
     * Language strings are loaded in system
     * @var
     */
    public $text;
    /**
     * @var null
     */
    private static $instance = null;

    /**
     * SKY_Language constructor.
     */
    public function __construct()
    {

        if(!is_null(getConfigs('default_language')) && !empty(getConfigs('default_language')))
            $this->_language = getConfigs('default_language');
        else
            $this->_language = 'en-us';

        if(!is_null(getConfigs('language_file_type')) && !empty(getConfigs('language_file_type')))
            $this->_type = getConfigs('language_file_type');
        else
            $this->_type = 'json';

        if(!is_null(getConfigs('language_return_type')) && !empty(getConfigs('language_return_type')))
            $this->_return = getConfigs('language_return_type');
        else
            $this->_return = 'object';

        return $this;
    }

    /**
     * @param string $file filename to load to language
     * @param string $app select the app path to load a language
     * @return array
     *
     * @version 1.0
     */
    public function load(string $file,string $base_lang = null,string $group = null,string $app = null,string $type = null,string $return = null)
    {
        $LANG = array();
        $text = array();

        if($type)
            $this->_type = $type;

        $fileName = str_replace(
                ['-','.'],
                ['_','_'],
                $file);

        if(!empty($app))
            $lang_file = $this->checkFile($fileName,$app);
        else
            $lang_file = $this->checkFile($fileName,$this->currentApp());

        try {
            if ($lang_file) {

                if ($group) {
                    if (!array_key_exists($group, self::$files)) {

                        /** check if exist the base for lang file */
                        if (!is_null($base_lang)) {
                            if ($this->_type == 'json')
                                $text = json_decode(file_get_contents($lang_file), true)[$base_lang];
                            elseif ($this->_type == 'array') {
                                include_once $lang_file;
                                $text = $LANG[$base_lang];
                            }
                        } else {
                            if ($this->_type == 'json')
                                $text = json_decode(file_get_contents($lang_file), true);
                            elseif ($this->_type == 'array') {
                                include_once $lang_file;
                                $text = $LANG;
                            }
                        }

                        $this->_text[$group][$fileName] = self::$files[$group][$fileName] = $text;
                    } else {
                        if (!array_key_exists($file, self::$files[$group])) {

                            /** check if exist the base for lang file */
                            if (!is_null($base_lang)) {
                                if ($this->_type == 'json')
                                    $text = json_decode(file_get_contents($lang_file), true)[$base_lang];
                                elseif ($this->_type == 'array') {
                                    include_once $lang_file;
                                    $text = $LANG[$base_lang];
                                }
                            } else {
                                if ($this->_type == 'json')
                                    $text = json_decode(file_get_contents($lang_file), true);
                                elseif ($this->_type == 'array') {
                                    include_once $lang_file;
                                    $text = $LANG;
                                }
                            }

                            $this->_text[$group][$fileName] = self::$files[$group][$fileName] = $text;
                        } else {
                            $this->_text[$group][$fileName] = self::$files[$group][$fileName];
                        }
                    }
                } else {
                    if (!array_key_exists($file, self::$files)) {

                        if ($this->_type == 'json')
                            $text = json_decode(file_get_contents($lang_file), true);
                        elseif ($this->_type == 'array' || $this->_type == 'php') {
                            include_once $lang_file;
                            $text = $LANG;
                        }

                        $this->_text[$fileName] = self::$files[$fileName] = $text;

                    } else
                        $this->_text[$fileName] = self::$files[$fileName];
                }
            }

            if (empty($return)) {
                if ($this->_return == 'object') {
                    $this->text = json_decode(json_encode($this->_text));
                } elseif ($this->_return == 'array') {
                    $this->text = $this->_text;
                } else {
                    throw new \Exception('Language invalid return type');
                }
            } else {
                if ($return == 'object') {
                    $this->text = json_decode(json_encode($this->_text));
                } elseif ($return == 'array') {
                    $this->text = $this->_text;
                }
            }

            $this->text = json_decode(json_encode($this->_text));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param string $file
     * @param string $app
     * @return bool|string
     * @throws \Exception
     *
     * @version 1.0
     */
    private function checkFile(string $file,string $app)
    {
        if(!empty($app)){
            if($app == 'system'){
                $path = SYSPATH.'language'.DS;
            } elseif($app == 'cli'){
                $path = SYSPATH.'bin'.DS.'language'.DS;
            } elseif($app == 'global'){
                $path = APPPATH.'global'.DS.'language'.DS;
            } else {
                $path = APPPATH.$app.DS.'language'.DS;
            }

            if(file_exists($path . $this->_language . DS . $file .'.'. $this->_type)){
                return $path . $this->_language . DS . $file .'.'. $this->_type;
            } else {
                if($this->_type == 'array' || $this->_type == 'php'){
                    $type = 'php';
                } else {
                    $type = 'json';
                }
                throw new \Exception(sprintf(getLangGroup('system','language','file_not_exists'),$file.'.'.$type,$path.$this->_language));
            }
        }

        return false;
    }

    /**
     * @return array|string
     *
     * @version 1.0
     */
    public function getLanguage()
    {
        return $this->_language;
    }

    /**
     * @version 1.0
     */
    function loadSysLanguage()
    {
        $this->_type = 'json';

        $files = new \FilesystemIterator(SYSPATH.'language'.DS.$this->_language.DS,\FilesystemIterator::SKIP_DOTS);

        foreach ($files as $file){
            $this->load(substr($file->getFileName(),0,-5),'system','system');
        }

        $this->_type = getConfigs('language_file_type');
    }

    /**
     * @param string $lang
     *
     * @version 1.0
     */
    function setLanguage(string $lang )
    {
        $this->_language = $lang;
    }

    /**
     * @param string $type
     * @throws \Exception
     *
     * @version 1.0
     */
    function setReturnType(string $type)
    {

        if(!empty($type) && $type == 'object' || $type == 'array'){
            $this->_type = $type;
        } else {
            throw new \Exception(sprintf(getLangGroup('system','language','invalid_current_return_type')));
        }
    }

    /**
     * @param string $type
     *
     * @version 1.0
     */
    function setTypeFile(string $type){
        $this->_type = $type;
    }

    /**
     * @param string $name
     * @param $arguments
     * @return bool|null
     *
     * @version 1.0
     */
    public function __call( string $name, $arguments)
    {
        $name = str_replace(
            ['-','.'],
            ['_','_'],
            $name);

        if(isset($this->_text[$name])){
            if(count($arguments) > 0) {

                if((count($arguments) == 3)){
                    if(isset($this->_text[$name][$arguments[0]][$arguments[1]][$arguments[2]])){
                        $one = $arguments[0];
                        $two = $arguments[1];
                        $tree = $arguments[2];

                        if($this->_return === 'object'){
                            return $this->text->$name->$one->$two->$tree;
                        } else {
                            return $this->text[$name][$arguments[0]][$arguments[1]][$arguments[2]];
                        }
                    } else {
                        return null;
                    }

                } elseif(count($arguments) == 2) {
                    if(isset($this->_text[$name][$arguments[0]][$arguments[1]])){
                        $one = $arguments[0];
                        $two = $arguments[1];

                        if($this->_return === 'object'){
                            return $this->text->$name->$one->$two;
                        } else {
                            return $this->text[$name][$arguments[0]][$arguments[1]];
                        }
                    } else {
                        return null;
                    }
                } elseif(count($arguments) == 1) {
                    if(isset($this->_text[$name][$arguments[0]])){
                        $one = $arguments[0];

                        if($this->_return === 'object'){
                            return $this->text->$name->$one;
                        } else {
                            return $this->text[$name][$arguments[0]];
                        }
                    } else {
                        return null;
                    }
                }
            } else {
                if($this->_return === 'object'){
                    return $this->text->$name;
                } else {
                    return $this->text[$name];
                }

            }
        } else {
            return false;
        }

    }

}