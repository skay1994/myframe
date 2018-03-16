<?php

use SKYCore\load;

require_once 'model/Groups.php';
/**
 * Class TJPermissions
 *
 * @version 1.0
 */
class TJPermissions {

    /**
     * @var null
     */
    private static $instance = null;

    /**
     * @var null
     */
    static $permissions = null;

    public function __construct(){
        $this->session = Load::getLoadedStatic('Session')['object'];

        /** @var \SKYCore\database $db */
        $db = Load::getLoadedStatic('Database')['object'];
        $this->db = $db;
    }

    /**
     * @return TJPermissions
     *
     * @version 1.0
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param array $rule
     * @return bool
     *
     * @version 1.0
     */
    public function checkPermission(array $rule){
        $permissions = self::$permissions->permission;

        $module = array_keys($rule)[0];
        $permission = $rule[$module];

        $cnt = count($permissions);

        if ($cnt >= 1) {
            for ($e = 0; $e < $cnt; $e++) {
                if($permissions[$e][$module] == 'superAdmin')
                    return true;
                elseif(isset($permissions[$e][$module]) && $permissions[$e][$module] == $permission)
                    return true;
            }
        } else {
            if(!empty($permissions)){
                if (isset($permissions[0][$module]) && $permissions[0][$module] == $permission)
                    return true;

//                die(trigger_error('Erro no sistema, entre em contato com o suporte: INVALID_OR_NO_ADMIN_ERR'));
            } else {
                return false;
            }
        }

        return false;
    }

    /**
     * @param int $id
     * @return null
     *
     * @version 1.0
     */
    public function getPermissions(){

        $permissions = new \TJPermission\Groups();
        $permissions = $permissions->findAll();

        $module = array();

        if(self::$permissions === null){
            if(!empty($permissions)){

                foreach($permissions as $group){

                    $permission = explode(',', $group->permissions);

                    $cnt = count($permission);

                    for ($e = 0; $e < $cnt; $e++) {
                        $array = explode(':', $permission[$e]);

                        if(!empty($array[0])){
                            $module['permission'][$group->id][] = [$array[0] => $array[1]];
                        }

                    }

                }

                self::$permissions = (object) $module;
            }
        } else
            return self::$permissions;
    }
}