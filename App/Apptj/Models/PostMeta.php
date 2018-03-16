<?php

namespace App\Apptj\Models;

use Doctrine\ORM\Mapping as ORM;
use SKYCore\Traits\Helpers\DoctrineTrait;

/**
 * @property integer $id
 * @property integer $company
 * @property integer $post
 * @property string $type
 * @property string $value
 *
 * Class PostMeta
 * @package App\Apptj\Models
 *
 * @ORM\Entity()
 * @ORM\Table(name="post_meta")
 */
class PostMeta
{
    use DoctrineTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column()
     */
    private $id;

    /**
     * @ORM\Column(name="company_id",type="integer")
     */
    private $company;

    /**
     * @ORM\Column(name="post_id",type="integer")
     */
    private $post;

    /**
     * @ORM\Column(type="integer")
     */
    private $type;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private $value;
}