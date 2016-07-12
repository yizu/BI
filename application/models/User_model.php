<?php

/**
 * Project:     乐恒BI管理后台
 * File:        User_model.php
 *
 * <pre>
 * 描述：用户信息模型层
 * </pre>
 *
 * @package application
 * @subpackage models
 * @author 李杨 <768216362@qq.com>
 * @copyright 2016 joy4you Inc.
 */


class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('joy_user_1', true);
        $this->db_name = 'loginrecord';
    }

    //查询周活跃用户
    public function findActivist($starttime, $endtime, $roofGarden, $channelid) {

        $sql = "select date_format(FROM_UNIXTIME(logintime),'%Y-%m-%d') as date, COUNT(distinct(userid)) as sum, logintime
                from " . $this->db_name . " 
                where logintime >= unix_timestamp(date('$starttime')) and logintime <= unix_timestamp(date('$endtime'))
                group by date_format(FROM_UNIXTIME(logintime),'%Y-%m-%d')";


        $result = $this->db->query($sql)->result_array();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

}
