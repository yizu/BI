<?php

/**
 * Project:     乐恒互动BI系统
 * File:        Channel_model.php
 *
 * <pre>
 * 描述  获取用户所有渠道信息（成功返回数据失败返回false）
 * </pre>
 *
 * @package application
 * @subpackage models
 * @author 刘训鹏 <1352345519@qq.com>
 * @copyright 2015 JoyBI 
 */
class Channel_model extends CI_Model {

    /**
     * 数据库表名
     * 
     * @var array
     */
    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('joy_user_1', true);
        $this->dbname = "channel";
    }

    /**
     * 查找渠道数据
     * @return array 渠道数据（渠道id和渠道名）；
     */
    public function findChanneldata() {
        $sql = "select * from " . $this->dbname;
        $result = $this->db->query($sql)->result_array();
        $this->db->close();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
    
    /**
     * 通过渠道ID查找渠道名称
     * @return array 渠道数据（渠道id和渠道名）；
     */
    public function getChannelNameByid($channelid) {
        $sql = "select channelname from " . $this->dbname . " where channelid = '$channelid'";
        $result = $this->db->query($sql)->row_array();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

}
