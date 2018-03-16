<?php

foreach (glob(__DIR__.DS.'*.php') as $file){
    if(!strpos($file,'index.php'))
        include $file;
}