<?php

namespace App\Apptj\Models;

use Doctrine\ORM\Mapping as ORM;
use SKYCore\Traits\Helpers\DoctrineTrait;
/**
 * @property integer $id
 * @property integer $company
 * @property integer $user
 * @property string $title
 * @property string $content
 * @property string $create
 * @property string $update
 * @property string $status
 *
 * Class Posts
 * @package App\Apptj\Models,
 *
 * @ORM\Entity()
 */
class Posts
{
    use DoctrineTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="company_id",type="integer")
     */
    private $company;

    /**
     * @ORM\Column(name="user_id",type="integer")
     */
    private $user;

    /**
     * @ORM\Column(type="string",length=250)
     */
    private $title;

    /**
     * @ORM\Column(type="string")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

}