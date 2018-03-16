<?php

define('DS',DIRECTORY_SEPARATOR);
define('BASEPATH',__DIR__.DS);
define('SYSPATH',BASEPATH.'system'.DS);
define('APPPATH',BASEPATH.'App'.DS);
error_reporting (E_ALL);

if(!file_exists(__DIR__.'/vendor/autoload.php'))
    throw new Exception('Execute command composer install');

require_once __DIR__.'/vendor/autoload.php';

if(version_compare(PHP_VERSION,'7.1','=>'))
    throw new Exception('You must be using version 7.1 or higher');

require_once __DIR__.'/system/init.php';

//$logger = new \SKYCore\Modules\MonologExtender('teste1');
//$logger->setHandler('log_path','StreamHandler',APPPATH.'log'.DS.'log_test.log',\Monolog\Logger::INFO);
//$logger->setHandler('customize_log','FirePHP');
//$logger->formater('log_path','Wildfire',date('d/m/y H:i:s'));
//$logger->gerateLogger();
//
//$logger->log_info('teste com formato');
//
//$handler = $logger::$handler['log_path'];
//$handler->setFormatter(new \Monolog\Formatter\LineFormatter('%datetime% > %level_name% > %message% %context% %extra%'.PHP_EOL,date('d/m/y H:i:s')));



//var_dump($logger->mono_log->handlers);

//$handler = new \Monolog\Handler\StreamHandler(APPPATH.'log'.DS.'log_test.log',\Monolog\Logger::INFO);
//var_dump($handler->setFormatter(new \Monolog\Formatter\LineFormatter('%datetime% > %level_name% > %message% %context% %extra%'.PHP_EOL,date('d/m/y H:i:s'))));