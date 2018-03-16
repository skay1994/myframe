<?php

namespace App\Doc\Controllers;

use SKYCore\Controllers\Controller;

class Application extends Controller
{

    public function index()
    {
        $data = array(
            'header' => array(
                'title' => '{{ locale.pages.applications.about.title }} - {{ locale.menu_lateral.applications.title }} - {{ locale.app_name }}'
            )
        );

        $this->view('index.php',$data);
    }

    public function configuration()
    {
        $data = array(
            'header' => array(
                'title' => '{{ locale.pages.applications.configuration.title }} - {{ locale.menu_lateral.applications.title }} - {{ locale.app_name }}'
            )
        );

        $this->view('config.php',$data);
    }

    public function localization()
    {

    }

    public function model()
    {
        $data = array(
            'header' => array(
                'title' => '{{ locale.pages.applications.model.title }} - {{ locale.menu_lateral.applications.title }} - {{ locale.app_name }}'
            )
        );

        loadView('mvc_controller.php',$data);
    }

    public function views()
    {
        $data = array(
            'header' => array(
                'title' => '{{ locale.pages.applications.view.title }} - {{ locale.menu_lateral.applications.title }} - {{ locale.app_name }}'
            )
        );

        loadView('mvc_controller.php',$data);
    }

    public function mvc_controller()
    {
        $data = array(
            'header' => array(
                'title' => '{{ locale.pages.applications.mvc_controller.title }} - {{ locale.menu_lateral.applications.title }} - {{ locale.app_name }}'
            )
        );

        loadView('mvc_controller.php',$data);
    }
}
