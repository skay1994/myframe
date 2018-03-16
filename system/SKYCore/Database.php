<?php

namespace SKYCore;

use Doctrine\ORM\{
    EntityManager,
    Tools\Setup
};
use SKYCore\Traits\Helpers\{
    currentApp,
    configurations
};
/**
 * Class Database
 * @package SKYCore
 *
 * @version 1.0
 */
class Database
{
    /** @var EntityManager  */
    private $doc;

    use currentApp, configurations;

    /**
     * Database constructor.
     *
     * @version 1.0
     */
    function __construct()
    {
        $db_connect = $this->getConfigs('db_connect');

        if(!is_null($db_connect)){
            $path = $this->getConfigs('db_doctrine_entity');
            $isDev = $this->getConfigs('db_doctrine_isdev_mod');
            $proxy = $this->getConfigs('db_doctrine_proxy');
            $cache = $this->getConfigs('db_doctrine_cache');
            $simpleAnnotation = $this->getConfigs('db_doctrine_use_simpleannotation');

            if($cache == false){
                $cache = null;
            }
            if($proxy == false){
                $proxy = null;
            }

            $setup = Setup::createAnnotationMetadataConfiguration($path,$isDev,$proxy,$cache,$simpleAnnotation);
            $this->doc = EntityManager::create($db_connect,$setup);
        }

        return $this->doc;
    }

    /**
     * @return EntityManager
     *
     * @version 1.0
     */
    public function getDoc(): EntityManager
    {
        return $this->doc;
    }

    public function getPDO()
    {
        $conection = $this->doc->getConnection();
        return $conection->getWrappedConnection();
    }

    /**
     * @url http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/transactions-and-concurrency.html#approach-2-explicitly
     */
    public function beginTransaction()
    {
        $this->doc->getConnection()->beginTransaction();
    }

    /**
     * @url http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/transactions-and-concurrency.html#approach-2-explicitly
     */
    public function commit()
    {
        $this->doc->getConnection()->commit();
    }

    /**
     * @url http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/transactions-and-concurrency.html#approach-2-explicitly
     */
    public function rollBack()
    {
        $this->doc->getConnection()->rollBack();
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     *
     * @version 1.0
     */
    public function getQueryBuilder()
    {
        return $this->doc->createQueryBuilder();
    }

    /**
     * @param EntityManager $entity
     *
     * @version 1.0
     */
    public function persist(EntityManager $entity){
        $this->doc->persist($entity);
    }

    /**
     * @version 1.0
     */
    public function flush(){
        $this->doc->flush();
    }
}