<?php

namespace SKYCore;

use Symfony\Component\Cache\{
    Adapter\FilesystemAdapter,
    CacheItem
};

/**
 * Class Cache
 * @package SKYCore
 *
 * @version 1.0
 */
class Cache{

    /**
     * @var FilesystemAdapter
     */
    private $cache;

    /**
     * Cache constructor.
     *
     * @version 1.0
     */
    public function __construct()
    {
        $router = Load::getLoadedStatic('Routing')['object'];
        $config = Load::getLoadedStatic('Configuration')['object'];

        if(is_bool(getConfigs('cache_use_custom_adapter')) && getConfigs('cache_use_custom_adapter')){
            if(is_callable(getConfigs('cache_custom_adapter'))){
                $this->cache = getConfigs('cache_use_custom_adapter');

                return true;
            }
        }

        $this->cache = new FilesystemAdapter(
            $router->application.'_cache',
            $config->cache_life_time ?? 604800,
            APPPATH.$router->application.DS.$config->cache_path
        );
    }

    /**
     * @param $item
     * @return CacheItem
     *
     * @version 1.0
     */
    public function getItem($item):CacheItem
    {
        if(is_string($item))
            return $this->cache->getItem($item);
        elseif (is_array($item))
            return $this->cache->getItems($item);
    }

    /**
     * @param string $item
     * @return bool
     *
     * @version 1.0
     */
    public function hasItem(string $item):bool
    {
        return $this->cache->hasItem($item);
    }

    /**
     * @param CacheItem $item
     * @return bool
     *
     * @version 1.0
     */
    public function save(CacheItem $item):bool
    {
        return $this->cache->save($item);
    }

    /**
     * @param $item
     * @return bool
     *
     * @version 1.0
     */
    public function deleteItem($item):bool
    {
        if(is_string($item))
            return $this->cache->deleteItem($item);
        elseif (is_array($item))
            return $this->cache->deleteItems($item);
    }

    /**
     * @return bool
     *
     * @version 1.0
     */
    public function clear():bool
    {
        return $this->cache->clear();
    }

    /**
     * @param string $key
     * @return bool|CacheItem
     *
     * @version 1.0
     */
    public function checkCache(string $key)
    {
        if($this->hasItem($key)){
            $cache = $this->getItem($key);

            if($cache->isHit()){
                return $cache;
            } else{
                return false;
            }

        } else {
            return false;
        }
    }
}