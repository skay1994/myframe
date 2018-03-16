<?php
/**------------------------------------------------------------------------------------------------
 *
 *                                       Languages
 *
 * ------------------------------------------------------------------------------------------------
 */

/**
 * Set language loaded by default system, system use this option with folder name to load the files
 *
 * Can not be changed by app settings
 *
 * Default:
 * Type: string
 */
$C['default_language'] = 'pt-br';

/**
 * Set type for language file.
 *
 * Json Format: using json format
 *
 * Can be overridden by app configuration
 *
 * Default: json
 * Type: string
 */
$C['language_file_type'] = 'json';

/**
 * If using to define the type of result
 *
 * Object: Allows access to strings as object
 * Ex: $this->language->text->title
 *
 * Array: Allows access to strings as indexes of array
 * Ex: $this->language->text['title']
 *
 * Default: 'object'
 * Type: String
 */
$C['language_return_type'] = 'object';

/**
 * Using the language substitution system,
 * it is possible that the one character pattern is replaced by the related text automatically
 *
 * Type: boolean
 * Default: false
 */
$C['language_replace'] = false;

$C['language_replace_pattern'] = array('([','])');


/**------------------------------------------------------------------------------------------------
 *
 *                                         Templates
 *
 * ------------------------------------------------------------------------------------------------
 */
/**
 * Enable to use template in your application
 *
 * Can be overridden by app configuration
 *
 * Default: TRUE
 * Type: Boolean
 */
$C['use_template'] = true;
