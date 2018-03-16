<?php

namespace App\Apptj\Controllers;

use App\Apptj\Core\CustomController;
use SKYCore\Modules\languageReplacer;
/**
 * Class Posts
 * @package App\Apptj\Controllers
 */
class Posts extends CustomController
{
    
    public function __construct()
    {
        parent::__construct();
        new_system_callback('application_langreplace',[$this,'load_strings']);
    }

    public function index()
    {
        $data = [
            'header' => [
                'title' => 'Todas as Postagens - {{ locale.session_data.company_name }}'
            ]
        ];

        loadView('index.php',$data);
    }

    public function new()
    {
        $data = [
            'header' => [
                'title' => 'Novo Post - {{ locale.session_data.company_name }}'
            ]
        ];

        loadView('new.php',$data);
    }

    public function categories_tags()
    {
        $data = [
            'header' => [
                'title' => 'Categorias e Tags - {{ locale.session_data.company_name }}'
            ]
        ];

        loadView('categoriestags.php',$data);
    }

    public function trash()
    {
        $data = [
            'header' => [
                'title' => 'Lixeira - {{ locale.session_data.company_name }}'
            ]
        ];

        loadView('trash.php',$data);
    }

    public function galery()
    {
        $data = [
            'header' => [
                'title' => 'Galeria - {{ locale.session_data.company_name }}'
            ]
        ];

        loadView('galery.php',$data);
    }


    public function load_strings(languageReplacer $lr)
    {
        $customLR = languageReplacer::langReplaceByControllerWF();
        $lr->models = array_merge($customLR->models,$lr->models);
        $lr->texts = array_merge($customLR->texts,$lr->texts);

        return $lr;
    }
}