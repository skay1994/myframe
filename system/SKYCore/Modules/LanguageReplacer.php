<?php

namespace SKYCore\Modules;

use SKYCore\Load;
use SKYCore\Routing;
use SKYCore\Traits\Helpers\{Configurations,CurrentApp};
use SKYCore\Interfaces\LanguageReplacer as LangReplaceInterface;
/**
 * Class LanguageReplacer
 * @package SKYCore\Modules
 *
 * @version 1.0
 */
class LanguageReplacer implements LangReplaceInterface
{
    use CurrentApp, Configurations;

    /**
     * @var array|object
     */
    private $file_contents;

    /**
     * @var string
     */
    private $baseModel;

    /**
     * @var string
     */
    private $fileType;

    /**
     * @var string
     */
    private $getBaseText;

    /**
     * @var array
     */
    private $pattern;

    /**
     * @var array
     */
    public $models;

    /**
     * @var array
     */
    public $texts;

    public function __construct(array $configs = null)
    {
        if($configs === null){
            $configs = getConfigs('language_replacer_global_settings');
        }

        $this->baseModel = $configs['base_model'] ?? '';
        $this->getBaseText = $configs['base_text'] ?? '';

        $this->pattern = $configs['pattern'] ?? array('{{ ',' }}');

        if(isset($configs['by_file'])){

            $configs = $configs['by_file'];

            $file = $configs['file'];

            $this->fileType = $configs['file_type'] ?? 'json';

            $typeLength = strlen($configs['file_type']);

            $current = $this->currentApp();

            if(isset($configs['file_by_app'])){

                if($configs['file_by_app'] === 'global'){
                    $filePath = APPPATH.'global'.DS;
                } elseif (in_array($this->getConfigs('apps'),$configs['file_by_app'])){
                    $filePath = APPPATH.ucfirst($configs['file_by_app']).DS;
                } else {
                    $filePath = APPPATH.ucfirst($current).DS;
                }
            } else {
                $filePath = APPPATH.ucfirst($current).DS;
            }

            if(!isset($configs['external_file'])){
                $filePath = $filePath.'language'.DS.'langreplace'.DS;
                $file = $filePath.substr($file,0, -$typeLength);
                $file = $file.$configs['file_type'];
            }

            try {
                $this->getFile($file);
            } catch (\Exception $e){
                throw new \Exception($e->getMessage());
            }
        }
    }

    /**
     * @param string $url
     *
     * @version 1.0
     */
    public function getFile(string $url)
    {
        if(file_exists($url)){
            if($this->fileType == 'json'){
                $this->file_contents = json_decode(file_get_contents($url));
            } elseif($this->fileType == 'xml') {
                $this->file_contents = simplexml_load_string(file_get_contents($url));
            }
        }
    }

    /**
     * @return array|object
     */
    public function getFileContents()
    {
        return $this->file_contents;
    }

    /**
     * @return $this
     *
     * @version 1.0
     */
    public function getModels()
    {
        if(!$this->file_contents){
            return null;
        }

        if($this->getBaseText != ''){
            $base = $this->getBaseText;
            $strings = $this->file_contents->$base;
        } else {
            $strings = $this->file_contents;
        }

        //Count the number of items in the array
        $indice = count((array)$strings);

        //get keys of itens
        $keys = array_keys((array) $strings);

        $model = null;

        if($model === null){
            for($a = 0; $a < $indice;$a++){
                $indice1 = $keys[$a];

                $cnt1 = count((array) $strings->$indice1);

                for($e = 0; $e < $cnt1; $e++){

                    $keys1 = array_keys((array)$strings->$indice1);

                    $indice2 = $keys1[$e];

                    if(!is_numeric($indice2)){

                        $cnt2 = count(array_keys((array) $strings->$indice1->$indice2));

                        $keys2 = array_keys((array) $strings->$indice1->$indice2);

                        for ($i = 0; $i < $cnt2;$i++){
                            if(!is_numeric($keys2[$i])){

                                for($i = 0;$i < $cnt2;$i++){
                                    $indice3 = $keys2[$i];

                                    $cnt3 = count(array_keys((array) $strings->$indice1->$indice2->$indice3));

                                    if($cnt3 > 1){
                                        $keys3 = array_keys((array) $strings->$indice1->$indice2->$indice3);

                                        for ($o = 0;$o < $cnt3;$o++){
                                            $indice4 = $keys3[$o];

                                            $cnt4 = count(array_keys((array)$strings->$indice1->$indice2->$indice3->$indice4));

                                            if(is_object($strings->$indice1->$indice2->$indice3->$indice4)){

                                                $keys4 = array_keys((array)$strings->$indice1->$indice2->$indice3->$indice4);

                                                for($u = 0; $u < $cnt4; $u++){
                                                    $indice5 = $keys4[$u];
                                                    $model .= $this->pattern[0] . $this->baseModel . '.' . $indice1 . '.' . $indice2 . '.' . $indice3 .'.' . $indice4 . '.' . $indice5 . $this->pattern[1] . ',';
                                                }

                                            } else {
                                                $model .= $this->pattern[0] . $this->baseModel . '.' . $indice1 . '.' . $indice2 . '.' . $indice3 . '.' . $indice4 . $this->pattern[1] . ',';

                                            }
                                        }
                                    } else {
                                        if(is_object($strings->$indice1->$indice2->$indice3)){
                                        } else
                                            $model .= $this->pattern[0] . $this->baseModel . '.' . $indice1 . '.' . $indice2 . '.' . $indice3 . $this->pattern[1] . ',';
                                    }
                                }
                            } else
                                $model .= $this->pattern[0] . $this->baseModel . '.' . $indice1 . '.' . $indice2 . $this->pattern[1] . ',';
                        }

                    } else
                        $model .= $this->pattern[0] . $this->baseModel . '.' . $indice1 . $this->pattern[1].',';

                }
            }
        }

        $this->models = array_unique(array_filter(explode(',',$model)));

        return $this;
    }

    /**
     * @return $this
     *
     * @version 1.0
     */
    public function getTexts()
    {
        if(!$this->file_contents){
            return null;
        }

        if($this->getBaseText != ''){
            $base = $this->getBaseText;
            $strings = $this->file_contents->$base;
        } else {
            $strings = $this->file_contents;
        }

        $indice = count((array )$strings);

        $keys = array_keys((array) $strings);
        $texts = [];

        for($a = 0; $a < $indice;$a++){
            $indice1 = $keys[$a];

            $cnt1 = count((array) $strings->$indice1);

            for($e = 0; $e < $cnt1; $e++){

                $keys1 = array_keys((array)$strings->$indice1);

                $indice2 = $keys1[$e];

                if(!is_numeric($indice2)){
                    $cnt2 = count(array_keys((array) $strings->$indice1->$indice2));

                    if($cnt2 > 1){
                        $keys2 = array_keys((array) $strings->$indice1->$indice2);
                        for($i = 0;$i < $cnt2;$i++){
                            $indice3 = $keys2[$i];

                            $cnt3 = count(array_keys((array) $strings->$indice1->$indice2->$indice3));

                            if($cnt3 > 1){
                                $keys3 = array_keys((array) $strings->$indice1->$indice2->$indice3);

                                for ($o = 0;$o < $cnt3;$o++){
                                    $indice4 = $keys3[$o];

                                    if(isset($strings->$indice1->$indice2->$indice3->$indice4) && is_object($strings->$indice1->$indice2->$indice3->$indice4)){
                                        $keys4 = array_keys((array) $strings->$indice1->$indice2->$indice3->$indice4);
                                        $cnt4 = count($keys4);

                                        for($u = 0; $u < $cnt4; $u++){
                                            $indice5 = $keys4[$u];

                                            if(is_object($strings->$indice1->$indice2->$indice3->$indice4->$indice5)){
                                                $keys5 = array_keys((array) $strings->$indice1->$indice2->$indice3->$indice4->$indice5);
                                                $cnt5 = count($keys5);

                                                for ($aa = 0; $aa < $cnt5;$aa++){
                                                    $indice6 = $keys5[$aa];

                                                    if(is_object($strings->$indice1->$indice2->$indice3->$indice4->$indice5->$indice6)){
                                                        $keys3 = array_keys((array) $strings->$indice1->$indice2->$indice3->$indice4->$indice5->$indice6);
                                                        $cnt3 = count($keys3);

                                                        for ($ae = 0; $ae < $cnt3;$ae++){
                                                            $indice7 = $keys3[$ae];

                                                            $texts[] = (string) $strings->$indice1->$indice2->$indice3->$indice4->$indice5->$indice6->$indice7;
                                                        }
                                                    } else
                                                        $texts[] = (string) $strings->$indice1->$indice2->$indice3->$indice4->$indice5->$indice6;
                                                }
                                            } else {
                                                $texts[] = (string) $strings->$indice1->$indice2->$indice3->$indice4->$indice5;
                                            }
                                        }

                                    } else {
                                        if(isset($strings->$indice1->$indice2->$indice3->$indice4)){
                                            $texts[] = (string) $strings->$indice1->$indice2->$indice3->$indice4;
                                        }
                                    }
                                }

                            } else {

                                if(is_object($strings->$indice1->$indice2->$indice3)){
                                    $keys3 = array_keys((array) $strings->$indice1->$indice2->$indice3);
                                    $cnt3 = count($keys3);

                                    for ($o = 0; $o < $cnt3;$o++){
                                        $indice4 = $keys3[$o];

                                        $texts[] = (string) $strings->$indice1->$indice2->$indice3->$indice4;
                                    }
                                } else
                                    $texts[] = (string) $strings->$indice1->$indice2->$indice3;
                            }
                        }

                    } else {

                        if(is_object($strings->$indice1->$indice2)){

                            $cnt2 = count(array_keys((array) $strings->$indice1->$indice2));

                            if($cnt2 >= 1) {
                                $keys2 = array_keys((array)$strings->$indice1->$indice2);

                                for ($i = 0; $i < $cnt2; $i++) {
                                    $indice3 = $keys2[$i];

                                    $cnt3 = count(array_keys((array)$strings->$indice1->$indice2->$indice3));

                                    if ($cnt3 >= 1) {

                                        if(is_object($strings->$indice1->$indice2->$indice3)){
                                            $keys3 = array_keys((array)$strings->$indice1->$indice2->$indice3);

                                            for ($o = 0; $o < $cnt3; $o++) {
                                                $indice4 = $keys3[$o];
                                                if(is_object($strings->$indice1->$indice2->$indice3->$indice4)){
                                                    $cnt4 = count(array_keys((array)$strings->$indice1->$indice2->$indice3->$indice4));
                                                    $keys4 = array_keys((array)$strings->$indice1->$indice2->$indice3->$indice4);

                                                    for ($u = 0;$u < $cnt4; $u++){
                                                        $indice5 = $keys4[$u];
                                                        $texts[] = (string)$strings->$indice1->$indice2->$indice3->$indice4->$indice5;
                                                    }

                                                } else
                                                    $texts[] = (string)$strings->$indice1->$indice2->$indice3->$indice4;
                                            }
                                        } else {
                                            $texts[] = (string)$strings->$indice1->$indice2->$indice3;
                                        }

                                    } else {
                                        $texts[] = (string)$strings->$indice1->$indice2->$indice3;
                                    }
                                }
                            }
                        } else {
                            $texts[] = (string) $strings->$indice1->$indice2;
                        }
                    }
                } else {
                    $texts[] =(string) $strings->$indice1;
                }
            }
        }

        $this->texts = array_values(array_filter($texts));

        return $this;
    }

    /**
     * @param string $file_contents
     */
    public function setFileContents($file_contents)
    {
        $this->file_contents = $file_contents;
    }

    /**
     * @param string $html
     * @return mixed
     *
     * @version 1.0
     */
    public function result(string $html)
    {
        return str_replace($this->models,$this->texts,$html);
    }

    /**
     * @return languageReplacer
     *
     * @version 1.0
     */
    public static function langReplaceByControllerWF():languageReplacer
    {
        /** @var routing $router */
        $router = Load::getLoadedStatic('Routing')['object'];
        $configs = getConfigs('language_replacer_global_settings');
        $configs['base_model'] = $configs['base_model'].'.'.$router->controller;
        $configs['by_file']['file'] = getConfigs('default_language').DS.$router->controller.'.'.$configs['by_file']['file_type'];

        $customLR = new LanguageReplacer($configs);
        $customLR->getModels();
        $customLR->getTexts();

        return $customLR;
    }

    /**
     * @return languageReplacer
     *
     * @version 1.0
     */
    public static function langReplaceByControllerAndActionWF():languageReplacer
    {
        /** @var routing $router */
        $router = Load::getLoadedStatic('Routing')['object'];
        $configs = getConfigs('language_replacer_global_settings');
        $configs['base_model'] = $configs['base_model'].'.'.$router->controller.'.'.$router->action;
        $configs['by_file']['file'] = getConfigs('default_language').DS.$router->controller.'['.$router->action.']'.$configs['by_file']['file_type'];

        $customLR = new LanguageReplacer($configs);
        $customLR->getModels();
        $customLR->getTexts();

        return $customLR;
    }
}