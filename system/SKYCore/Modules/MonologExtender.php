<?php

namespace SKYCore\Modules;

use Monolog\{
    ErrorHandler, Formatter, Logger, Handler
};
/**
 * Class MonologExtender
 * @package SKYCore\Modules
 *
 * @version 1.0
 */
class MonologExtender
{
    public $mono_log = null;
    static $handler = array();

    function __construct(string $app_name)
    {
        $this->mono_log = new Logger($app_name);
    }

    function setHandler(string $name, string $handler,$option1 = null, $option2 = null,$option3 = null,$option4 = null,$option5 = null,$option6 = null){
        $handler = str_replace('Handler','',$handler);
        switch ($handler){
            case 'Stream':

                if(!$option2)
                    $option2 = Logger::DEBUG;
                if (!$option3)
                    $option3 = true;
                if (!$option5)
                    $option5 = false;

                self::$handler[$name] = new Handler\StreamHandler($option1,$option2,$option3,$option4,$option5);
                break;
            case 'RotatingFile':
                if(!$option2)
                    $option2 = 0;
                if(!$option3)
                    $option3 = Logger::DEBUG;
                if (!$option4)
                    $option4 = true;
                if(!$option6)
                    $option6 = false;

                self::$handler[$name] = new Handler\RotatingFileHandler($option1,$option2,$option3,$option4,$option5,$option6);
                break;
            case 'Syslog':
                if(!$option2)
                    $option2 = LOG_USER;
                if(!$option3)
                    $option3 = Logger::DEBUG;
                if(!$option4)
                    $option4 = true;
                if(!$option5)
                    $option5 = LOG_PID;

                self::$handler[$name] = new Handler\SyslogHandler($option1, $option2, $option3, $option4, $option5);
                break;
            case 'ErrorLog':
                if(!$option1)
                    $option1 = Handler\ErrorLogHandler::OPERATING_SYSTEM;
                if(!$option2)
                    $option2 = Logger::DEBUG;
                if(!$option3)
                    $option3 = true;
                if(!$option4)
                    $option4 = false;

                self::$handler[$name] = new Handler\ErrorLogHandler($option1, $option2, $option3, $option4);
                break;
            case 'FirePHP':
                self::$handler[$name] = new Handler\FirePHPHandler();
                break;
            case 'BrowserConsole':
                self::$handler[$name] = new Handler\BrowserConsoleHandler();
                break;
        }

        return $this;
    }

    /**
     * Set handler
     *
     * @param Handler\HandlerInterface $call
     */
    private function pushHandler(Handler\HandlerInterface $call):void
    {
        $this->mono_log->pushHandler($call);
    }

    /**
     * Set processor
     *
     * @param callable $call
     */
    private function pushProcessor(callable $call):void{
        $this->mono_log->pushProcessor($call);
    }

    function formater(string $handler_name,string $formater, $option1 = null,$option2 = null, $option3 = null, $option4 = null){
        $formater = str_replace('Formatter','',$formater);

        switch ($formater) {
            case 'Line':
                if(!is_null($option3) && !is_null($option4))
                    self::$handler[$handler_name]->setFormatter(new Formatter\LineFormatter($option1, $option2, $option3, $option4));
                elseif(is_null($option3) && !is_null($option4))
                    self::$handler[$handler_name]->setFormatter(new Formatter\LineFormatter($option1, $option2, false, $option4));
                elseif (!is_null($option3) && is_null($option4))
                    self::$handler[$handler_name]->setFormatter(new Formatter\LineFormatter($option1, $option2, $option3));
                else
                    self::$handler[$handler_name]->setFormatter(new Formatter\LineFormatter($option1, $option2));

                break;
            case 'HTML':
                self::$handler[$handler_name]->setFormatter(new Formatter\HtmlFormatter($option1));
                break;
            case 'Normalizer':
                self::$handler[$handler_name]->setFormatter(new Formatter\NormalizerFormatter($option1));
                break;
            case 'Json':
                self::$handler[$handler_name]->setFormatter(new Formatter\JsonFormatter((int) $option1,(bool)$option2));
                break;
            case 'Wildfire':
                self::$handler[$handler_name]->setFormatter(new Formatter\WildfireFormatter());
                break;
            case 'ChromePHP':
                self::$handler[$handler_name]->setFormatter(new Formatter\ChromePHPFormatter());
                break;
        }

    }

    public function gerateLogger(){
        if(!empty(self::$handler)){

            foreach (self::$handler as $handler){
                $this->pushHandler($handler);
            }

        }
    }

    /*
     *
     * Log Levels
     *
     *
     */

    /**
     * Log level Debug
     *
     * @param string $message
     * @param array $context
     */
    function log_debug(string $message,array $context = array()):void {
        $this->mono_log->debug($message,$context);
    }

    /**
     * Log level Information
     *
     * @param string $message
     * @param array $context
     */
    function log_info(string $message,array $context = array()):void {
        $this->mono_log->info($message,$context);
    }

    /**
     * Log level notice
     *
     * @param string $message
     * @param array $context
     */
    function log_notice(string $message,array $context = array()):void {
        $this->mono_log->notice($message,$context);
    }

    /**
     * Log level warning
     *
     * @param string $message
     * @param array $context
     */
    function log_warning(string $message,array $context = array()):void {
        $this->mono_log->warning($message,$context);
    }

    /**
     * Log level error
     *
     * @param string $message
     * @param array $context
     */
    function log_error(string $message,array $context = array()):void {
        $this->mono_log->error($message,$context);
    }

    /**
     * Log level critical
     *
     * @param string $message
     * @param array $context
     */
    function log_critical(string $message,array $context = array()):void {
        $this->mono_log->critical($message,$context);
    }

    /**
     * Log level alert
     *
     * @param string $message
     * @param array $context
     */
    function log_alert(string $message,array $context = array()):void {
        $this->mono_log->alert($message,$context);
    }

    /**
     * Log level emergency
     *
     * @param string $message
     * @param array $context
     */
    function log_emergency(string $message,array $context = array()):void {
        $this->mono_log->emergency($message,$context);
    }
}