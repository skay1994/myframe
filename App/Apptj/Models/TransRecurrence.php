<?php

namespace App\Apptj\Models;


use Doctrine\ORM\Mapping as ORM;
use SKYCore\Traits\Helpers\DoctrineTrait;

/**
 * @property integer $id
 * @property integer $company
 * @property integer $user
 * @property integer $type
 * @property string $name
 * @property string $currency
 * @property string $value
 * @property string $comment
 * @property string $date_recurrence
 * @property string $create
 * @property integer $status
 *
 * Class TransRecurrence
 * @package App\Apptj\Models
 *
 * @ORM\Entity()
 * @ORM\Table(name="transactions_recurrence")
 */
class TransRecurrence
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
     * @ORM\Column(type="integer")
     */
    private $type;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string",length=10)
     */
    private $currency;

    /**
     * @ORM\Column(name="transaction_value",type="string")
     */
    private $value;

    /**
     * @ORM\Column(name="transaction_comment",type="string")
     */
    private $comment;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_recurrence;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    public function __construct(int $id = null)
    {
        if(!is_null($id)){
            return $this->find($id);
        }
    }
}