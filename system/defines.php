<?php
define('CURRENT_APP',getCurrentApp());

/**
 * Defaults paths for modules folders
 */
define('MODULE_PATH',[
    APPPATH.'modules'.DS,
    APPPATH.CURRENT_APP.DS.'modules'.DS,
    SYSPATH.'SKYCore'.DS.'modules'.DS
]);

/**
 * Defaults paths for library folders
 */
define('LIBRARY_PATH',[
    APPPATH.'library'.DS,
    APPPATH.CURRENT_APP.DS.'library'.DS,
    SYSPATH.'SKYCore'.DS.'library'.DS
]);

/**
 * Defaults paths for models folders
 */
define('MODEL_PATH',[
    APPPATH.'model'.DS,
    APPPATH.CURRENT_APP.DS.'model'.DS
]);

/**
 * Defaults paths for models folders
 */
define('LANG_PATH',[
    APPPATH.'global'.DS.'language'.DS,
    APPPATH.CURRENT_APP.DS.'language'.DS,
    SYSPATH.'language'.DS
]);