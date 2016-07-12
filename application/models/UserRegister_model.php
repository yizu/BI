<?php

/**
 * Project:     乐恒互动BI系统
 * File:        UserRegister_model.php
 *
 * <pre>
 * 描述  获取用户所有支付信息（成功返回数据失败返回false）
 * </pre>
 *
 * @package application
 * @subpackage models
 * @author 刘训鹏 <1352345519@qq.com>
 * @copyright 2015 JoyBI 
 */
class UserRegister_model extends CI_Model {

    /**
     * 数据库表名
     * 
     * @var array
     */
    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('joy_user_1', true);
        $this->db_name = "user_register_other";
    }

    /**
     * 查找时间区间内每天注册人数
     * @return array 时间区间内每天注册人数（二维数组）
     */
    public function findEnrollment($starttime, $endtime, $roofGarden, $channelid, $appid) {
        $roofGarden = isset($roofGarden) && !empty($roofGarden) ? '  and ' . $this->db_name . '.from="' . $roofGarden . '"' : '';
        $channelid = isset($channelid) && !empty($channelid) ? '  and ' . $this->db_name . '.channelid="' . $channelid . '"' : '';
        $appid = isset($appid) && !empty($appid) ? '  and  user_register.appid="' . $appid . '"' : '';
        $sql = "select  date_format(FROM_UNIXTIME(registertime),'%Y-%m-%d') as date,COUNT(" . $this->db_name . ".id) as zhucerenshu from " . $this->db_name . " inner join user_register on user_register.id =" . $this->db_name . ".uid where registertime >= unix_timestamp(date('" . $starttime . "')) and registertime <= unix_timestamp(date('" . $endtime . "')) " . $roofGarden . $channelid . $appid . " group by date_format(FROM_UNIXTIME(registertime),'%Y-%m-%d') order by FROM_UNIXTIME(registertime) desc";
        $result = $this->db->query($sql)->result_array();
        $this->db->close();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 查询时间区间内按渠道所有刚注册的人数
     * @param string  $starttime      查询的开始时间
     * @param string $endtime    查询的结束时间
     * @param string $roofGarden    要查询的平台
     * @param string $channelid 要查询的渠道信息
     * @return array 查询刚注册的人数数据
     */
    public function findChannelIngoing($starttime, $endtime, $roofGarden, $channelid,$appid) {
        $roofGarden = isset($roofGarden) && !empty($roofGarden) ? '  and ' . $this->db_name . '.from="' . $roofGarden . '"' : '';
        $channelid = isset($channelid) && !empty($channelid) ? '  and ' . $this->db_name . '.channelid="' . $channelid . '"' : '';
        $appid = isset($appid) && !empty($appid) ? '  and  user_register.appid="' . $appid . '"' : '';
        $sql = "select  COUNT(" . $this->db_name . ".id) as zhucerenshu, channelid from " . $this->db_name . " inner join user_register on user_register.id =" . $this->db_name . ".uid  where registertime >= " . $starttime . " and registertime <= " . $endtime . $roofGarden . $channelid .$appid. "  group by channelid order by zhucerenshu desc";
        $result = $this->db->query($sql)->result_array();
        $this->db->close();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 查询平台每天注册人数（在时间范围内）
     * @param string  $starttime      查询的开始时间
     * @param string $endtime    查询的结束时间
     * @return array 查询注册的人数数据
     */
    public function getRegisterCountBytime($starttime, $endtime , $pingtai, $channelid, $appid) {
        if (isset($channelid) && $channelid != "") {
            $channelid = " and user_register_other.channelid='$channelid'";
        } else {
            $channelid = "";
        }
        if (isset($pingtai) && $pingtai != "") {
            $pingtai = " and user_register_other.from='$pingtai'";
        } else {
            $pingtai = "";
        }
        //区分不同游戏（不同游戏传过来的appid值不同）
        if (isset($appid) && $appid != "") {
            $appid = " and user_register.appid='$appid'";
        } else {
            $appid = "";
        }
        $sql = "select date_format(FROM_UNIXTIME(user_register_other.registertime),'%Y-%m-%d') as registertime, COUNT(distinct(user_register_other.uid)) as registercount
                from user_register_other inner join user_register on user_register.id = user_register_other.uid
                where user_register_other.registertime >= unix_timestamp(date('$starttime')) and user_register_other.registertime <= unix_timestamp(date('$endtime')) ".$channelid . $pingtai . $appid ." 
                group by date_format(FROM_UNIXTIME(tokentime),'%Y-%m-%d')";

        $result = $this->db->query($sql)->result_array();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 查询时间区间每天的新进用户价值
     * @param string  $starttime      查询的开始时间
     * @param string $endtime    查询的结束时间
     * @param string $roofGarden    要查询的平台
     * @param string $channelid 要查询的渠道信息
     * @return array 新进用户价值
     */
    public function findNewUserImportance($starttime, $endtime, $roofGarden, $channelid, $appid) {
        $roofGarden = isset($roofGarden) && !empty($roofGarden) ? '  and ' . $this->db_name . '.from="' . $roofGarden . '"' : '';
        $userchannelid = isset($channelid) && !empty($channelid) ? '  and ' . $this->db_name . '.channelid="' . $channelid . '"' : '';
        $paychannelid = isset($channelid) && !empty($channelid) ? '  and paylog.channelid="' . $channelid . '"' : '';
        $userappid = isset($appid) && !empty($appid) ? '  and  user_register.appid="' . $appid . '"' : '';
        $payappid = isset($appid) && !empty($appid) ? '  and  paylog.appid="' . $appid . '"' : '';
        $sql = "select SUM(total_fee) AS gongxian from paylog where create_time >= " . $starttime . " and create_time <= " . $endtime . "  and status=1  and uid IN (select uid from user_register_other inner join user_register on user_register.id = user_register_other.uid where date_format(FROM_UNIXTIME(registertime),'%Y-%m-%d')=date_format(FROM_UNIXTIME(" . $starttime . "),'%Y-%m-%d')" . $userchannelid . $userappid . $roofGarden . ")" . $paychannelid . $payappid . " order by date_format(FROM_UNIXTIME(create_time),'%Y-%m-%d') ";
        $result = $this->db->query($sql)->row_array();
        $this->db->close();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 查询平台每天注册人数（在时间范围内）
     * @param string  $starttime      查询的开始时间
     * @param string $endtime    查询的结束时间
     * @return array 查询注册的人数数据
     */
    public function getRegisterCountByPingtai($starttime, $endtime, $type) {

        $sql = "select date_format(FROM_UNIXTIME(registertime),'%Y-%m-%d') as registertime, COUNT(distinct(uid)) as registercount
                from user_register_other
                where registertime >= unix_timestamp(date('$starttime')) and registertime <= unix_timestamp(date('$endtime'))
                      and 'from'='$type'
                group by date_format(FROM_UNIXTIME(registertime),'%Y-%m-%d')";

        $result = $this->db->query($sql)->result_array();

        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 查询平台每天注册人数（在时间范围内）按月统计
     * @param string  $starttime      查询的开始时间
     * @param string $endtime    查询的结束时间
     * @return array 查询注册的人数数据
     */
    public function getRegisterCountByMonth($starttime, $endtime) {

        $sql = "select date_format(FROM_UNIXTIME(tokentime),'%Y-%m') as registertime, COUNT(distinct(id)) as registercount
                from user_register
                where tokentime >= unix_timestamp(date('$starttime')) and tokentime <= unix_timestamp(date('$endtime'))
                group by date_format(FROM_UNIXTIME(tokentime),'%Y-%m')";

        $result = $this->db->query($sql)->result_array();

        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 根据用户id查询出用户的注册时间和用户名
     * @param string $list_uid    用户id数组
     * @return array 用户的注册时间和用户名，用户id
     */
    public function findUsername($list_uid) {
        $sql = "select id as uid,username,phone,tokentime from user_register where id in (" . $list_uid . ") group by id";
        $result = $this->db->query($sql)->result_array();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

}
