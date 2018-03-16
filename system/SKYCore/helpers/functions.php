<?php

/**
 * Returns the value of the requested configuration, or an array with all configurations
 *
 * @param string $param
 * @return mixed
 */
function getConfigs( string $param = ''){
    /** @var \SKYCore\Configuration $config */
    $config = \SKYCore\Load::getLoadedStatic('Configuration')['object'];
    if(empty($param)){
        return $config->getConfigs();
    } else {
        return $config->$param;
    }
}

/**
 * @param string $group
 * @param string $file
 * @param string $text
 * @return mixed
 */
function getLangGroup(string $group, string $file = '', string $text = ''){
    $lang = \SKYCore\Load::getLoadedStatic('Language')['object'];
    if(!empty($file) && !empty($file) && !empty($text))
        return $lang->$group($file,$text);
    elseif (!empty($file) && empty($text))
        return $lang->$group($file);
    elseif (empty($file) && empty($text))
        return $lang->$group();
}

/**
 * Return the current app
 * @return string
 */
function getCurrentApp():string{
    return \SKYCore\Load::getLoadedStatic('Routing')['object']->application;
}

/**
 * Log Functions
 */
function sLog_info(string $message, array $context = []){
    /** @var Monolog\Logger $log */
//    $log = \SKYCore\Load::getLoadedStatic('LogSystem')['object']->getLog();
//    $log->info($message,$context);
}

function sLog_warning(string $message, array $context = []){
    /** @var Monolog\Logger $log */
//    $log = \SKYCore\Load::getLoadedStatic('LogSystem')['object']->getLog();
//    $log->warning($message,$context);
}

function sLog_alert(string $message, array $context = []){
    /** @var Monolog\Logger $log */
//    $log = \SKYCore\Load::getLoadedStatic('LogSystem')['object']->getLog();
//    $log->alert($message,$context);
}

function sLog_critical(string $message, array $context = []){
    /** @var Monolog\Logger $log */
//    $log = \SKYCore\Load::getLoadedStatic('LogSystem')['object']->getLog();
//    $log->critical($message,$context);
}

/**
 * Mount the path to load files
 *
 * @param string $app
 * @param string $folder
 * @return string
 */
function file_dir(string $app = 'system',string $folder = 'view'):string {
    $dir = '';

    if(!empty($app)){
        $dir = APPPATH.$app.DS.$folder.DS;
    } elseif (empty($app )) {
        $dir = APPPATH.getCurrentApp().DS.$folder.DS;
    }

    if($app === 'system'){
        $dir = SYSPATH.$folder.DS;
    }

    return $dir;
}

/**
 * @param string $type
 * @param array $data
 *
 * @version 1.0
 */
function error_page(string $type,array $data = array()){

    if(is_bool(getConfigs('custom_error_template')) && getConfigs('custom_error_template')){
        $template = file_dir('',getConfigs('error_template_path') ?? 'error');
    } else {
        $template = file_dir('system','template\error');
    }

    if(empty($data))
        $data = [
            'error_data' => [
                'title' => 'Erro Page'
            ]
        ];

    extract($data);

    if(file_exists($template.$type.DS.'index.php')){
        include_once $template.$type.DS.'index.php';
    } else {
        $template = file_dir('system','template\error');
        include_once $template.$type.DS.'index.php';
    }

    die();
}

/**
 * @param string $class
 * @return bool
 *
 * @version 1.0
 */
function getLoadedInstance(string $class){
    $load = \SKYCore\Load::getLoadedStatic($class);

    if(isset($load['object'])){
        return $load['object'];
    } else {
        return false;
    }
}

/**
 * @package Codeigniter
 *
 * Check access via terminal
 * @return bool
 */
function is_cli():bool {
    return (PHP_SAPI === 'cli' OR defined('STDIN'));
}