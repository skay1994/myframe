<?php

namespace App\Apptj\Controllers;

use App\Apptj\Core\CustomController;

class Users extends CustomController
{
    protected $view_by_folder = true;

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        loadView('index.php');
    }
}