<?php

require_once __DIR__.'/TJPermissions.php';
require_once __DIR__.'/helpers/functions.php';

function startTJPermissions(\SKYCore\load $load){
    $loadClass = $load->getLoaded();
    $module = $loadClass['Modules']['object']->getModules('TJPermissions');

    $module_name = 'tjpermissions';

    if(isset($module['user_class_shotcut'])){
        $module_name = $module['user_class_shotcut'];
    }

    $load->addLoadedInstance('TJPermissions',[
        'name' => $module_name,
        'object' => new TJPermissions()
    ]);
}

new_modules_callback('system_all_loaded','startTJPermissions');

$module_data = [
    'class_name' => 'TJPermissions'
];
return $module_data;