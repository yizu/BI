<?php

/**
 * Project:     乐恒互动BI业务层
 * File:        My_Service.php
 *
 * <pre>
 * 描述：业务层基类
 * </pre>
 *
 * @category   PHP
 * @package    Include
 * @subpackage My_Service
 * @author     liyang <768216362@qq.com>
 * @copyright  2016 Joy4You, Inc.
 * @license    BSD Licence
 * @link       http://example.com
 */
class MY_Service {

    /**
     * 缓存是否开启
     * @var boolean
     */
    private $_cache_open = false;

    /**
     * 缓存操作句柄
     * @var obj
     */
    private $_cache_obj = null;

    /**
     * 错误信息
     *
     * @var string
     */
    protected $error = '';

    /**
     * 接口配置信息
     * @var string
     */
    protected static $p_interface_conf = array();

    public function __construct() {
        log_message('debug', "Service Class Initialized");
    }

    /**
     * 获取接口配置信息
     * @return array
     */
    public static function getInterfaceConf() {
        return self::$p_interface_conf;
    }

    /**
     * 获取错误信息
     * @return string
     */
    public function getError() {
        return $this->error;
    }

    /**
     * 设置错误信息
     * @param string $str 错误信息
     * @return null
     */
    public function setError($str) {
        $this->error = $str;
    }

    function __get($key) {
        $CI = & get_instance();
        return $CI->$key;
    }

    /**
     * 多维数组去重
     * @param string $array2D 数组
     * @param string $stkeep 数组
     * @param string $ndformat 数组
     * @return null
     */
    public function _unique_arr($array2D, $stkeep = false, $ndformat = true) {
        // 判断是否保留一级数组键 (一级数组键可以为非数字)
        if ($stkeep)
            $stArr = array_keys($array2D);
        // 判断是否保留二级数组键 (所有二级数组键必须相同)
        if ($ndformat)
            $ndArr = array_keys(end($array2D));
        //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
        foreach ($array2D as $v) {
            $v = join(",", $v);
            $temp[] = $v;
        }
        //去掉重复的字符串,也就是重复的一维数组
        $temp = array_unique($temp);
        //再将拆开的数组重新组装
        foreach ($temp as $k => $v) {
            if ($stkeep)
                $k = $stArr[$k];
            if ($ndformat) {
                $tempArr = explode(",", $v);
                foreach ($tempArr as $ndkey => $ndval)
                    $output[$k][$ndArr[$ndkey]] = $ndval;
            } else
                $output[$k] = explode(",", $v);
        }
        return $output;
    }

}

/* End of file My_Service.php */
