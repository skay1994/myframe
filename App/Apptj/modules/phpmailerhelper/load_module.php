<?php

function mailerhelper_config(\SKYCore\load $load, \SKYCore\moduleHelper $helper){
    $helper->copySetting(array(
        array(
            'module_path' => 'config_base.php',
            'config_path' => 'phpmailerhelper.php'
        )
    ));
}

return [
    'class_name' => 'PHPMailerHelper',
    'callbacks' => array(
        'module_configuration' => 'mailerhelper_config'
    )
];