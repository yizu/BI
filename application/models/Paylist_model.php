<?php

/**
 * Project:     乐恒互动BI系统
 * File:        Paylist_model.php
 *
 * <pre>
 * 描述  支付方式的种类（成功返回数据失败返回false）
 * </pre>
 *
 * @package application
 * @subpackage models
 * @author 刘训鹏 <1352345519@qq.com>
 * @copyright 2015 JoyBI 
 */
class Paylist_model extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('joy_user_1', true);
        $this->db_name = "paylist";
    }
    /**
     * 所有支付方式的种类
     * @return array 支付方式的种类
     */
    public function findPaylist() {
        $sql = "select distinct payname as payname from " . $this->db_name;
        $result = $this->db->query($sql)->result_array();
        $this->db->close();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

}
?>
