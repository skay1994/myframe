<?php

ob_start(null,0,PHP_OUTPUT_HANDLER_REMOVABLE);

use Symfony\Component\HttpFoundation\Request;
use SKYCore\Load;
/**
 * Start system
 */

require_once __DIR__.'/SKYCore/helpers/functions.php';
require_once __DIR__.'/SKYCore/helpers/view.php';
require_once __DIR__.'/SKYCore/helpers/anchors_helpers.php';

/**
 * Whoops
 */
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

/**
 * Initiating loading of classes
 */
$loader = Load::getInstance();

/**
 * Configuration Class
 *
 * @var \SKYCore\configuration $config
 */
$config = $loader->load(['Configuration','config'],'core');

if($config->custom_anchor_core_class){
    if($customAnchor instanceof SKYCore\Interfaces\AnchorCore){

    } else {
        /**
         * Anchor Class Start
         * @var \SKYCore\anchor $anchor
         */
        $anchor = $loader->load('Anchor','core');
    }
} else {
    /**
     * Anchor Class Start
     * @var \SKYCore\anchor $anchor
     */
    $anchor = $loader->load('Anchor','core');
}

$anchor = $anchor->new_anchor('system','anchor_system_start',[$anchor]);

/**
 * Initiating request class;
 * @var Request $request
 */
$request = Request::createFromGlobals();
$loader->addLoadedInstance('Request',['object' => $request]);
$request = $anchor->new_anchor('system','request_system_start',[$request]);

/**
 * Logger class
 */
//$loader->load('LogSystem','core');
//$lang = $anchor->new_anchor('system','log_system_start',[$lang]);

/**
 * Language class
 */
/** @var \SKYCore\language $lang */
$lang = $loader->load(['Language','lang'],'core');
$lang = $anchor->new_anchor('system','lang_system_start',[$lang]);

$lang->loadSysLanguage();


/**
 * Routing Class
 *
 * @var \SKYCore\routing $router
 */
$router = $loader->load(['Routing','router'], 'core');
$router = $anchor->new_anchor('system','router_system_start',[$router]);

/**
 * Loading settings for the current application
 */
$app_config = $config->load($router->application);
$app_config = $anchor->new_anchor('system','system_application_load_config',[$app_config]);

$isModules = false;
if($config->load_modules){

    /**
     * Modules System
     * @var \SKYCore\modules $modules
     */
    $modules = $loader->load('Modules','core');
    $modules = $anchor->new_anchor('system','system_modules_started',[$modules]);
    $loader = $anchor->new_anchor('modules','modules_system_started',[$loader]);

    $modules->load();

    $isModules = true;
}

/**
 * Load database class
 */
if(is_bool(getConfigs('db_enabled')) && getConfigs('db_enabled')){

    /**
     * Loading database class
     */
    $database = $loader->load(['Database','db'],'core');
    $database = $anchor->new_anchor('system','database_system_start',[$database]);

    if($isModules){
        $database = $anchor->new_anchor('modules','database_system_start',[$database]);
    }
}

if(is_cli()){

    $lang->setTypeFile('json');;

    $files = new \FilesystemIterator(SYSPATH.'bin'.DS.'language'.DS.$lang->getLanguage().DS,\FilesystemIterator::SKIP_DOTS);

    foreach ($files as $file){
        $lang->load(substr($file->getFileName(),0,-5),'cli','cli');
    }

    return true;
}

//var_dump($config->force_https);
//die;
/**
 * Checking Status for HTTPS Secure
 */
if($config->force_https){
    if($request->getScheme() !== 'https'){
        header('Location: '.$router->getBaseUri().$request->server->get('REQUEST_URI'));
    }
}

/**
 * Cache class
 * @var \SKYCore\cache
 */
$loader->load('Cache','core');

if($isModules){
    load::$loaded['Cache']['object'] = $anchor->new_anchor('modules','cache_system_start',[load::$loaded['Cache']['object']]);
}

/**
 * @var \SKYCore\session $session;
 */
$loader->load('Session','core');

if($isModules){
    load::$loaded['Session']['object'] = $anchor->new_anchor('modules','session_system_start',[load::$loaded['Session']['object']]);
}

/**
 * Output system
 * @var \SKYCore\output $output
 */
$output = $loader->load('Output','core');

/**
 * Load all defines
 */
require_once 'defines.php';

$router->router();

if($router->type == 'RESTFull Application'){
    return true;
}

if($isModules){
    $output = $anchor->new_anchor('modules','output_system_start',[$output]);

    $anchor->new_anchor('modules','system_all_loaded',[$loader]);
}

$output->output();