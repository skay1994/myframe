<?php

namespace App\Apptj\Models;

use Doctrine\ORM\Mapping as ORM;
use SKYCore\Traits\Helpers\DoctrineTrait;
/**
 * @ORM\Entity()
 * @ORM\Table(name="loggin_attemps")
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $date
 *
 * @method getID()
 * @method getUser_id()
 * @method setUser_id()
 * @method getDate()
 *
 * Class LogginAttemps
 * @package App\apptj\models
 */
class LogginAttemps
{
    use DoctrineTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $user_id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;
}