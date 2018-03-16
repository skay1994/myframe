<?php

/**------------------------------------------------------------------------------------------------
 *
 *                                          Applications
 *
 * ------------------------------------------------------------------------------------------------
 */

/**
 * The option define the folder name to application is loaded
 *
 * For single application define the name with a simple string
 * Exp: $C['apps'] = 'firstapp';
 *
 * For multiples application define as array
 * Exp: $C['apps'] = array('firstapp','secundapp');
 *
 * OBS: to use multiple apps is necessary define the value ** multiapp ** to TRUE
 *
 * Can not be changed by app settings
 *
 * Type: String/Array
 */
$C['apps'] = ['apptj','doc'];

/**
 * Allows the use of multiple apps using the same system base
 *
 * Required to use Multiple Applications
 *
 * Can not be changed by app settings
 *
 * Default: TRUE
 * Type Boolean
 */
$C['multiapps'] = true;

/**
 * Define the application default for multiple apps
 *
 * Can not be changed by app settings
 */
$C['default_app'] = 'doc';