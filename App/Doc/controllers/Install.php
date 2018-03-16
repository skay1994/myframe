<?php

namespace App\Doc\Controllers;

use SKYCore\Controllers\Controller;

class Install extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function download(){
        $data = array(
            'header' => array(
                'title' => '{{ locale.pages.download.title }} - {{ locale.menu_lateral.install.title }} - {{ locale.app_name }}'
            )
        );

        loadView('download.php',$data);
    }

    public function informations(){
        loadView('download',[],false);
    }
}