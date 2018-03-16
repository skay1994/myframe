<?php

namespace SKYCore;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
/**
 * Class LogSystem
 * @package SKYCore
 */
class LogSystem
{
    private $monolog;

    private function __construct()
    {
        $log = new Logger('sys_log');

        $handler = new StreamHandler(SYSPATH.'log/logger.log',Logger::WARNING);

        $dateFormat = "Y n j, g:i a";
        $output = "%datetime% > %level_name% > %message% %context% %extra%\n";

        $handler->setFormatter(new LineFormatter($output,$dateFormat));

        $log->pushHandler($handler);

        $this->monolog = $log;
    }

    public static function getInstance()
    {
        static $instance = null;

        if($instance === null){
            $instance = new self();
        }

        return $instance;

    }

    public function getLog(){
        return $this->monolog;
    }

}