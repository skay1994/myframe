<?php

namespace App\Apptj\Models;

use Doctrine\ORM\Mapping as ORM;
use SKYCore\Traits\Helpers\DoctrineTrait;

/**
 * @property int $id
 * @property int $company
 * @property string $name
 * @property int $type
 * @property string $create
 * @property string $update
 *
 * Class Categories
 * @package App\Apptj\Models
 *
 * @ORM\Entity(name="categories")
 */
class Categories
{
    use DoctrineTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer",name="company_id")
     */
    private $company;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $type;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    public function __construct(int $id = null)
    {
        if($id){
            return $this->find($id);
        }
    }
}