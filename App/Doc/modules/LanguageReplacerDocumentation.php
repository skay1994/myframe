<?php

namespace App\Doc\Modules;
use SKYCore\Traits\Helpers\CurrentApp;
use SKYCore\Interfaces\LanguageReplacer as LangReplaceInterface;

/**
 * Class LanguageReplacer
 * @package SKY_Core\Modules
 */
class LanguageReplacerDocumentation implements LangReplaceInterface
{
    private $file_contents;
    private $baseModel;
    private $fileType;
    private $getBaseText;
    private $pattern;
    public $models;
    public $texts;

    use CurrentApp;

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

    public function getFile(string $url)
    {
        if($this->fileType == 'json'){
            $this->file_contents = json_decode(file_get_contents($url));
        } elseif($this->fileType == 'xml') {
            $this->file_contents = simplexml_load_string(file_get_contents($url));
        }
    }

    public function getModels()
    {
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

        static $model = null;

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

                                    if(is_object($strings->$indice1->$indice2->$indice3)){
                                        $keys3 = array_keys((array) $strings->$indice1->$indice2->$indice3);

                                        $cnt3 = count($keys3);

                                        for ($o = 0;$o < $cnt3;$o++){
                                            $indice4 = $keys3[$o];

                                            if(is_object($strings->$indice1->$indice2->$indice3->$indice4)){
                                                $keys4 = array_keys((array)$strings->$indice1->$indice2->$indice3->$indice4);

                                                $cnt4 = count($keys4);

                                                for($u = 0; $u < $cnt4; $u++){
                                                    $indice5 = $keys4[$u];

                                                    if(is_object($strings->$indice1->$indice2->$indice3->$indice4->$indice5)){
                                                        $keys5 = array_keys((array) $strings->$indice1->$indice2->$indice3->$indice4->$indice5);

                                                        $cnt5 = count($keys5);

                                                        for ($aa = 0; $aa < $cnt5; $aa++){
                                                            $indice6 = $keys5[$aa];

                                                            if(is_object($strings->$indice1->$indice2->$indice3->$indice4->$indice5->$indice6)){
                                                                $keys6 = array_keys((array) $strings->$indice1->$indice2->$indice3->$indice4->$indice5->$indice6);

                                                                $cnt6 = count($keys6);

                                                                for ($ae = 0; $ae < $cnt6; $ae++){
                                                                    $indice7 = $keys6[$ae];

                                                                    if(is_object($strings->$indice1->$indice2->$indice3->$indice4->$indice5->$indice6->$indice7)){
                                                                        $keys7 = array_keys((array) $strings->$indice1->$indice2->$indice3->$indice4->$indice5->$indice6->$indice7);

                                                                        $cnt7 = count($keys7);

                                                                        for ($ai = 0; $ai < $cnt7; $ai++){
                                                                            $indice8 = $keys7[$ai];

                                                                            if(is_object($strings->$indice1->$indice2->$indice3->$indice4->$indice5->$indice6->$indice7->$indice8)){
                                                                                $keys8 = array_keys((array) $strings->$indice1->$indice2->$indice3->$indice4->$indice5->$indice6->$indice7->$indice8);

                                                                                $cnt8 = count($keys8);

                                                                                for ($ao = 0; $ao < $cnt8; $ao++){
                                                                                    $indice9 = $keys8[$ao];

                                                                                    if(is_object($strings->$indice1->$indice2->$indice3->$indice4->$indice5->$indice6->$indice7->$indice8->$indice9)){
                                                                                        $keys9 = array_keys((array) $strings->$indice1->$indice2->$indice3->$indice4->$indice5->$indice6->$indice7->$indice8->$indice9);

                                                                                        $cnt9 = count($keys9);

                                                                                        for ($au = 0; $au < $cnt9; $au++){
                                                                                            $indice10 = $keys9[$au];

                                                                                            if(is_object($strings->$indice1->$indice2->$indice3->$indice4->$indice5->$indice6->$indice7->$indice8->$indice9->$indice10)){

                                                                                            } else {
                                                                                                $model .= $this->pattern[0] . $this->baseModel . '.' . $indice1 . '.' . $indice2 . '.' . $indice3 .'.' . $indice4 . '.' . $indice5 . '.' . $indice6 . '.' . $indice7 . '.' . $indice8 . '.' . $indice9 . '.' . $indice10 . $this->pattern[1] . ',';
                                                                                            }
                                                                                        }

                                                                                    } else {
                                                                                        $model .= $this->pattern[0] . $this->baseModel . '.' . $indice1 . '.' . $indice2 . '.' . $indice3 .'.' . $indice4 . '.' . $indice5 . '.' . $indice6 . '.' . $indice7 . '.' . $indice8 . '.' . $indice9 . $this->pattern[1] . ',';
                                                                                    }
                                                                                }

                                                                            } else {
                                                                                $model .= $this->pattern[0] . $this->baseModel . '.' . $indice1 . '.' . $indice2 . '.' . $indice3 .'.' . $indice4 . '.' . $indice5 . '.' . $indice6 . '.' . $indice7 . '.' . $indice8 . $this->pattern[1] . ',';
                                                                            }
                                                                        }

                                                                    } else {
                                                                        $model .= $this->pattern[0] . $this->baseModel . '.' . $indice1 . '.' . $indice2 . '.' . $indice3 .'.' . $indice4 . '.' . $indice5 . '.' . $indice6 . '.' . $indice7 . $this->pattern[1] . ',';
                                                                    }

                                                                }

                                                            } else {
                                                                $model .= $this->pattern[0] . $this->baseModel . '.' . $indice1 . '.' . $indice2 . '.' . $indice3 .'.' . $indice4 . '.' . $indice5 . '.' . $indice6 . $this->pattern[1] . ',';
                                                            }
                                                        }

                                                    } else {
                                                        $model .= $this->pattern[0] . $this->baseModel . '.' . $indice1 . '.' . $indice2 . '.' . $indice3 .'.' . $indice4 . '.' . $indice5 . $this->pattern[1] . ',';
                                                    }
                                                }

                                            } else {
                                                $model .= $this->pattern[0] . $this->baseModel . '.' . $indice1 . '.' . $indice2 . '.' . $indice3 . '.' . $indice4 . $this->pattern[1] . ',';

                                            }
                                        }

                                    } else {
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

    public function getTexts()
    {
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

                                    if(is_object($strings->$indice1->$indice2->$indice3->$indice4)){
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
                                                        $keys6 = array_keys((array) $strings->$indice1->$indice2->$indice3->$indice4->$indice5->$indice6);
                                                        $cnt6 = count($keys6);

                                                        for($ae = 0; $ae < $cnt6;$ae++){
                                                            $indice7 = $keys6[$ae];

                                                            if(is_object($strings->$indice1->$indice2->$indice3->$indice4->$indice5->$indice6->$indice7)){
                                                                $keys7 = array_keys((array) $strings->$indice1->$indice2->$indice3->$indice4->$indice5->$indice6->$indice7);
                                                                $cnt7 = count($keys7);

                                                                for($ai = 0; $ai < $cnt7;$ai++){
                                                                    $indice8 = $keys7[$ai];

                                                                    if(is_object($strings->$indice1->$indice2->$indice3->$indice4->$indice5->$indice6->$indice7->$indice8)){
                                                                        $keys8 = array_keys((array) $strings->$indice1->$indice2->$indice3->$indice4->$indice5->$indice6->$indice7->$indice8);
                                                                        $cnt8 = count($keys8);

                                                                        for($ao = 0; $ao < $cnt8;$ao++){
                                                                            $indice9 = $keys8[$ao];

                                                                            if(is_object($strings->$indice1->$indice2->$indice3->$indice4->$indice5->$indice6->$indice7->$indice8->$indice9)){
                                                                                $keys9 = array_keys((array) $strings->$indice1->$indice2->$indice3->$indice4->$indice5->$indice6->$indice7->$indice8->$indice9);
                                                                                $cnt9 = count($keys9);

                                                                                for ($au = 0; $au < $cnt9; $au++){
                                                                                    $indice10 = $keys9[$au];

                                                                                    if(is_object($strings->$indice1->$indice2->$indice3->$indice4->$indice5->$indice6->$indice7->$indice8->$indice9->$indice10)){

                                                                                    } else {
                                                                                        $texts[] = (string) $strings->$indice1->$indice2->$indice3->$indice4->$indice5->$indice6->$indice7->$indice8->$indice9->$indice10;
                                                                                    }
                                                                                }

                                                                            } else {
                                                                                $texts[] = (string) $strings->$indice1->$indice2->$indice3->$indice4->$indice5->$indice6->$indice7->$indice8->$indice9;
                                                                            }
                                                                        }
                                                                    } else {
                                                                        $texts[] = (string) $strings->$indice1->$indice2->$indice3->$indice4->$indice5->$indice6->$indice7->$indice8;
                                                                    }

                                                                }
                                                            } else {
                                                                $texts[] = (string) $strings->$indice1->$indice2->$indice3->$indice4->$indice5->$indice6->$indice7;
                                                            }
                                                        }
                                                    } else {
                                                        $texts[] = (string) $strings->$indice1->$indice2->$indice3->$indice4->$indice5->$indice6;
                                                    }
                                                }
                                            } else {
                                                $texts[] = (string) $strings->$indice1->$indice2->$indice3->$indice4->$indice5;
                                            }
                                        }

                                    } else {
                                        $texts[] = (string) $strings->$indice1->$indice2->$indice3->$indice4;
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

    public function result(string $html)
    {
        return str_replace($this->models,$this->texts,$html);
    }
}