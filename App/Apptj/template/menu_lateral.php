<div class="col-md-3 left_col" >
    <div class="left_col scroll-view ">
        <div class="navbar nav_title" style="border: 0;">
            <a href="<?=$base?>" class="site_title"><i class="fa fa-paw"></i> <span>{{ locale.session_data.company_name }}</span></a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
                <img src="images/img.jpg" alt="" class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>{{ locale.general.welcome }},</span>
                <h2>{{ locale.session_data.user_name }}</h2>
            </div>
        </div>
        <!-- /menu profile quick info -->

        <br />

        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

            <?php
            $base_menu = [
                [
                    'name' => '',
                    'itens' => array()
                ]
            ];

            $menu_lateral = new_app_anchor('app_sidebar_menu_top',$base_menu);

            $geral = [];

            $menuGeral = new_app_anchor('slidebar_menu_geral',[$geral] ?? array());

            $menuCustom = new_app_anchor('slidebar_menu_custom',array());

            $config = array(
                'configurações' => array(
                    'geral' => array(
                        'name' => '{{ locale.dashboard.system }}',
                        'icon' => array(
                            'type' => 'fa',
                            'icon' => 'fa-cog'
                        ),
                        'level_two' => array()
                    )
                )
            );

            $menuConfig = new_app_anchor('slidebar_menu_config', [$config] ?? array());

            $menu = array_merge($menuGeral,$menuCustom,$menuConfig);

            $menuSelection = count($menu);

            $ul = '';

            for ($f = 0; $f < $menuSelection; $f++) {
                $ul .= '<div class="menu_section">';
                $title = array_keys($menu);

                $ul .= '<h3>' . ucfirst($title[$f]) . '</h3>';

                $menu1 = count($menu[$title[$f]]);

                $ul .= '<ul class="nav side-menu">';

                for ($a = 0; $a < $menu1; $a++) {

                    $key = array_keys($menu[$title[$f]]);

                    if (isset($menu[$title[$f]][$key[$a]]['level_two'])) {

                        $ul .= '<li><a><i class="'.$menu[$title[$f]][$key[$a]]['icon']['type'].' ' .$menu[$title[$f]][$key[$a]]['icon']['icon']. '"></i> ' . $menu[$title[$f]][$key[$a]]['name'] . ' <span class="fa fa-chevron-down"></span></a>';
                        $ul .= '<ul class="nav child_menu">';

                        $countSub = count($menu[$title[$f]][$key[$a]]['level_two']);

                        $key2 = array_keys($menu[$title[$f]][$key[$a]]['level_two']);

                        for ($e = 0; $e < $countSub; $e++) {
                            if (isset($menu[$title[$f]][$key[$a]]['level_two'][$key2[$e]]['level_three'])) {

                                $ul .= '<li><a>' . $menu[$title[$f]][$key[$a]]['level_two'][$key2[$e]]['name'] . '<span class="fa fa-chevron-down"></span></a>';

                                $ul .= '<ul class="nav child_menu">';
                                $countSubThree = count($menu[$title[$f]][$key[$a]]['level_two'][$key2[$e]]['level_three']);

                                for ($i = 0; $i < $countSubThree; $i++) {
                                    $ul .= '<li><a href="' . $menu[$title[$f]][$key[$a]]['level_two'][$key2[$e]]['level_three'][$i]['url'] . '">' . $menu[$title[$f]][$key[$a]]['level_two'][$key2[$e]]['level_three'][$i]['name'] . '</a></li>';
                                }

                                $ul .= '</ul>';

                                $ul .= '</li>';
                            } else {
                                $ul .= '<li><a href="' . $menu[$title[$f]][$key[$a]]['level_two'][$key2[$e]]['url'] . '">' . $menu[$title[$f]][$key[$a]]['level_two'][$key2[$e]]['name'] . '</a></li>';
                            }
                        }

                        $ul .= '</ul>';
                        $ul .= '</li>';
                    } else {

                        $ul .= '<li><a href="'.$menu[$title[$f]][$key[$a]]['url'].'" ><i class="'.$menu[$title[$f]][$key[$a]]['icon']['type'].' '.$menu[$title[$f]][$key[$a]]['icon']['icon'].'"></i>' . $menu[$title[$f]][$key[$a]]['name'] . '</a>';
                    }
                }
                $ul .= '</ul>';


                $ul .= '</div>';
            }

            echo $ul;

            ?>

        </div>

        <!-- /menu footer buttons -->
        <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
        </div>
        <!-- /menu footer buttons -->
    </div>
</div>