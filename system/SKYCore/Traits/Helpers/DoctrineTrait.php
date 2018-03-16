<?php

namespace SKYCore\Traits\Helpers;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use SKYCore\Load;
/**
 * @method find(int $id)
 * @method findBy(array $data)
 * @method findOneBy(array $data)
 * @method findAll():array
 *
 * Trait DoctrineTrait
 * @package SKYCore\Traits\Helpers
 *
 * @version 1.0
 */
trait DoctrineTrait
{
    /** @var EntityManager */
    public $doctrine;

    /**
     * DoctrineTrait constructor.
     */
    public function __construct()
    {
        $this->doctrine = Load::getLoadedStatic('Database')['object']->getDoc();
    }

    /**
     * @param int $id
     * @return $this|bool
     *
     * @version 1.0
     */
    public static function load(int $id)
    {
        $self = new self();
        return $self->find($id);
    }

    /**
     * @return mixed
     *
     * @version 1.0
     */
    public static function getAllDataBy(array $data)
    {
        $self = new self();
        return $self->findBy($data);
    }

    public static function getAllData()
    {
        $self = new self();
        return $self->findAll();
    }

    /**
     * @version 1.0
     */
    public function flush()
    {
        if(!$this->doctrine){
            $this->getDoctrine();
        }

        $this->doctrine->persist($this);
        $this->doctrine->flush();
    }

    /**
     * @version 1.0
     */
    public function delete()
    {
        if(!$this->doctrine){
            $this->getDoctrine();
        }

        $this->doctrine->remove($this);
        $this->doctrine->flush();
    }

    /**
     * @param array $data
     *
     * @version 1.0
     */
    public function deleteAllBy(array $data)
    {
        if(!$this->doctrine){
            $this->getDoctrine();
        }

        $data = $this->findBy($data);

        if($data){
            foreach ($data as $item){
                /**@var doctrineTrait  $item  */
                $item->delete();
            }
        }
    }

    /**
     * @param array $data
     *
     * @version 1.0
     */
    public static function deleteAllByStatic(array $data)
    {
        $self = new self();

        if(!$self->doctrine){
            $self->getDoctrine();
        }

        $data = $self->findBy($data);

        if($data){
            foreach ($data as $item){
                /**@var doctrineTrait  $item  */
                $item->delete();
            }
        }
    }

    /**
     * @param $name
     * @param $arguments
     * @return bool|mixed
     *
     * @version 1.0
     */
    public function __call($name, $arguments)
    {
        if(!$this->doctrine){
            $this->getDoctrine();
        }

        $repository = $this->doctrine->getRepository(get_called_class());

        $original = null;

        if(strpos($name,'set') !== false){
            $original = $name;
            $name = 'set';
        }

        switch ($name){
            case 'find':
                return call_user_func_array([$repository,'find'],$arguments);
                break;
            case 'findBy':
                return call_user_func_array([$repository,'findBy'],$arguments);
                break;
            case 'findOneBy':
                return call_user_func_array([$repository,'findOneBy'],$arguments);
                break;
            case 'findAll':
                return call_user_func_array([$repository,'findAll'],[]);
                break;
            case 'set':
                $field = strtolower(substr($original,3));

                if(count($arguments) == 1){
                    if($field != 'id') {
                        if(property_exists(get_called_class(),$field))
                            $this->$field = $arguments[0];
                        else
                            return false;
                    } else
                        return false;
                } elseif(count($arguments) == 2){
                    $field = $arguments[1];
                    if($field != 'id') {
                        if(property_exists(get_called_class(),$field))
                            $this->$field = $arguments[0];
                        else
                            return false;
                    } else
                        return false;
                }
                break;
        }
        // TODO: Implement __call() method.
    }

    /**
     * @param string $name
     * @return bool
     *
     * @version 1.0
     */
    public function __get(string $name)
    {
        if(property_exists(get_called_class(),$name))
            return $this->$name;
        else
            return false;
    }

    /**
     * @param string $alias
     * @return QueryBuilder
     *
     * @version 1.0
     */
    public static function getQueryBuilder(string $alias):QueryBuilder
    {
        $self = new self();

        if(!$self->doctrine){
            $self->getDoctrine();
        }

        $data = $self->doctrine->createQueryBuilder();
        $data
            ->select($alias)
            ->from(self::class,$alias);

        return $data;
    }

    /**
     * @param $name
     * @param $value
     * @return bool
     *
     * @version 1.0
     */
    public function __set($name, $value)
    {
        if($name != 'id') {
            if(property_exists(get_called_class(),$name))
                $this->$name = $value;
            else
                return false;
        } else
            return false;
    }

    /**
     * @version 1.0
     */
    private function getDoctrine()
    {
        $this->doctrine = Load::getLoadedStatic('Database')['object']->getDoc();
    }

}