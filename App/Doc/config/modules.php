<?php

$A['load_modules'] = true;

$A['use_global_modules'] = true;

/**
 * List as models to load
 *
 * For multiple load use array, and personalized the name to access
 *
 * $C['modules_list'] = array('input','configuration' => 'config');
 *
 * Type: Array
 */
$A['modules_list'] = array(
    'app' => array(
        'tjp' => 'tjpermissions',
        'phpmailer' => 'phpmailerhelper'
    ),
);
