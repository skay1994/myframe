<?php

/**
 * @param string $view
 * @param array $data
 * @param bool $disableTemplate
 * @return void
 */
function loadView(string $view, array $data = [],bool $disableTemplate = false){
    \SKYCore\Load::getLoadedStatic('Output')['object']->setView($view,$data,$disableTemplate);
}

/**
 * @param string $url
 * @return string
 */
function base_url(string $url){
    /** @var \SKYCore\Routing $router */
    $router = \SKYCore\Load::getLoadedStatic('Routing')['object'];
    return $router->getBaseUri().'/'.$url;
}

if(!function_exists('loadAssets')){
    function loadAssets(array $data){
        if(!isset($data['bower_dir'])){
            $bower = array(
                'bower_dir' => 'bower_components/'
            );
            $data = array_merge($data,$bower);
        }

        $style = '';

        if(isset($data['css']) && $data['css'] != ''){
            $css = count($data['css']);
            for ($c = 0; $c < $css; $c++){
                if(isset($data['css'][$c]['use_bower'])){
                    $style .= '<link href="'.base_url($data['bower_dir'] . $data['css'][$c]['href']) .'" rel="stylesheet" type="text/css">'."\n";
                } elseif(isset($data['css'][$c]['extern'])){
                    $style .= '<link href="'.$data['css'][$c]['href'] .'" rel="stylesheet" type="text/css">'."\n";
                } else {
                    $style .= '<link href="'.base_url($data['css'][$c]['href']) .'" rel="stylesheet" type="text/css">'."\n";
                }
            }
        }

        $scripts = '';

        if(isset($data['js']) && $data['js'] != ''){
            $js = count($data['js']);
            for ($j = 0; $j < $js; $j++){
                if(isset($data['js'][$j]['use_bower'])){
                    $scripts .= '<script src="'.base_url($data['bower_dir'] . $data['js'][$j]['src']) .'" type="text/javascript"></script>'."\n";
                } elseif(isset($data['js'][$j]['extern'])){
                    $scripts .= '<script src="'.$data['js'][$j]['src'].'" type="text/javascript"></script>'."\n";
                } else {
                    $scripts .= '<script src="'.base_url($data['js'][$j]['src']) .'" type="text/javascript"></script>'."\n";
                }
            }
        }
        if($style != '' && $scripts != ''){
            return [
                'style' => $style,
                'script' => $scripts
            ];
        } elseif($style != '' && $scripts == ''){
            return ['style' => $style];
        } elseif($style == '' && $scripts != ''){
            return ['script' => $scripts];
        }
    }
}

if(!function_exists('assets_app')){

    /**
     * @param string $url
     * @return string
     */
    function assets_app(string $url){
        /** @var \SKYCore\Routing $router */
        $router = \SKYCore\Load::getLoadedStatic('Routing')['object'];

        if(is_array(getConfigs('apps')) && count(getConfigs('apps')) > 1){
            return $router->getBaseUri().'/assets/'.$router->getApplication().$url;
        } else {
            return $router->getBaseUri().'/assets/'.$url;
        }

    }
}