<?php

namespace App\Apptj\Controllers;

use SKYCore\Controllers\Controller;
class Login extends Controller
{

    function __construct()
    {
        parent::__construct();

        if($this->session->user_logged){
            header('Location: '.$this->router->getBaseUri());
        }

        $this->config->view_template = array(
            'header' => 'login/header.php',
            'view' => '',
            'footer' => 'login/footer.php'
        );

        $data = [
            'redirect' => isset($_GET['redirect_uri']),

        ];

        if(isset($_GET['redirect_uri'])){
            $data['redirect_url'] = $_GET['redirect_uri'];
        }

        loadView('index.php',$data);
    }

    public function logout()
    {
        $this->session->sessionDestroy();
        header('Location: '.$this->router->getBaseUri());
    }
}