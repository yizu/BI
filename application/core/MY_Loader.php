<?php

/**
 * Project:     加载业务层
 * File:        MY_Loader.php
 *
 * <pre>
 * 描述：加载业务层
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
class MY_Loader extends CI_Loader {

    /**
     * List of loaded sercices
     *
     * @var array
     * @access protected
     */
    protected $_ci_services = array();

    /**
     * List of paths to load sercices from
     *
     * @var array
     * @access protected
     */
    protected $_ci_service_paths = array();

    /**
     * Constructor
     * 
     * Set the path to the Service files
     */
    public function __construct() {

        parent::__construct();
        load_class('Service', 'core');
        $this->_ci_service_paths = array(APPPATH);
    }

    /**
     * Service Loader
     *
     * @param	string	类名
     * @param	$params	参数
     * @param	$object_name	对象名
     * @return	void
     */
    public function service($service = '', $params = NULL, $object_name = NULL) {
        if (is_array($service)) {
            foreach ($service as $class) {
                $this->service($class, $params);
            }

            return;
        }

        if ($service == '' or isset($this->_ci_services[$service])) {
            return FALSE;
        }

        if (!is_null($params) && !is_array($params)) {
            $params = NULL;
        }

        $subdir = '';

        if (($last_slash = strrpos($service, '/')) !== FALSE) {
            $subdir = substr($service, 0, $last_slash + 1);

            $service = substr($service, $last_slash + 1);
        }

        foreach ($this->_ci_service_paths as $path) {

            $filepath = $path . 'service/' . $subdir . $service . '.php';

            if (!file_exists($filepath)) {
                continue;
            }

            include_once($filepath);

            $service = strtolower($service);

            if (empty($object_name)) {
                $object_name = $service;
            }

            $service = ucfirst($service);
            $CI = &get_instance();
            if ($params !== NULL) {
                $CI->$object_name = new $service($params);
            } else {
                $CI->$object_name = new $service();
            }

            $this->_ci_services[] = $object_name;

            return;
        }
    }

}
