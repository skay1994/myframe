<?php

namespace App\Apptj\Models;

use Doctrine\ORM\Mapping as ORM;
use SKYCore\Traits\Helpers\DoctrineTrait;
/**
 * @property $id
 * @property $name
 *
 * @ORM\Entity()
 * @ORM\Table(name="companies")
 *
 *
 * Class Companies
 * @package app\blog\models
 */
class Companies
{
    use DoctrineTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="string")
     * @var
     */
    public $name;

    public function __construct(int $id = null)
    {
        if($id !== null){
            return $this->find($id);
        }
    }

}