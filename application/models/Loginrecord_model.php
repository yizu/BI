<?php

/**
 * Project:     乐恒互动BI系统
 * File:        Loginrecord_model.php
 *
 * <pre>
 * 描述  获取用户所有登录信息信息（成功返回数据失败返回false）
 * </pre>
 *
 * @package application
 * @subpackage models
 * @author 刘训鹏 <1352345519@qq.com>
 * @copyright 2015 JoyBI 
 */
class Loginrecord_model extends CI_Model {

    /**
     * 数据库表名
     * 
     * @var array
     */
    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('joy_user_1', true);
        $this->db_name = 'loginrecord';
    }

    /**
     * 时间区间内查询一周（月）活跃用户（去重）登录的人数
     * @param string  $weekstarttime      查询的开始时间
     * @param string $weekendtime    查询的结束时间
     * @param string $roofGarden    要查询的平台
     * @param string $channelid 要查询的渠道信息
     * @return array 查询刚登录的人数数据
     */
    public function findWeekactivist($weekstarttime, $weekendtime, $roofGarden, $channelid, $appid) {
        $roofGarden = isset($roofGarden) && !empty($roofGarden) ? '  and ' . $this->db_name . '.from="' . $roofGarden . '"' : '';
        $channelid = isset($channelid) && !empty($channelid) ? '  and ' . $this->db_name . '.channelid="' . $channelid . '"' : '';
        $appid = isset($appid) && !empty($appid) ? '  and ' . $this->db_name . '.appid="' . $appid . '"' : '';
        $sql = "select COUNT(distinct(userid)) as sum from " . $this->db_name . " where logintime>=$weekstarttime and logintime<=$weekendtime" . $roofGarden . $channelid . $appid;
        $result = $this->db->query($sql)->row_array();
        $this->db->close();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 查询时间区间内每天所有登录（去重）的人数
     * @param string  $starttime      查询的开始时间
     * @param string $endtime    查询的结束时间
     * @param string $roofGarden    要查询的平台
     * @param string $channelid 要查询的渠道信息
     * @return array 查询每天登录的人数数据
     */
    public function findDayactivist($starttime, $endtime, $roofGarden, $channelid) {
        $roofGarden = isset($roofGarden) && !empty($roofGarden) ? '  and ' . $this->db_name . '.from="' . $roofGarden . '"' : '';
        $channelid = isset($channelid) && !empty($channelid) ? '  and ' . $this->db_name . '.channelid="' . $channelid . '"' : '';

        $sql = "select  date_format(FROM_UNIXTIME(logintime),'%Y-%m-%d') as date,COUNT(distinct(userid)) as sum from loginrecord where logintime >= unix_timestamp(date('" . $starttime . "')) and logintime <= unix_timestamp(date('" . $endtime . "'))  group by date_format(FROM_UNIXTIME(logintime),'%Y-%m-%d') order by FROM_UNIXTIME(logintime) desc";
        $result = $this->db->query($sql)->result_array();
        $this->db->close();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 查询平台每天活跃人数（在时间范围内）按日统计
     * @param string  $starttime      查询的开始时间
     * @param string $endtime    查询的结束时间
     * @return array 查询注册的人数数据
     */
    public function getLoginCountBytime($starttime, $endtime) {
        $sql = "select date_format(FROM_UNIXTIME(logintime),'%Y-%m-%d') as logintime, COUNT(distinct(userid)) as logincount
                from loginrecord
                where logintime >= unix_timestamp(date('$starttime')) and logintime <= unix_timestamp(date('$endtime'))
                group by date_format(FROM_UNIXTIME(logintime),'%Y-%m-%d')";

        $result = $this->db->query($sql)->result_array();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 查询平台每天活跃人数（在时间范围内）按月统计
     * @param string  $starttime      查询的开始时间
     * @param string $endtime    查询的结束时间
     * @return array 查询注册的人数数据
     */
    public function getLoginCountByMonth($starttime, $endtime) {
        $sql = "select date_format(FROM_UNIXTIME(logintime),'%Y-%m') as logintime, COUNT(distinct(userid)) as logincount
                from loginrecord
                where logintime >= unix_timestamp(date('$starttime')) and logintime <= unix_timestamp(date('$endtime'))
                group by date_format(FROM_UNIXTIME(logintime),'%Y-%m')";

        $result = $this->db->query($sql)->result_array();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 获取某一天的次日留存
     * @param string  $time      查询的时间
     * @return array 查询登录的人数数据
     */
    public function getCiriRetention($time, $pingtai, $channelid, $appid) {
        $timeafteroneday = date('Y-m-d', strtotime($time) + 86400);
        $timeaftertwoday = date('Y-m-d', strtotime($time) + 2 * 86400);
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
        $sql = "select date_format(FROM_UNIXTIME(user_register_other.registertime),'%Y-%m-%d') as logintime, COUNT(distinct(user_register_other.uid)) as ciriRetention
                from user_register_other inner join user_register on user_register.id = user_register_other.uid
                where user_register_other.registertime >= unix_timestamp(date('$time')) and user_register_other.registertime < unix_timestamp(date('$timeafteroneday')) ".$channelid . $pingtai . $appid ." 
                 and user_register_other.uid in (select userid from loginrecord where logintime >= unix_timestamp(date('$timeafteroneday'))  and logintime< unix_timestamp(date('$timeaftertwoday')))";
        $result = $this->db->query($sql)->row_array();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 获取某一天的3日留存
     * @param string  $time      查询的时间
     * @return array 查询登录的人数数据
     */
    public function getSanRiRetention($time, $pingtai, $channelid, $appid) {
        $timeafteroneday = date('Y-m-d', strtotime($time) + 86400);
        $timeaftertwoday = date('Y-m-d', strtotime($time) + 2 * 86400);
        $timeafterthreeday = date('Y-m-d', strtotime($time) + 3 * 86400);
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
        $sql = "select date_format(FROM_UNIXTIME(user_register_other.registertime),'%Y-%m-%d') as logintime, COUNT(distinct(user_register_other.uid)) as sanriRetention
                from user_register_other inner join user_register on user_register.id = user_register_other.uid
                where user_register_other.registertime >= unix_timestamp(date('$time')) and user_register_other.registertime < unix_timestamp(date('$timeafteroneday')) ".$channelid . $pingtai . $appid ." 
                 and user_register_other.uid in (select userid from loginrecord where logintime >= unix_timestamp(date('$timeaftertwoday'))  and logintime< unix_timestamp(date('$timeafterthreeday')))";
        $result = $this->db->query($sql)->row_array();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 获取某一天的7日留存
     * @param string  $time      查询的时间
     * @return array 查询登录的人数数据
     */
    public function getQiRiRetention($time, $pingtai, $channelid, $appid) {
        $timeafteroneday = date('Y-m-d', strtotime($time) + 86400);
        $timeafterSevenday = date('Y-m-d', strtotime($time) + 6 * 86400);
        $timeaftereightday = date('Y-m-d', strtotime($time) + 7 * 86400);
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
        $sql = "select date_format(FROM_UNIXTIME(user_register_other.registertime),'%Y-%m-%d') as logintime, COUNT(distinct(user_register_other.uid)) as qiriRetention
                from user_register_other inner join user_register on user_register.id = user_register_other.uid
                where user_register_other.registertime >= unix_timestamp(date('$time')) and user_register_other.registertime < unix_timestamp(date('$timeafteroneday')) ".$channelid . $pingtai . $appid ." 
                and user_register_other.uid in (select userid from loginrecord where logintime >= unix_timestamp(date('$timeafterSevenday'))  and logintime< unix_timestamp(date('$timeaftereightday')))";
        $result = $this->db->query($sql)->row_array();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 获取某一天的14日留存
     * @param string  $time      查询的时间
     * @return array 查询登录的人数数据
     */
    public function getShisiriRetention($time, $pingtai, $channelid, $appid) {
        $timeafteroneday = date('Y-m-d', strtotime($time) + 86400);
        $timeafterShiSiday = date('Y-m-d', strtotime($time) + 13 * 86400);
        $timeafterShiwuday = date('Y-m-d', strtotime($time) + 14 * 86400);
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
        $sql = "select date_format(FROM_UNIXTIME(user_register_other.registertime),'%Y-%m-%d') as logintime, COUNT(distinct(user_register_other.uid)) as shisiriRetention
                from user_register_other inner join user_register on user_register.id = user_register_other.uid
                where user_register_other.registertime >= unix_timestamp(date('$time')) and user_register_other.registertime < unix_timestamp(date('$timeafteroneday')) ".$channelid . $pingtai . $appid ." 
                and user_register_other.uid in (select userid from loginrecord where logintime >= unix_timestamp(date('$timeafterShiSiday'))  and logintime< unix_timestamp(date('$timeafterShiwuday')))";
        $result = $this->db->query($sql)->row_array();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 获取某一天的30日留存
     * @param string  $time      查询的时间
     * @return array 查询登录的人数数据
     */
    public function getSanshiriRetention($time, $pingtai, $channelid, $appid) {
        $timeafteroneday = date('Y-m-d', strtotime($time) + 86400);
        $timeaftersanshiday = date('Y-m-d', strtotime($time) + 29 * 86400);
        $timeaftersanshiyiday = date('Y-m-d', strtotime($time) + 30 * 86400);
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
        $sql = "select date_format(FROM_UNIXTIME(user_register_other.registertime),'%Y-%m-%d') as logintime, COUNT(distinct(user_register_other.uid)) as sanshiriRetention
                from user_register_other inner join user_register on user_register.id = user_register_other.uid
                where user_register_other.registertime >= unix_timestamp(date('$time')) and user_register_other.registertime < unix_timestamp(date('$timeafteroneday')) ".$channelid . $pingtai . $appid ." 
                and user_register_other.uid in (select userid from loginrecord where logintime >= unix_timestamp(date('$timeaftersanshiday'))  and logintime< unix_timestamp(date('$timeaftersanshiyiday')))";
        $result = $this->db->query($sql)->row_array();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 获取付费用户某一天的次日留存
     * @param string  $time      查询的时间
     * @return array 查询登录的人数数据
     */
    public function getPayCiriRetention($time, $pingtai, $channelid, $appid) {
        $timeafteroneday = date('Y-m-d', strtotime($time) + 86400);
        $timeaftertwoday = date('Y-m-d', strtotime($time) + 2 * 86400);
        if (isset($channelid) && $channelid != "") {
            $channelid = " and channelid='$channelid'";
        } else {
            $channelid = "";
        }
        $pingtai = "";
        //区分不同游戏（不同游戏传过来的appid值不同）
        if (isset($appid) && $appid != "") {
            $appid = " and appid='$appid'";
        } else {
            $appid = "";
        }
        $sql = "select date_format(FROM_UNIXTIME(create_time),'%Y-%m-%d') as logintime,  COUNT(DISTINCT(uid)) as ciriRetention from paylog 
                where STATUS = 1 AND unix_timestamp(date_format(FROM_UNIXTIME(create_time),'%Y-%m-%d')) >= unix_timestamp(date('$time')) 
                and unix_timestamp(date_format(FROM_UNIXTIME(create_time),'%Y-%m-%d')) < unix_timestamp(date('$timeafteroneday'))" . $channelid . $pingtai . $appid . " 
                and uid not in(select uid from paylog 
                where unix_timestamp(date_format(FROM_UNIXTIME(create_time),'%Y-%m-%d')) < unix_timestamp(date('$time')))
                and uid in (
                select userid from loginrecord where logintime >= unix_timestamp(date('$timeafteroneday'))  and logintime< unix_timestamp(date('$timeaftertwoday'))
            )";
        $result = $this->db->query($sql)->row_array();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 获取某一天的3日留存
     * @param string  $time      查询的时间
     * @return array 查询登录的人数数据
     */
    public function getPaySanRiRetention($time, $pingtai, $channelid, $appid) {
        $timeafteroneday = date('Y-m-d', strtotime($time) + 86400);
        $timeaftertwoday = date('Y-m-d', strtotime($time) + 2 * 86400);
        $timeafterthreeday = date('Y-m-d', strtotime($time) + 3 * 86400);
        if (isset($channelid) && $channelid != "") {
            $channelid = " and channelid='$channelid'";
        } else {
            $channelid = "";
        }
        $pingtai = "";
        //区分不同游戏（不同游戏传过来的appid值不同）
        if (isset($appid) && $appid != "") {
            $appid = " and appid='$appid'";
        } else {
            $appid = "";
        }
        $sql = "select date_format(FROM_UNIXTIME(create_time),'%Y-%m-%d') as logintime,  COUNT(DISTINCT(uid)) as sanriRetention from paylog 
                where STATUS = 1 AND unix_timestamp(date_format(FROM_UNIXTIME(create_time),'%Y-%m-%d')) >= unix_timestamp(date('$time')) 
                and unix_timestamp(date_format(FROM_UNIXTIME(create_time),'%Y-%m-%d')) < unix_timestamp(date('$timeafteroneday'))" . $channelid . $pingtai . $appid . " 
                and uid not in(select uid from paylog 
                where unix_timestamp(date_format(FROM_UNIXTIME(create_time),'%Y-%m-%d')) < unix_timestamp(date('$time')))
                and uid in (
                select userid from loginrecord where logintime >= unix_timestamp(date('$timeaftertwoday'))  and logintime< unix_timestamp(date('$timeafterthreeday'))
            )";

        $result = $this->db->query($sql)->row_array();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 获取某一天的7日留存
     * @param string  $time      查询的时间
     * @return array 查询登录的人数数据
     */
    public function getPayQiRiRetention($time, $pingtai, $channelid, $appid) {
        $timeafteroneday = date('Y-m-d', strtotime($time) + 86400);
        $timeafterSevenday = date('Y-m-d', strtotime($time) + 6 * 86400);
        $timeaftereightday = date('Y-m-d', strtotime($time) + 7 * 86400);
        if (isset($channelid) && $channelid != "") {
            $channelid = " and channelid='$channelid'";
        } else {
            $channelid = "";
        }
        $pingtai = "";
        //区分不同游戏（不同游戏传过来的appid值不同）
        if (isset($appid) && $appid != "") {
            $appid = " and appid='$appid'";
        } else {
            $appid = "";
        }
        $sql = "select date_format(FROM_UNIXTIME(create_time),'%Y-%m-%d') as logintime,  COUNT(DISTINCT(uid)) as qiriRetention from paylog 
                where STATUS = 1 AND unix_timestamp(date_format(FROM_UNIXTIME(create_time),'%Y-%m-%d')) >= unix_timestamp(date('$time')) 
                and unix_timestamp(date_format(FROM_UNIXTIME(create_time),'%Y-%m-%d')) < unix_timestamp(date('$timeafteroneday'))" . $channelid . $pingtai . $appid . " 
                and uid not in(select uid from paylog 
                where unix_timestamp(date_format(FROM_UNIXTIME(create_time),'%Y-%m-%d')) < unix_timestamp(date('$time')))
                and uid in (
                select userid from loginrecord where logintime >= unix_timestamp(date('$timeafterSevenday'))  and logintime< unix_timestamp(date('$timeaftereightday'))
            )";
        $result = $this->db->query($sql)->row_array();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 获取某一天的14日留存
     * @param string  $time      查询的时间
     * @return array 查询登录的人数数据
     */
    public function getPayShisiriRetention($time, $pingtai, $channelid, $appid) {
        $timeafteroneday = date('Y-m-d', strtotime($time) + 86400);
        $timeafterShiSiday = date('Y-m-d', strtotime($time) + 13 * 86400);
        $timeafterShiwuday = date('Y-m-d', strtotime($time) + 14 * 86400);
        if (isset($channelid) && $channelid != "") {
            $channelid = " and channelid='$channelid'";
        } else {
            $channelid = "";
        }
        $pingtai = "";
        //区分不同游戏（不同游戏传过来的appid值不同）
        if (isset($appid) && $appid != "") {
            $appid = " and appid='$appid'";
        } else {
            $appid = "";
        }
        $sql = "select date_format(FROM_UNIXTIME(create_time),'%Y-%m-%d') as logintime,  COUNT(DISTINCT(uid)) as shisiriRetention from paylog
                where STATUS = 1 AND unix_timestamp(date_format(FROM_UNIXTIME(create_time),'%Y-%m-%d')) >= unix_timestamp(date('$time')) 
                and unix_timestamp(date_format(FROM_UNIXTIME(create_time),'%Y-%m-%d')) < unix_timestamp(date('$timeafteroneday'))" . $channelid . $pingtai . $appid . " 
                and uid not in(select uid from paylog 
                where unix_timestamp(date_format(FROM_UNIXTIME(create_time),'%Y-%m-%d')) < unix_timestamp(date('$time')))
                and uid in (
                select userid from loginrecord where logintime >= unix_timestamp(date('$timeafterShiSiday'))  and logintime< unix_timestamp(date('$timeafterShiwuday'))
            )";
        $result = $this->db->query($sql)->row_array();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 获取某一天的30日留存
     * @param string  $time      查询的时间
     * @return array 查询登录的人数数据
     */
    public function getPaySanshiriRetention($time, $pingtai, $channelid, $appid) {
        $timeafteroneday = date('Y-m-d', strtotime($time) + 86400);
        $timeaftersanshiday = date('Y-m-d', strtotime($time) + 29 * 86400);
        $timeaftersanshiyiday = date('Y-m-d', strtotime($time) + 30 * 86400);
        if (isset($channelid) && $channelid != "") {
            $channelid = " and channelid='$channelid'";
        } else {
            $channelid = "";
        }
        $pingtai = "";
        //区分不同游戏（不同游戏传过来的appid值不同）
        if (isset($appid) && $appid != "") {
            $appid = " and appid='$appid'";
        } else {
            $appid = "";
        }
        $sql = "select date_format(FROM_UNIXTIME(create_time),'%Y-%m-%d') as logintime,  COUNT(DISTINCT(uid)) as sanshiriRetention from paylog 
                where STATUS = 1 AND unix_timestamp(date_format(FROM_UNIXTIME(create_time),'%Y-%m-%d')) >= unix_timestamp(date('$time')) 
                and unix_timestamp(date_format(FROM_UNIXTIME(create_time),'%Y-%m-%d')) < unix_timestamp(date('$timeafteroneday'))" . $channelid . $pingtai . $appid . " 
                and uid not in(select uid from paylog 
                where unix_timestamp(date_format(FROM_UNIXTIME(create_time),'%Y-%m-%d')) < unix_timestamp(date('$time')))
                and uid in (
                select userid from loginrecord where logintime >= unix_timestamp(date('$timeaftersanshiday'))  and logintime< unix_timestamp(date('$timeaftersanshiyiday'))
            )";
        $result = $this->db->query($sql)->row_array();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 查询时间区间内平台和渠道每天所有登录（去重）的人数
     * @param string  $starttime      查询的开始时间
     * @param string $endtime    查询的结束时间
     * @param string $roofGarden    要查询的平台
     * @param string $channelid 要查询的渠道信息
     * @return array 查询每天登录的人数数据
     */
    public function getDayactivist($starttime, $endtime, $roofGarden, $channelid, $appid) {
        $roofGarden = isset($roofGarden) && !empty($roofGarden) ? '  and ' . $this->db_name . '.from="' . $roofGarden . '"' : '';
        $channelid = isset($channelid) && !empty($channelid) ? '  and ' . $this->db_name . '.channelid="' . $channelid . '"' : '';
        $appid = isset($appid) && !empty($appid) ? '  and ' . $this->db_name . '.appid="' . $appid . '"' : '';
        $sql = "select  date_format(FROM_UNIXTIME(logintime),'%Y-%m-%d') as date,COUNT(distinct(userid)) as sum from loginrecord where logintime >= '$starttime' and logintime <='$endtime'" . $roofGarden . $channelid . $appid . "  group by date_format(FROM_UNIXTIME(logintime),'%Y-%m-%d') order by FROM_UNIXTIME(logintime) desc";
        $result = $this->db->query($sql)->result_array();
        $this->db->close();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 查询时间区间内每个渠道所有登录的人数
     * @param string  $starttime      查询的开始时间
     * @param string $endtime    查询的结束时间
     * @param string $roofGarden    要查询的平台
     * @param string $channelid 要查询的渠道信息
     * @return array 查询刚注册的人数数据
     */
    public function findChannelIngoing($starttime, $endtime, $roofGarden, $channelid) {
        $roofGarden = isset($roofGarden) && !empty($roofGarden) ? '  and ' . $this->db_name . '.from="' . $roofGarden . '"' : '';
        $channelid = isset($channelid) && !empty($channelid) ? '  and ' . $this->db_name . '.channelid="' . $channelid . '"' : '';
        $sql = "select channelid,  COUNT(distinct(userid)) as huoyuerenshu  from " . $this->db_name . " where logintime >= " . $starttime . " and logintime <= " . $endtime . $roofGarden . $channelid . "  group by channelid";
        $result = $this->db->query($sql)->result_array();
        $this->db->close();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 查询指定用户最后的登录时间
     * @param string $list_uid 要查询用户id
     * @return array 用户id和用户最后的登录时间
     */
    public function lastlyLongintime($list_uid) {
        $sql = "select userid, MAX(logintime) as logintime from " . $this->db_name . " where userid in (" . $list_uid . ")  group by userid";
        $result = $this->db->query($sql)->result_array();
        $this->db->close();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

}
