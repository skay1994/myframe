<?php

namespace app\doc\controllers;


use SKYCore\Controllers\RestController;

class Rest extends RestController
{
    function __construct()
    {
        parent::__construct();
    }

    public function produto(){
        $this->send(404,'teste de envio');
    }

}