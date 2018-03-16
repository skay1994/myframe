<?php

namespace SKYCore\Modules;

use SKYCore\Controllers\Controller;
/**
 * Class SimpleView
 * @package SKYCore\Modules
 *
 * @version 1.0
 */
class SimpleView extends Controller {
    public $arguments;
    private static $instance;

    private $js,$isJquery,$selections = array(),$buttons = array();

    public function __construct($args)
    {
        parent::__construct();
        $this->arguments = $args;
        self::$instance = &$this;
    }

    function addSelection(string $selection){
        $this->selections[] = $selection;
    }

    function removeSelection(string $selection){

    }

    public function addButton(array $button){
        $this->buttons[] = $button;
    }

    public function addFunction(array $button){
        $this->buttons[] = $button;
    }

    private function createJS(){
        $this->startJSTag();
        $this->simpleViewObjS();

        $function = '';

        foreach ($this->buttons as $button){

            if(isset($button['name']) && !empty($button['name'])){
                $function .= '"'.$button['name'].'": function';
            } else {
                $rand = rand(rand(),rand());

                $function .= 'function SView_'.$rand.'';
            }

            if(isset($button['function']) && !empty($button['function'])){
                $key = array_keys($button['function'])[0];
                $value = array_values($button['function'])[0];

                if(isset($button['function']['arguments'])){
                    $args = '(';
                    $arg = '';
                    for($a = 0; $a < $button['function']['arguments']; $a++){
                        $arg .= '$SVArg_'.rand(rand(),rand()).',';
                    }
                    $arg = substr($arg,0,-1);
                    $args .= $arg.'){';
                    $function .= $args;
                } else
                    $function .= '(){';

                if(isset($button['function']['arguments']) && $key == 'console'){
                    $args = explode(',',$arg);

                    foreach ($args as $arg){
                        $function .= 'console.log('.$arg.')';
                    }
                }

                if($key == 'hide_class'){
                    if($this->isJquery)
                        $function .= '$(\'.'.$value.'\').hide();';
                    else
                        $function .= 'document.getElementsByClassName(\''.$value.'\')[0].style.display = "none"';
                }

                if($key == 'show_class'){
                    if($this->isJquery)
                        $function .= '$(\'.'.$value.'\').show();';
                    else
                        $function .= 'document.getElementsByClassName(\''.$value.'\')[0].style.display = "block"';
                }

                if($key == 'hide_id'){
                    if($this->isJquery)
                        $function .= '$(\'#'.$value.'\').hide();';
                    else
                        $function .= 'document.getElementById(\''.$value.'\')[0].style.display = "none"';
                }

                if($key == 'show_id'){
                    if($this->isJquery)
                        $function .= '$(\'#'.$value.'\').show();';
                    else
                        $function .= 'document.getElementById(\''.$value.'\')[0].style.display = "block"';
                }

                if($key == 'ajax'){
                    if($this->isJquery){

                    } else {

                    }
                }
            } else
                $function .= '(){';

            $function .= '},';
        }

        $function = substr($function,0,-1);

        $this->js .= $function;

        $this->simpleViewObjE();
        $this->endJSTag();
    }

    private function simpleViewObjS(){
        $this->js .= '\'use stric\'; var SimpleView = {';
    }

    private function simpleViewObjE(){
        $this->js .= '}';
    }

    private function isJquery(){
        if(is_bool(getConfigs('use_jquery')) && getConfigs('use_jquery'))
            $this->isJquery =  true;
        else
            $this->isJquery =  false;
    }

    private function startJSTag(){
        $this->js .= '<script type="application/javascript">';
    }

    private function endJSTag(){
        $this->js .= '</script>';
    }

    private function XMLHttpRequest($value){

    }

    private function jQueryAjax($value){

        $function = '$.ajax({';
        if(isset($value['type']) && is_string($value['type']))
            $function .= 'type:\''.$value['type'].'\',';
        else
            $function .= 'type:\'get\',';

        if(isset($value['url']) && is_string($value['url']))
            $function .= 'url:\''.$value['url'].'\',';
        else
            $function .= 'url:\''.$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REDIRECT_URL'].'\',';

        if(isset($value['header']) && is_array($value['header'])){
            $function .= 'headers:{';

            foreach ($value['header'] as $key => $value){
                $function .= "\'$key\' : \'$value\'";
            }

            $function .= '},';
        }

        if(isset($value['dataType']) && is_string($value['dataType']))
            $function .= 'dataType:\''.$value['dataType'].'\',';
        elseif(isset($value['dataType']) && !is_null($value['dataType']))
            $function .='dataType:\'json\',';

        if(isset($value['data'])){
            if(is_array($value['data'])){
                $dataKey = array_keys($value['data']);
                $dataValue = array_values($value['data']);

                if($dataKey == 'json'){
                    $function .= 'data: '.json_encode($dataValue).',';
                }
            } else
                $function .= 'data: \''.$value['data'].'\',';
        }

        if(isset($value['success'])){
            if(is_array($value['success'])){
                $successKey = array_keys($value['success'])[0];
                $successValue = array_values($value['success'])[0];

                if($successKey == 'internal'){
                    if(is_array($successValue)){
                        $functionName = $successValue[0];
                        $arg1 = '';
                        for ($a = 0;$a < $successValue[1];$a++){
                            $arg1 .= '$SVArg_'.rand(rand(),rand()).',';
                        }
                        $arg1 = substr($arg1,0,-1);
                        $function .= 'success: function('.$arg1.'){ SimpleView.'.$functionName.'('.$arg1.');}';
                    } else
                        $function .= 'success: function($sv_success){ SimpleView.'.$successValue.'($sv_success);}';
                }
                elseif ($successKey == 'external')
                    $function .= 'success: function($sv_success){ '.$successValue.'($sv_success);}';
            } else {
                if(is_string($value['success']))
                    $function .= 'success: function($sv_success){ '.$value['success'].'($sv_success);}';
            }
        }

        $function .= '});';

        return $function;
    }

    private function onLoadStart(){
        if((is_bool(getConfigs('use_custom_onloadpage')) && getConfigs('use_custom_onloadpage'))){
            if(is_string(getConfigs('custom_onloadpage_start')))
                $this->js = getConfigs('custom_onloadpage_start');
            else {
                if($this->isJquery)
                    $this->js = '$(document).ready(function(){';
                else
                    $this->js = 'document.addEventListener(\'DOMContentLoaded\',function(){';
            }
        } else{
            if($this->isJquery)
                $this->js = '$(document).ready(function(){';
            else
                $this->js = 'document.addEventListener(\'DOMContentLoaded\',function(){';
        }
    }

    private function onLoadEnd(){
        if((is_bool(getConfigs('use_custom_onloadpage')) && getConfigs('use_custom_onloadpage'))){
            if(is_string(getConfigs('custom_onloadpage_end')))
                $this->js = getConfigs('custom_onloadpage_end');
            else {
                if($this->isJquery)
                    $this->js .= '});';
                else
                    $this->js .= '});';
            }
        } else{
            if($this->isJquery)
                $this->js .= '});';
            else
                $this->js .= '});';
        }
    }

    /**
     * @return mixed
     */
    public function getJS(){
        $this->createJS();
        return $this->js;
    }

    public function loadView(string $view,$data = array())
    {
        $this->createJS();
        $data = array_merge(array('sv_js' => $this->js),$data);
        $this->view->load($view,$data);
    }

    public function setArgs($args)
    {
        $this->arguments = $args;
        return $this;
    }

    public function load($folder,$load){
        if(!is_null(getConfigs('app_folder')))
            $patch = APPPATH.getConfigs('app_folder').DS.$folder.DS;
        else {
            die(trigger_error('Is missing paramter "app_folder" in app configuration file'));
        }


        if(is_array($load)){
            $class = array_keys($load)[0];
            $newName = array_values($load)[0];
            require_once $patch.$class.'.php';

            $this->$newName = new $class();

            return $this;
        }

        if(is_string($load)){
            require_once $patch.$load.'.php';

            $this->$load = new $load();

            return $this;
        }

        return $this;
    }

    public static function &getInstance()
    {
        if(self::$instance === null)
            self::$instance = new self();

        return self::$instance;
    }

}