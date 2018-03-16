<?php

use SKYCore\Controllers\Controller;

class User extends Controller
{
    public function __construct()
    {
        parent::__construct();

        echo json_encode(array(
            'nome' => 'jorge',
            'email' => 'skay_1994@yahoo.com.br'
        ));
    }

}