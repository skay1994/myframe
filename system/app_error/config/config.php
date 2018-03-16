<?php
/**------------------------------------------------------------------------------------------------
 *
 *                                       Application
 *
 * ------------------------------------------------------------------------------------------------
 */

$A['app_name'] = 'Teste Poorrr';

$A['app_folder'] = 'firstapp';

$A['default_controller'] = 'home';

$A['default_action'] = 'index';

/**------------------------------------------------------------------------------------------------
 *
 *                                       Erros
 *
 * ------------------------------------------------------------------------------------------------
 */

/**
 *
 */
$A['error_404'] = 'error/404';

/**
 * Allows settings to be loaded globally for all apps,
 * if you have duplicate options within the application settings file,
 * the individual app settings will be used
 *
 * Warning: Disabling this option will require
 * that the app configuration file has the basic settings for system operation
 *
 * Default: TRUE
 * Type Boolean
 */
$A['global_config'] = true;

$A['autoload'] = array('bosta');

/**------------------------------------------------------------------------------------------------
 *
 *                                       Composer
 *
 * ------------------------------------------------------------------------------------------------
 */

$A['use_composer'] = true;

$A['composer_path'] = BASEPATH.'vendor'.DS.'autoload.php';