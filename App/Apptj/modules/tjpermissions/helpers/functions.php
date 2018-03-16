<?php
function checkPermission(array $dados){
    /** @var TJPermissions $permission */
    $permission = \SKYCore\Load::getLoadedStatic('TJPermission')['object'];
    return $permission->checkPermission($dados);
}