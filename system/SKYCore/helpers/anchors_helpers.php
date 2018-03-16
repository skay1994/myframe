<?php

/**
 * Shortcut for creating new anchors
 * @version 1.0
 */
if(!function_exists('new_anchor')){
    function new_anchor(string $type,string $name,array $args){
        return \SKYCore\Load::getLoadedStatic('Anchor')['object']->new_anchor($type,$name,$args);
    }
}

/**
 * Shortcut for creating new callbacks for existing anchors
 * @version 1.0
 */
if(!function_exists('anchor_new_callback')){
    function anchor_new_callback(string $type,string $name, $callback, int $priority = 10){
        return \SKYCore\Load::getLoadedStatic('Anchor')['object']->add_callback($type,$name,$callback,$priority);
    }
}

/**
 * Shortcut for remove callbacks for existing anchors
 * @version 1.0
 */
if(!function_exists('anchor_remove_callback')){
    function anchor_remove_callback(string $type,string $name,string $callback){
        return \SKYCore\Load::getLoadedStatic('Anchor')['object']->remove_callback($type,$name,$callback);
    }
}
/*************************************************************************************************************/
/*************************************************************************************************************/
/***************************************** System Helpers Functions ******************************************/
/*************************************************************************************************************/
/*************************************************************************************************************/

/**
 * Shortcut for creating new system anchors
 * @version 1.0
 */
if(!function_exists('new_system_anchor')){
    function new_system_anchor(string $name,array $args){
        return \SKYCore\Load::getLoadedStatic('Anchor')['object']->new_anchor('system',$name,$args);
    }
}

/**
 * Shortcut for creating new callbacks for system anchors
 * @version 1.0
 */
if(!function_exists('new_system_callback')){
    function new_system_callback(string $name,$callback, int $priority = 10){
        return \SKYCore\Load::getLoadedStatic('Anchor')['object']->add_callback('system',$name,$callback,$priority);
    }
}

/**
 * Shortcut for remove callbacks for system anchors
 * @version 1.0
 */
if(!function_exists('remove_system_callback')){
    function remove_system_callback(string $name,string $callback){
        return \SKYCore\Load::getLoadedStatic('Anchor')['object']->remove_callback('system',$name,$callback);
    }
}

/*************************************************************************************************************/
/*************************************************************************************************************/
/***************************************** Application Helpers Functions *************************************/
/*************************************************************************************************************/
/*************************************************************************************************************/

/**
 * Shortcut for creating new system anchors
 * @version 1.0
 */
if(!function_exists('new_app_anchor')){
    function new_app_anchor(string $name,array $args){
        return \SKYCore\Load::getLoadedStatic('Anchor')['object']->new_anchor('app',$name,$args);
    }
}

/**
 * Shortcut for creating new callbacks for system anchors
 * @version 1.0
 */
if(!function_exists('new_app_callback')){
    function new_app_callback(string $name, $callback, int $priority = 10){
        return \SKYCore\Load::getLoadedStatic('Anchor')['object']->add_callback('app',$name,$callback,$priority);
    }
}

/**
 * Shortcut for remove callbacks for system anchors
 * @version 1.0
 */
if(!function_exists('remove_app_callback')){
    function remove_app_callback(string $name,string $callback){
        return \SKYCore\Load::getLoadedStatic('Anchor')['object']->remove_callback('app',$name,$callback);
    }
}

/*************************************************************************************************************/
/*************************************************************************************************************/
/***************************************** Modules Helpers Functions *****************************************/
/*************************************************************************************************************/
/*************************************************************************************************************/

/**
 * Shortcut for creating new modules anchors
 * @version 1.0
 */
if(!function_exists('new_modules_anchor')){
    function new_modules_anchor(string $name,array $args){
        return \SKYCore\Load::getLoadedStatic('Anchor')['object']->new_anchor('modules',$name,$args);
    }
}

/**
 * Shortcut for creating new callbacks for modules anchors
 * @version 1.0
 */
if(!function_exists('new_modules_callback')){
    function new_modules_callback(string $name, $callback, int $priority = 10){
        return \SKYCore\Load::getLoadedStatic('Anchor')['object']->add_callback('modules',$name,$callback,$priority);
    }
}

/**
 * Shortcut for remove callbacks for modules anchors
 * @version 1.0
 */
if(!function_exists('remove_modules_callback')){
    function remove_modules_callback(string $name,string $callback){
        return \SKYCore\Load::getLoadedStatic('Anchor')['object']->remove_callback('modules',$name,$callback);
    }
}