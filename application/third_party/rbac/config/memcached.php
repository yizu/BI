<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Memcached
| -------------------------------------------------------------------------
|
*/
//是否开启
$config['flag'] = FALSE;
//memcached权限验证
$config['config'] = array(
               'servers' => '192.168.17.232:11211',
               'debug'   => false
             );

/* End of file memcached.php */