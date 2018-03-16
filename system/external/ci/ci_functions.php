<?php
/**
 * Functions by CodeIgniter 3.1.2
 */

/**
 * Set HTTP Status Header
 *
 * @param	int	the status code
 * @param	string
 * @return	void
 */
function set_status_header($code = 200, $text = '')
{
    if (is_cli())
    {
        return;
    }

    if (empty($code) OR ! is_numeric($code))
    {
        show_error('Status codes must be numeric', 500);
    }

    if (empty($text))
    {
        is_int($code) OR $code = (int) $code;
        $stati = array(
            100	=> 'Continue',
            101	=> 'Switching Protocols',

            200	=> 'OK',
            201	=> 'Created',
            202	=> 'Accepted',
            203	=> 'Non-Authoritative Information',
            204	=> 'No Content',
            205	=> 'Reset Content',
            206	=> 'Partial Content',

            300	=> 'Multiple Choices',
            301	=> 'Moved Permanently',
            302	=> 'Found',
            303	=> 'See Other',
            304	=> 'Not Modified',
            305	=> 'Use Proxy',
            307	=> 'Temporary Redirect',

            400	=> 'Bad Request',
            401	=> 'Unauthorized',
            402	=> 'Payment Required',
            403	=> 'Forbidden',
            404	=> 'Not Found',
            405	=> 'Method Not Allowed',
            406	=> 'Not Acceptable',
            407	=> 'Proxy Authentication Required',
            408	=> 'Request Timeout',
            409	=> 'Conflict',
            410	=> 'Gone',
            411	=> 'Length Required',
            412	=> 'Precondition Failed',
            413	=> 'Request Entity Too Large',
            414	=> 'Request-URI Too Long',
            415	=> 'Unsupported Media Type',
            416	=> 'Requested Range Not Satisfiable',
            417	=> 'Expectation Failed',
            422	=> 'Unprocessable Entity',
            426	=> 'Upgrade Required',
            428	=> 'Precondition Required',
            429	=> 'Too Many Requests',
            431	=> 'Request Header Fields Too Large',

            500	=> 'Internal Server Error',
            501	=> 'Not Implemented',
            502	=> 'Bad Gateway',
            503	=> 'Service Unavailable',
            504	=> 'Gateway Timeout',
            505	=> 'HTTP Version Not Supported',
            511	=> 'Network Authentication Required',
        );

        if (isset($stati[$code]))
        {
            $text = $stati[$code];
        }
        else
        {
            show_error('No status text available. Please check your status code number or supply your own message text.', 500);
        }
    }

    if (strpos(PHP_SAPI, 'cgi') === 0)
    {
        header('Status: '.$code.' '.$text, TRUE);
    }
    else
    {
        $server_protocol = isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.1';
        header($server_protocol.' '.$code.' '.$text, TRUE, $code);
    }
}

/**
 * Class registry
 *
 * This function acts as a singleton. If the requested class does not
 * exist it is instantiated and set to a static variable. If it has
 * previously been instantiated the variable is returned.
 *
 * @param	string	the class name being requested
 * @param	string	the directory where the class should be found
 * @param	string	an optional argument to pass to the class constructor
 * @return	object
 */
function &load_class($class, $directory = 'libraries', $param = NULL)
{
    static $_classes = array();

    // Does the class exist? If so, we're done...
    if (isset($_classes[$class]))
    {
        return $_classes[$class];
    }

    $name = FALSE;

    // Look for the class first in the local application/libraries folder
    // then in the native system/libraries folder
    foreach (array(APPPATH, BASEPATH) as $path)
    {
        if (file_exists($path.$directory.'/'.$class.'.php'))
        {
            $name = 'CI_'.$class;

            if (class_exists($name, FALSE) === FALSE)
            {
                require_once($path.$directory.'/'.$class.'.php');
            }

            break;
        }
    }

    // Is the request a class extension? If so we load it too
    if (file_exists(APPPATH.$directory.'/'.config_item('subclass_prefix').$class.'.php'))
    {
        $name = getConfig('subclass_prefix').$class;

        if (class_exists($name, FALSE) === FALSE)
        {
            require_once(APPPATH.$directory.'/'.$name.'.php');
        }
    }

    // Did we find the class?
    if ($name === FALSE)
    {
        // Note: We use exit() rather than show_error() in order to avoid a
        // self-referencing loop with the Exceptions class
        set_status_header(503);
        echo 'Unable to locate the specified class: '.$class.'.php';
        exit(5); // EXIT_UNK_CLASS
    }

    $_classes[$class] = isset($param)
        ? new $name($param)
        : new $name();
    return $_classes[$class];
}

/**
 * Check for access encrypted
 *
 * @return bool
 */
function is_https():bool {
    if ( ! empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off')
    {
        return TRUE;
    }
    elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https')
    {
        return TRUE;
    }
    elseif ( ! empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off')
    {
        return TRUE;
    }

    return FALSE;
}



/**
 * Error Handler
 *
 * This is the custom error handler that is declared at the (relative)
 * top of CodeIgniter.php. The main reason we use this is to permit
 * PHP errors to be logged in our own log files since the user may
 * not have access to server logs. Since this function effectively
 * intercepts PHP errors, however, we also need to display errors
 * based on the current error_reporting level.
 * We do that with the use of a PHP error template.
 *
 * @param	int	$severity
 * @param	string	$message
 * @param	string	$filepath
 * @param	int	$line
 * @return	void
 */
function _error_handler($severity, $message, $filepath, $line)
{
    $is_error = (((E_ERROR | E_PARSE | E_COMPILE_ERROR | E_CORE_ERROR | E_USER_ERROR) & $severity) === $severity);

    // When an error occurred, set the status header to '500 Internal Server Error'
    // to indicate to the client something went wrong.
    // This can't be done within the $_error->show_php_error method because
    // it is only called when the display_errors flag is set (which isn't usually
    // the case in a production environment) or when errors are ignored because
    // they are above the error_reporting threshold.
    if ($is_error)
    {
        set_status_header(500);
    }

    // Should we ignore the error? We'll get the current error_reporting
    // level and add its bits with the severity bits to find out.
    if (($severity & error_reporting()) !== $severity)
    {
        return;
    }

    $_error =& load_class('Exceptions', 'core');
    $_error->log_exception($severity, $message, $filepath, $line);

    // Should we display the error?
    if (str_ireplace(array('off', 'none', 'no', 'false', 'null'), '', ini_get('display_errors')))
    {
        $_error->show_php_error($severity, $message, $filepath, $line);
    }

    // If the error is fatal, the execution of the script should be stopped because
    // errors can't be recovered from. Halting the script conforms with PHP's
    // default error handling. See http://www.php.net/manual/en/errorfunc.constants.php
    if ($is_error)
    {
        exit(1); // EXIT_ERROR
    }
}

/**
 * Exception Handler
 *
 * Sends uncaught exceptions to the logger and displays them
 * only if display_errors is On so that they don't show up in
 * production environments.
 *
 * @param	Exception	$exception
 * @return	void
 */
function _exception_handler($exception)
{
    $_error = &load_class('Exceptions', 'core');
    $_error->log_exception('error', 'Exception: '.$exception->getMessage(), $exception->getFile(), $exception->getLine());

    is_cli() OR set_status_header(500);
    // Should we display the error?
    if (str_ireplace(array('off', 'none', 'no', 'false', 'null'), '', ini_get('display_errors')))
    {
        $_error->show_exception($exception);
    }

    exit(1); // EXIT_ERROR
}

/**
 * Shutdown Handler
 *
 * This is the shutdown handler that is declared at the top
 * of CodeIgniter.php. The main reason we use this is to simulate
 * a complete custom exception handler.
 *
 * E_STRICT is purposively neglected because such events may have
 * been caught. Duplication or none? None is preferred for now.
 *
 * @link	http://insomanic.me.uk/post/229851073/php-trick-catching-fatal-errors-e-error-with-a
 * @return	void
 */
function _shutdown_handler()
{
    $last_error = error_get_last();
    if (isset($last_error) &&
        ($last_error['type'] & (E_ERROR | E_PARSE | E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_COMPILE_WARNING)))
    {
        _error_handler($last_error['type'], $last_error['message'], $last_error['file'], $last_error['line']);
    }
}