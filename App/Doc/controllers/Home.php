<?php

namespace App\Doc\Controllers;

use SKYCore\Controllers\Controller;

class Home extends Controller {

    static protected $disabled_cache = true;

    public function __construct()
    {
        parent::__construct();
    }

}