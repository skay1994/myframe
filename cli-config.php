<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once __DIR__.'/index.php';

$entityManager = \SKYCore\Load::getLoadedStatic('Database')['object']->getDoc();

return ConsoleRunner::createHelperSet($entityManager);