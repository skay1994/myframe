<?php

namespace App\Apptj\Core;

use \SKYCore\Controllers\Controller as Controller;
use SKYCore\Modules\LanguageReplacer;

/**
 * Class CustomController
 * @package App\Apptj\Core
 */
class CustomController extends Controller
{
  /**
   * @version 1.0
   */
    public function __construct()
    {
        parent::__construct();

        if(!$this->session->user_logged){
            $current_uri = $this->request->server->get('REQUEST_URI');

            if(strlen($current_uri) > 1){
                header('Location: '.$this->router->getBaseUri().'/login?redirect_uri='.htmlspecialchars($current_uri));
            } else {
                header('Location: '.$this->router->getBaseUri().'/login');
            }
        } else {
            if($this->session->get('user')['ip'] !== $this->request->server->get('REMOTE_ADDR')){
                header('Location: '.$this->router->getBaseUri().'/login/logout');
            }
        }

        new_system_callback('view_data_content',[$this,'view_data']);
        new_system_callback('application_langreplace',[$this,'system_custom_langR']);
        new_system_callback('application_langreplace_debug',[$this,'lang_debug']);
        new_app_callback('slidebar_menu_geral',[$this,'addMenu']);
    }

    public function view_data($data)
    {
        $data['menu_topo']['user_data'] = $this->session->get('user');
        $data['menu_lateral']['company_data'] = $this->session->get('company');

        return $data;
    }

    public function system_custom_langR(languageReplacer $lr)
    {
        $company = $this->session->get('company');
        $user = $this->session->get('user');

        $session_data = [];

        foreach ($company as $key => $value){
            $session_data['company_'.$key] = $value;
        }

        foreach ($user as $key => $value){
            $session_data['user_'.$key] = $value;
        }

        unset($session_data['user_id']);
        unset($session_data['user_group']);
        unset($session_data['company_id']);
        unset($session_data['user_id']);

        $config = [
            'base_text' => '',
            'base_model' => 'locale.session_data'
        ];
        $customLR = new languageReplacer($config);
        $customLR->setFileContents(json_decode(json_encode($session_data)));
        $customLR->getModels();
        $customLR->getTexts();

        $lr->models = array_merge($customLR->models,$lr->models);
        $lr->texts = array_merge($customLR->texts,$lr->texts);

        return $lr;
    }

    public function addMenu($menu){

        $postsNovo = array(
            'site' => array(
                array(
                    'name' => 'Posts e Midias',
                    'url' => '',
                    'icon' => array(
                        'type' => 'fa',
                        'icon' => 'fa-pencil'
                    ),
                    'level_two' => array(
                        array(
                            'name' => 'Nova Postagem',
                            'url' => base_url('posts/new'),
                            'icon' => array(
                                'type' => 'fa',
                                'icon' => 'fa-list-ul'
                            )
                        ),
                        array(
                            'name' => 'Todas as Postagem',
                            'url' => base_url('posts'),
                            'icon' => array(
                                'type' => 'fa',
                                'icon' => 'fa-list-ul'
                            )
                        ),
                        array(
                            'name' => 'Categorias e Tags',
                            'url' => base_url('posts/categories_tags'),
                            'icon' => array(
                                'type' => 'fa',
                                'icon' => 'fa-tags'
                            )
                        ), array(
                            'name' => 'Galeria de Imagens',
                            'url' => base_url('posts/galery'),
                            'icon' => array(
                                'type' => 'fa',
                                'icon' => 'fa-file-image-o'
                            )
                        ), array(
                            'name' => 'Lixeira',
                            'url' => base_url('posts/trash'),
                            'icon' => array(
                                'type' => 'fa',
                                'icon' => 'fa-trash'
                            )
                        )
                    )
                )
            )
        );

        $empresaNovo = array(
            'empresa' => array(
                array(
                    'name' => 'Finanças',
                    'url' => '',
                    'icon' => array(
                        'type' => 'fa',
                        'icon' => 'fa-pencil'
                    ),
                    'level_two' => array(
                        array(
                            'name' => 'Graficos',
                            'url' => base_url('financial/graphs'),
                            'icon' => array(
                                'type' => 'fa',
                                'icon' => 'fa-list-ul'
                            )
                        ), array(
                            'name' => 'Transações',
                            'url' => '',
                            'level_three' => array(
                                array(
                                    'name' => 'Nova Transação',
                                    'url' => base_url('financial/transaction'),
                                    'icon' => array(
                                        'type' => 'fa',
                                        'icon' => 'fa-list-ul'
                                    )
                                ), array(
                                    'name' => 'Historico',
                                    'url' => base_url('financial/history'),
                                    'icon' => array(
                                        'type' => 'fa',
                                        'icon' => 'fa-tags'
                                    )
                                ), array(
                                    'name' => 'Recorrentes',
                                    'url' => base_url('financial/recurrence'),
                                    'icon' => array(
                                        'type' => 'fa',
                                        'icon' => 'fa-file-image-o'
                                    )
                                ),
                            )
                        ), array(
                            'name' => 'Conversao de Valores',
                            'url' => base_url('financial/conversion'),
                            'icon' => array(
                                'type' => 'fa',
                                'icon' => 'fa-trash'
                            )
                        )
                    )
                )
            )
        );

        $menu = array_merge($postsNovo,$empresaNovo,$menu);

        return $menu;
    }

    public function lang_debug($model,$text)
    {
//        var_dump($model);
//        var_dump($text);
    }
}
