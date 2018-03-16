<?php
/**------------------------------------------------------------------------------------------------
 *
 *                                       Database
 *
 * ------------------------------------------------------------------------------------------------
 */

/**
 *
 */
$A['db_enabled'] = true;

$A['db_doctrine_proxy'] = false;

$A['db_doctrine_isdev_mod'] = false;

$A['db_doctrine_cache'] = false;

$A['db_doctrine_use_simpleannotation'] = false;

$A['db_doctrine_entity'] = ['\App\Apptj\Models'];

$A['db_connect'] = array(
    'driver'    =>  'pdo_mysql' ,
    'user'      =>  'root' ,
    'password'  =>  '' ,
    'dbname'    =>  'db_contazul'
);