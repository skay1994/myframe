<?php

namespace SKYCore\Controllers;

use SKYCore\Configuration;
use SKYCore\Load;
use SKYCore\Traits\Helpers\Configurations;
use Symfony\Component\HttpFoundation\Response;
/**
 * Class RestController
 * @package SKYCore\Controllers
 */
class RestController
{
    use Configurations;

    /**
     * @var Response
     */
    public $response;

    function __construct()
    {
        foreach (Load::getLoadedStatic() as $class){
            $name = strtolower($class['name']);
            $this->$name = $class['object'];
        }

        $this->response = new Response();

        $origin = $this->request->headers->get('origin');

        $is_valid_origin = false;

        if(!empty($this->getConfigs('Access-Control-Allow-Origin'))){
            $servers = $this->getConfigs('Access-Control-Allow-Origin');
            if(is_string($servers)){
                if($servers === '*'){
                    header('Access-Control-Allow-Origin: '.$this->getConfigs('Access-Control-Allow-Origin'));
                } else {
                    if($origin === $this->getConfigs('Access-Control-Allow-Origin')){
                        $is_valid_origin = true;
                    }

                    header('Access-Control-Allow-Origin: '.$this->getConfigs('Access-Control-Allow-Origin'));
                }
            } elseif (is_array($servers)){
                $list_server = '';

                foreach ($servers as $server){
                    $list_server = $servers.',';

                    if($server === $origin){
                        $is_valid_origin = true;
                    }
                }
                $list_server = strpos($list_server,0,-1);
                header('Access-Control-Allow-Origin: '.$list_server);
            }
        }

        if(!$this->disable_auth())
        {
            if(is_bool(getConfigs('rest_authentication')) && getConfigs('rest_authentication')){
                $this->checkAuthen($is_valid_origin);
            }
        }

        if(!$is_valid_origin){
            if(is_bool($this->getConfigs('only_XMLHttpRequest')) && $this->getConfigs('only_XMLHttpRequest')){
                if($this->request->server->get('HTTP_X_REQUESTED_WITH') !== 'XMLHttpRequest'){
                    $this->error_auth(true,Response::HTTP_NOT_ACCEPTABLE,['status' => false, 'http-code' => '406 NOT ACCEPTABLE','error' => 'the access only this XMLHttpRequest']);
                }
            }
        }
    }

    private function newResponse(){
        $this->response = new Response();
    }

    /**
     * @param string $type
     * @return array|object
     *
     * @version 1.0
     */
    public function post_content(string $type = 'object', string $entity = 'stdclass')
    {
        $post = $this->request->request->all();

        if($entity !== 'stdclass'){
            $post = (object)$post;
//            $entity = new $entity;

//            if(property_exists($entity,$))
        } else {
            if($type === 'object'){
                return (object) $post;
            } elseif($type === 'array') {
                return $post;
            }
        }
    }

    /**
     * @param string $type
     * @return array|object
     *
     * @version 1.0
     */
    public function get_content(string $type = 'object')
    {
        if($type === 'object'){
            return (object) $this->request->query->all();
        } elseif($type === 'array') {
            return $this->request->query->all();
        }
    }

    /**
     * @param string $type
     * @return array|object
     *
     * @version 1.0
     */
    public function file_content(string $type = 'object')
    {
        if($type === 'object'){
            return (object) $this->request->files->all();
        } elseif($type === 'array') {
            return $this->request->files->all();
        }
    }

    /**
     * @param string $type
     *
     * @version 1.0
     */
    public function type(string $type = 'GET')
    {
        if($this->request->server->get('REQUEST_METHOD') !== strtoupper($type)){
            $this->error_method($type);
        }
    }

    /**
     * Default Method
     */
    public function index(){}

    /**
     * @param int $status
     * @param string $content
     * @param string $content_type
     *
     * @version 1.0
     */
    public function send(int $status = Response::HTTP_OK, string $content = '', string $content_type = '')
    {
        if(is_null($this->response)){
            $this->newResponse();
        }

        $this->response->setContent($content);
        $this->response->setStatusCode($status);

        if(!empty($content_type)){
            $this->response->headers->set('Content-Type', $content_type);
        }

        $this->response->prepare($this->request);
        $this->response->send();

        die();
    }

    /**
     * @param int $status
     * @param array $content
     * @param bool $manual_json
     *
     * @version 1.0
     */
    public function sendWithJson(int $status = Response::HTTP_OK, $content = [], bool $manual_json = false)
    {
        if(is_null($this->response)){
            $this->newResponse();
        }

        if(!$manual_json){
            $this->response->setContent(json_encode($content));
        } else {
            $this->response->setContent($content);
        }

        $this->response->setStatusCode($status);

        $this->response->headers->set('Content-Type', 'text/json');

        $this->response->prepare($this->request);
        $this->response->send();

        die();
    }

    /**
     * @param bool $is_valid_origin
     *
     * @version 1.0
     */
    private function checkAuthen(bool $is_valid_origin){
        $auth = getConfigs('authentication_method');

        if(!is_array($auth))
            return;

        foreach ($auth as $method => $value){
            switch ($method){
                case 'session':
                    $this->session($value,$is_valid_origin);
                    break;
                case 'basic':
                    $this->basicAuth($value,$is_valid_origin);
                    break;
                case 'header':
                    $header_name = array_keys($value)[0];
                    header('Access-Control-Allow-Headers: '.$header_name);
                    $this->headerAuth($header_name,$value,$is_valid_origin);
                    break;
            }
        }
    }

    /**
     * @param string $header_name
     * @param array $token
     * @param bool $is_valid_origin
     *
     * @version 1.0
     */
    public function headerAuth(string $header_name, array $token,bool $is_valid_origin)
    {
        if($is_valid_origin && $this->request->server->get('REQUEST_METHOD') === 'OPTIONS'){
            die();
        }

        $header_request = $this->request->server->get('HTTP_'.str_replace('-','_',strtoupper($header_name)));

        if($header_request !== $token[$header_name]){
            $this->error_auth(true,Response::HTTP_UNAUTHORIZED,['status' => false, 'http-code' => '401 UNAUTHORIZED','error' => 'not authorization header received']);
        }
    }

    /**
     * @param $value
     * @param bool $is_valid_origin
     */
    private function session($value,bool $is_valid_origin)
    {
        if(!$is_valid_origin){
            if($this->router->is_internal_rest){
                if(!$this->session->user_valid()){
                    $this->error_auth(true,Response::HTTP_UNAUTHORIZED,['status' => false, 'http-code' => '401 UNAUTHORIZED','error' => 'not authorization session received']);
                }
            } else {
                $app = getConfigs('rest_app_client') ?? '';

                if(!empty($app)){

                    if(in_array($app,getConfigs('apps'))){
                        $config = configuration::load_config_not_merge($app);
                    }

                }
            }
        }
    }

    /**
     * @param string $basic_key
     * @param bool $is_valid_origin
     *
     * @version 1.0
     */
    private function basicAuth(string $basic_key, bool $is_valid_origin){
        $basic = $this->request->server->get('HTTP_WWW_AUTHORIZATION');

        $basic_key = base64_encode($basic_key['username'].':'.$basic_key['password']);

        if($basic){
            $basic = str_replace('Basic ','',$basic);

            if ($basic != $basic_key){
                $this->error_auth();
            }
        } else {
            $this->error_auth(true,Response::HTTP_UNAUTHORIZED,['status' => false, 'http-code' => '401 UNAUTHORIZED','error' => 'not authorization header received']);
        }
    }

    /**
     * @param bool $custom_error
     * @param int $responseCode
     * @param array $error_content
     *
     * @version 1.0
     */
    private function error_auth($custom_error = false,$responseCode = Response::HTTP_UNAUTHORIZED,$error_content = array()){
        if(!$custom_error){
            $this->response->setContent(json_encode(['status' => false, 'http-code' => '401 UNAUTHORIZED']));
            $this->response->setStatusCode(Response::HTTP_UNAUTHORIZED);
        } else {
            $this->response->setContent(json_encode($error_content));
            $this->response->setStatusCode($responseCode);
        }

        $this->response->headers->set('Content-Type', 'text/json');
        $this->response->prepare($this->request);
        $this->response->send();
        die();
    }

    /**
     * @param string $methods
     *
     * @version 1.0
     */
    private function error_method(string $methods){
        $this->response->setContent(json_encode(['status' => false, 'http-code' => '405 METHOD NOT ALLOWED','method-allowed' => $methods]));
        $this->response->headers->set('Content-Type', 'text/json');
        $this->response->setStatusCode(Response::HTTP_METHOD_NOT_ALLOWED);
        $this->response->prepare($this->request);
        $this->response->send();
        
        die();
    }

    public function disable_auth(){
        if(isset($this->disable_auth)){
            if($this->disable_auth){
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}