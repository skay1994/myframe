<?php

namespace App\Apptj\Models;

use Doctrine\ORM\Mapping as ORM;
use SKYCore\Traits\Helpers\DoctrineTrait;
/**
 * @property $id
 * @property $email
 * @property $name
 * @property $username
 * @property $password
 * @property $group
 * @property $company_id
 * @property $status
 *
 * @ORM\Entity()
 * @ORM\Table(name="users")
 *
 * Class Users
 */
class Users
{
    use DoctrineTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $company_id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     */
    private $username;

    /**
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="integer",name="user_group")
     */
    private $group;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @return Posts
     */
    public function getPosts()
    {
        $posts = new Posts();
        return $posts->findBy(['user_id' => $this->id]);
    }

    /**
     * @return Companies
     */
    public function getCompany():Companies
    {
        $company = new Companies();
        return $company->find($this->company_id);
    }

}