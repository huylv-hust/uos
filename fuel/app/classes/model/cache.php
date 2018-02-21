<?php

/**
 * @author NamDD6566
 * Class Cache
 * @package Model
 */
class Model_Cache extends \Fuel\Core\Model_Crud
{
    protected static $_table_name = 'cache';
    protected static $_primary_key = 'cache_key';

    public function get_info_data($id)
    {
        $obj = static::forge()->find_by_pk($id);
        if ($obj !== null) {
            return json_decode($obj->_data['cache_value'], true);
        }

        return false;
    }

    public static function saveJson($key, $val, $expire = 0)
    {
        $data = [
            'cache_key' => $key,
            'cache_value' => json_encode($val),
            'expire_time' => $expire,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $cache = static::forge();
        if ($cache->find_by_pk($key) == null) {
            $data['created_at'] = date('Y-m-d H:i:s');
            $cache->is_new(true);
        } else {
            $cache->is_new(false);
        }

        $cache->set($data);
        $cache->save();
    }

    public static function getJson($key)
    {
        $cache = static::forge()->find_by_pk($key);
        if (
            $cache == null ||
            ($cache->expire_time && $cache->expire_time < time())
        ) {
            return null;
        } else {
            return json_decode($cache->cache_value, true);
        }
    }

    public static function saveBin($key, $val, $expire = 0)
    {
        $data = [
            'cache_key' => $key,
            'cache_bin' => $val,
            'expire_time' => $expire,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $cache = static::forge();
        if ($cache->find_by_pk($key) == null) {
            $data['created_at'] = date('Y-m-d H:i:s');
            $cache->is_new(true);
        } else {
            $cache->is_new(false);
        }

        $cache->set($data);
        $cache->save();
    }

    public static function getBin($key)
    {
        $cache = static::forge()->find_by_pk($key);
        if (
            $cache == null ||
            ($cache->expire_time && $cache->expire_time < time())
        ) {
            return null;
        } else {
            return $cache->cache_bin;
        }
    }

}
