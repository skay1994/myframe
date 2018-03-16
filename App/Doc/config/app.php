<?php

/**------------------------------------------------------------------------------------------------
 *
 *                                       Application
 *
 * ------------------------------------------------------------------------------------------------
 */

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

/**
 *
 */
$A['force_https'] = false;

/**
 *
 */
$A['app_name'] = 'Documentacão';

/**
 *
 */
$A['app_folder'] = 'doc';

/**
 *
 */
$A['default_controller'] = 'Application';

/**
 *
 */
$A['default_action'] = 'index';

/**------------------------------------------------------------------------------------------------
 *
 *                                       Views
 *
 * ------------------------------------------------------------------------------------------------
 */

/**
 *
 */
$A['html_lang'] = 'pt-br';

/**
 *
 */
$A['meta_charset'] = 'utf-8';

/**
 *
 */
$A['view_by_folder'] = true;

/**
 *
 */
$A['use_template'] = true;

/**
 *
 */
$A['view_template'] = array(
    'header' => 'header.php',
    'menu_topo' => 'menu_topo.php',
    'menu_lateral' => 'menu_lateral.php',
    'view' => '',
    'footer' => 'footer.php'
);

/**
 *
 */
$A['view_data'] = array(
    'header' => [
        'title' => '%app-view% - {{ locale.session_data.company_name }}'
    ]
);
/**------------------------------------------------------------------------------------------------
 *
 *                                       Sessions
 *
 * ------------------------------------------------------------------------------------------------
 */

$A['session_enabled'] = true;

$A['session_options'] = array();

$A['default_user_session'] = 'user_logged';

/**------------------------------------------------------------------------------------------------
 *
 *                                       Erros
 *
 * ------------------------------------------------------------------------------------------------
 */

$A['error_404'] = 'error/404';