<?php
namespace TJPermission;

use Doctrine\ORM\Mapping as ORM;
use SKYCore\Traits\Helpers\doctrineTrait;

/**
 * @method getID():int
 * @method getName():string
 * @method setName(string $name)
 * @method getPermissions():string
 * @method setPermissions(string $permissions)
 *
 * Class Groups
 *
 * @ORM\Entity()
 * @ORM\Table(name="permissions")
 */
class Groups
{
    use doctrineTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id",type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="name",type="string")
     */
    private $name;

    /**
     * @ORM\Column(name="permissions",type="string")
     */
    private $permissions;

    public function __construct(int $id = null)
    {
        if($id !== null){
            return $this->loadID($id);
        }
    }
}