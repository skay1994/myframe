<?php

require_once __DIR__.'/../index.php';


use Symfony\Component\Console\Application;

use SKYCore\Console\{
    createApplicationCommand,
    listApplicationsCommand,
    configurationCommand
};

$console = new Application('SKY_CLI','1.0');
$console->add(new createApplicationCommand());
$console->add(new listApplicationsCommand());
$console->add(new configurationCommand());
$console->run();