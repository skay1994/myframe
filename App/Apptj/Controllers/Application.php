<?php
namespace App\Apptj\Controllers;

use App\Apptj\Core\CustomController;
class Application extends CustomController
{
    protected $view_by_folder = false;

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        loadView('index.php');
    }
}
