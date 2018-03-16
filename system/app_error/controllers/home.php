<?php

namespace App\FirstApp\Controllers;

use SKYCore\Controllers\controller;

class Home extends controller {

    public function __construct()
    {
        parent::__construct();

        $this->load('model','Teste','blog');

//        var_dump($this->model->teste);

//        $this->load->modules(['pagseguro' => 'ps']);
//
//        $data = array(
//            'name' => 'test',
//            'function' => array('hide_class' => 'test')
//        );
//
//        $this->addButton($data);
//
//        $data = array(
//            'name' => 'test2',
//            'function' => array(
//                'console' => 'log',
//                'arguments' => 1
//            )
//        );
//        $this->addFunction($data);
//
//        $data = array(
//            'name' => 'getUsers',
//            'function' => array(
//                'ajax' => array(
//                    'success' => array('internal' => array('test2',1))
//                )
//            )
//        );
//        $this->addFunction($data);
//
//        $this->loadView('index');
    }

    public function index(){
        echo 'Hello World!';

//        $this->view->load('index');
    }

    public function casa(){

//        $data = array(
//            'where' => array('name' => 'Andrei Zmievski')
//        );
//
//        $sql = $this->db->get('customer',$data);
//
//        $this->view->load('index');
    }
}