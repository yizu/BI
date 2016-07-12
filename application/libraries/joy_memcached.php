<?php

/**
 * Project: 乐恒互动BI缓存类
 * File: joy_memcached.php
 *
 * <pre> 
 * 描述：乐恒互动BI memcached扩展
 * </pre>
 *
 * @category  PHP
 * @package   Include
 * @author    liyang <yang.li@soufun.com>
 * @copyright 2015 Soufun, Inc.
 * @license   BSD Licence
 * @link      http://example.com
 */
class joy_memcached {

    private static $_mem;

    public static function instance() {

        $ci = &get_instance();
        $config = $ci->config->item('joy_memcache');
        self::$_mem = new Memcached;
        self::$_mem->addServer($config['ip'], $config['port']);
    }
    //值设置
    public static function set($key, $value, $exp = 10) {
        if (!isset(self::$_mem)) {
            self::instance();
        }
        if ($exp == 0) {
            return self::$_mem->set($key, $value, 0);
        }
        return self::$_mem->set($key, $value, time() + $exp);
    }
    
    //获取缓存中的值
    public static function get($key) {
        if (!isset(self::$_mem)) {
            self::instance();
        }
        return self::$_mem->get($key);
    }
    //删除缓存中的值
    public static function delete($key) {
        if (!isset(self::$_mem)) {
            self::instance();
        }
        return self::$_mem->delete($key, 0);
    }

}
