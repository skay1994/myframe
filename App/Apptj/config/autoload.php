<?php

/**------------------------------------------------------------------------------------------------
 *
 *                                  Load resources for all apps
 *
 * ------------------------------------------------------------------------------------------------
 */


/**
 * List as models to load
 *
 * For multiple load use array to load varius languages file
 *
 * $C['default_language_files'] = array('input','configuration','config');
 *
 * For single load use a string, not compatible with personalized name to access
 *
 * $C['default_language_files'] = 'input';
 *
 * Can be overridden by app configuration
 *
 * Type: Array
 */
$A['autoload_language'] = array('input','configuration','config');