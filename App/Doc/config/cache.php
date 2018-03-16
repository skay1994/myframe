<?php

/**------------------------------------------------------------------------------------------------
 *
 *                                         System Cache
 *
 * ------------------------------------------------------------------------------------------------
 */
/**
 * Enable system cache for all pages on application
 *
 * Can be overridden by app configuration
 *
 * Default: TRUE
 * Type: Boolean
 */
$A['enable_cache'] = true;

/**
 * Configure path to saved cache, each cache is separated by application
 *
 * Can be overridden by app configuration
 *
 * Default: 'cache';
 * Type: String
 */
$A['cache_path'] = 'cache';

/**
 * Sets a time for expiration from cache in milliseconds
 *
 * Can be overridden by app configuration
 *
 * Default: 86400 as 24h
 * Type: Integer
 */
$A['cache_expiration_time'] = 86400;

/**
 * Format used to create a cache key.
 * There are key words that can be used to enter application information.
 * if this value is empty as used the default value
 *
 * See the list below:
 *
 * %host% = provide the server host: example exemple.com
 * %httpscheme% = provide http request scheme: example http or https
 * %app_type% = privede a application type: example  "MVC Application"
 * %application% = providee a application folder name
 * %controller% = provide a controler name by request
 * %action% = provide a action name by request
 *
 * Default: '%application%.%controller%[%action%]'
 * Type: String
 */
$A['cache_key_format'] = '%application%.%controller%[%action%]';