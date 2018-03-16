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
$A['default_language'] = 'pt-br';

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
$A['language_file_type'] = 'json';

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
$A['language_return_type'] = 'object';

$A['language_files'] = array(
    'pt-br'
);

/**
 * Using the language substitution system,
 * it is possible that the one character pattern is replaced by the related text automatically
 *
 * Type: boolean
 * Default: false
 */
$A['language_replacer'] = true;

$A['language_replacer_global_settings'] = array(
    'base_text' => 'strings',
    'base_model' => 'locale',
    'by_file' => [
        'file_type' => 'json',
        'pattern' => array('{{ ',' }}'),
        'file' => 'pt-br/general.json'
    ]
);