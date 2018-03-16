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
$C['enable_cache'] = true;

/**
 * Configure path to saved cache, each cache is separated by application
 *
 * This folder will be created within the application's folder structure
 *
 * Can be overridden by app configuration
 *
 * Default: 'cache';
 * Type: String
 */
$C['cache_path'] = 'cache';

/**
 * The folder name template that will be created to save the cache
 *
 * Can be overridden by app configuration
 *
 * Default: '%application%_cache';
 * Type: String
 */
$C['cache_folder_name'] = '%application%_cache';

/**
 * Sets a time for expiration from cache in milliseconds
 *
 * Can be overridden by app configuration
 *
 * Default: 86400 as 24h
 * Type: Integer
 */
$C['cache_expiration_time'] = 86400;

/**
 * Compress cache output, reducing html, css and inline js for better performace
 *
 * Can be overridden by app configuration
 *
 * Default: TRUE
 * Type: Boolean
 */
$C['compress_cache_output'] = false;