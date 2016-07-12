<?php

/**
 * Project:     乐恒互动BI系统
 * File:        Paylog_model.php
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
class Paylog_model extends CI_Model {

    /**
     * 数据库表名
     * 
     * @var array
     */
    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('joy_user_1', true);
        $this->db_name = "paylog";
    }

    /**
     * 查询时间区间内每天所付款的人数和每天的付款总金额
     * @param string  $starttime      查询的开始时间
     * @param string $endtime    查询的结束时间
     * @param string $roofGarden    要查询的平台
     * @param string $channelid 要查询的渠道信息
     * @return array 查询刚注册的人数数据
     */
    public function PaymentNumber($starttime, $endtime, $roofGarden, $channelid, $appid) {
        $roofGarden ='';
        $channelid = isset($channelid) && !empty($channelid) ? '  and ' . $this->db_name . '.channelid="' . $channelid . '"' : '';
        $appid = isset($appid) && !empty($appid) ? '  and ' . $this->db_name . '.appid="' . $appid . '"' : '';
        $sql = "select date_format(FROM_UNIXTIME(create_time),'%Y-%m-%d') as date,COUNT(distinct(uid))as number,sum(total_fee) as total_fee from " . $this->db_name . " where unix_timestamp(date_format(FROM_UNIXTIME(create_time),'%Y-%m-%d')) >= unix_timestamp(date('" . $starttime . "')) and unix_timestamp(date_format(FROM_UNIXTIME(create_time),'%Y-%m-%d')) <= unix_timestamp(date('" . $endtime . "')) and status=1 " . $roofGarden . $channelid . "group by date_format(FROM_UNIXTIME(create_time),'%Y-%m-%d') order by FROM_UNIXTIME(create_time) desc";
        $result = $this->db->query($sql)->result_array();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 查询平台概览里面的付费人数和收入总额
     * @param string  $starttime      查询的开始时间
     * @param string $endtime    查询的结束时间
     * @return array
     */
    public function getPayLogInfo($starttime, $endtime) {

        $sql = "select  date_format(FROM_UNIXTIME(create_time),'%Y-%m-%d') as paytime,COUNT(distinct(uid))as paynum,sum(total_fee) as 
                totalfee from " . $this->db_name . " 
                where unix_timestamp(date_format(FROM_UNIXTIME(create_time),'%Y-%m-%d')) >= unix_timestamp(date('$starttime')) and 
                unix_timestamp(date_format(FROM_UNIXTIME(create_time),'%Y-%m-%d')) <= unix_timestamp(date('$endtime')) and status=1 
                group by date_format(FROM_UNIXTIME(create_time),'%Y-%m-%d') ";

        $result = $this->db->query($sql)->result_array();
        $this->db->close();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 查询平台概览里面的付费人数和收入总额 (按月统计)
     * @param string  $starttime      查询的开始时间
     * @param string $endtime    查询的结束时间
     * @return array
     */
    public function getPayLogInfoByMonth($starttime, $endtime) {

        $sql = "select  date_format(FROM_UNIXTIME(create_time),'%Y-%m') as paytime,COUNT(distinct(uid))as paynum,sum(total_fee) as 
                totalfee from " . $this->db_name . " 
                where unix_timestamp(date_format(FROM_UNIXTIME(create_time),'%Y-%m-%d')) >= unix_timestamp(date('$starttime')) and 
                unix_timestamp(date_format(FROM_UNIXTIME(create_time),'%Y-%m-%d')) <= unix_timestamp(date('$endtime')) and status=1 
                group by date_format(FROM_UNIXTIME(create_time),'%Y-%m') ";

        $result = $this->db->query($sql)->result_array();
        $this->db->close();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 查询时间区间内新增付费人数
     * @param string  $starttime      查询的开始时间
     * @param string $endtime         查询的结束时间
     * @param string $type            平台类型
     * @return array 查询刚注册的人数数据
     */
    public function getNewPayNum($time, $pingtai, $channelid, $appid) {
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
        $timeafteroneday = date('Y-m-d', strtotime($time) + 86400);
        $sql = "select date_format(FROM_UNIXTIME(user_register.tokentime),'%Y-%m-%d') as date, COUNT(DISTINCT(user_register.id)) as number
                from user_register inner join user_register_other on user_register.id = user_register_other.uid
                where user_register.tokentime >= unix_timestamp(date('$time')) and user_register.tokentime < unix_timestamp(date('$timeafteroneday'))".$channelid . $pingtai . $appid ." 
                AND user_register.id in (
                select uid from paylog where STATUS = 1 AND unix_timestamp(date_format(FROM_UNIXTIME(create_time),'%Y-%m-%d')) >= unix_timestamp(date('$time')) and unix_timestamp(date_format(FROM_UNIXTIME(create_time),'%Y-%m-%d')) < unix_timestamp(date('$timeafteroneday'))
                )";
        $result = $this->db->query($sql)->row_array();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 查询时间区间内不同渠道的收入排行
     * @param string  $starttime      查询的开始时间
     * @param string $endtime    查询的结束时间
     * @param string $roofGarden    要查询的平台
     * @param string $channelid 要查询的渠道信息
     * @return array 渠道排行数据
     */
    public function findchannelEarning($starttime, $endtime, $roofGarden, $channelid) {
        $roofGarden = '';
        $channelid = isset($channelid) && !empty($channelid) ? '  and ' . $this->db_name . '.channelid="' . $channelid . '"' : '';
        $sql = "select channelid,sum(total_fee) as  zongjia,COUNT(distinct uid) as number from " . $this->db_name . " where create_time >= " . $starttime . " and create_time <= " . $endtime . $roofGarden . $channelid . " and status=1 group by channelid  order by zongjia desc";
        $result = $this->db->query($sql)->result_array();
        $this->db->close();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 查询时间区间内每天付费用户的付费习惯
     * @param string  $starttime      查询的开始时间
     * @param string $endtime    查询的结束时间
     * @param string $roofGarden    要查询的平台
     * @param string $channelid 要查询的渠道信息
     * @return array 付费数据
     */
    public function findPaymentFee($starttime, $endtime, $roofGarden, $channelid,$appid) {
        $roofGarden='';
        $channelid = isset($channelid) && !empty($channelid) ? '  and ' . $this->db_name . '.channelid="' . $channelid . '"' : '';
        $appid = isset($appid) && !empty($appid) ? '  and ' . $this->db_name . '.appid="' . $appid . '"' : '';
        $sql = "select date_format(FROM_UNIXTIME(create_time),'%Y-%m-%d') as create_time,payname,count(distinct uid) as people,count(uid) as degree,sum(total_fee) as  zongjia  from " . $this->db_name . " where create_time >= " . $starttime . " and create_time <= " . $endtime .$channelid.$appid. " and status=1 GROUP BY date_format(FROM_UNIXTIME(create_time),'%Y-%m-%d'),payname";
        $result = $this->db->query($sql)->result_array();
        $this->db->close();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 查询时间区间内二次付费人数
     * @param string  $starttime      查询的开始时间
     * @param string $endtime    查询的结束时间
     * @param string $roofGarden    要查询的平台
     * @param string $channelid 要查询的渠道信息
     * @return array 二次付费人数
     */
    public function getTwoPayment($starttime, $endtime, $roofGarden, $channelid, $appid) {
        $roofGarden = isset($roofGarden) && !empty($roofGarden) ? '  and ' . $this->db_name . '.from="' . $roofGarden . '"' : '';
        $channelid = isset($channelid) && !empty($channelid) ? '  and ' . $this->db_name . '.channelid="' . $channelid . '"' : '';
        $appid = isset($appid) && !empty($appid) ? '  and ' . $this->db_name . '.appid="' . $appid . '"' : '';
        $sql = "select  uid  from " . $this->db_name . " where create_time >= " . $starttime . " and create_time <= " . $endtime . $channelid . $appid . " and status=1 group by uid having count(uid)>=2";
        $result = $this->db->query($sql)->result_array();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 查询时间区间内付费人数
     * @param string  $starttime      查询的开始时间
     * @param string $endtime    查询的结束时间
     * @param string $roofGarden    要查询的平台
     * @param string $channelid 要查询的渠道信息
     * @return array 付费人数
     */
    public function getPayment($starttime, $endtime, $roofGarden, $channelid, $appid) {
        $roofGarden = isset($roofGarden) && !empty($roofGarden) ? '  and ' . $this->db_name . '.from="' . $roofGarden . '"' : '';
        $channelid = isset($channelid) && !empty($channelid) ? '  and ' . $this->db_name . '.channelid="' . $channelid . '"' : '';
        $appid = isset($appid) && !empty($appid) ? '  and ' . $this->db_name . '.appid="' . $appid . '"' : '';
        $sql = "select count(distinct uid) as uid from " . $this->db_name . " where create_time >= " . $starttime . " and create_time <= " . $endtime . " and status=1 " . $channelid . $appid;
        $result = $this->db->query($sql)->row_array();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 查询用户付费到查询结束时间前100名用户和用户付费总金额
     * @param string $endtime    查询的结束时间
     * @param string $roofGarden    要查询的平台
     * @return array 前100名用户id 和用户付费总金额
     */
    public function findCetaceanUser($endtime) {

        $sql = "select uid,sum(total_fee) as total_fee from " . $this->db_name . " where create_time <= " . $endtime . " and status=1 group by uid order by sum(total_fee) desc limit 0,100";
        $result = $this->db->query($sql)->result_array();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 查询时间区间内道具名称，销售的个数，销售单价，销售总额等
     * @param string  $starttime      查询的开始时间
     * @param string $endtime    查询的结束时间
     * @param string $pingtai    平台 （安卓或者IOS） 现在支付数据只有安卓平台
     * @param string $channelid 要查询的渠道信息
     * @param string $appid  游戏id
     * @return array 付费人数
     */
    public function getPropData($starttime, $pingtai, $channelid, $appid) {
        $endtime= date('Y-m-d',strtotime($starttime)+24*60*60);
        if (isset($channelid) && $channelid != "") {
            $channelid = " and channelid='$channelid'";
        } else {
            $channelid = "";
        }
        //此处先预留IOS平台统计
        if (isset($pingtai) && $pingtai != "") {
            $pingtai = "";
        } else {
            $pingtai = "";
        }
        //区分不同游戏（不同游戏传过来的appid值不同）
        if (isset($appid) && $appid != "") {
            $appid = " and appid='$appid'";
        } else {
            $appid = "";
        }
        $sql = "select date_format(FROM_UNIXTIME(create_time),'%Y-%m-%d') as create_time, body, COUNT(body) as number, total_fee ,SUM(total_fee) as sumfee from paylog
                where unix_timestamp(date_format(FROM_UNIXTIME(create_time),'%Y-%m-%d')) >= unix_timestamp(date('$starttime')) and 
                unix_timestamp(date_format(FROM_UNIXTIME(create_time),'%Y-%m-%d')) < unix_timestamp(date('$endtime')) and status=1 ".$channelid . $pingtai . $appid ." 
                group by  body";
        $result = $this->db->query($sql)->result_array();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
    
    
    /**
     * 查询时间区间内首次付费人数
     * @param string  $starttime      查询的开始时间
     * @param string $endtime         查询的结束时间
     * @param string $type            平台类型
     * @return array 查询刚注册的人数数据
     */
    public function getPayNumFirst($time, $pingtai, $channelid, $appid) {
        if (isset($channelid) && $channelid != "") {
            $channelid = " and channelid='$channelid'";
        } else {
            $channelid = "";
        }
        //支付数据目前不区分平台，先保留字段
        $pingtai = "";
        //区分不同游戏（不同游戏传过来的appid值不同）
        if (isset($appid) && $appid != "") {
            $appid = " and appid='$appid'";
        } else {
            $appid = "";
        }
        $timeafteroneday = date('Y-m-d', strtotime($time) + 86400);
        $sql = "select date_format(FROM_UNIXTIME(create_time),'%Y-%m-%d') as date,  COUNT(DISTINCT(uid)) as number from paylog 
            where STATUS = 1 AND unix_timestamp(date_format(FROM_UNIXTIME(create_time),'%Y-%m-%d')) >= unix_timestamp(date('$time')) 
            and unix_timestamp(date_format(FROM_UNIXTIME(create_time),'%Y-%m-%d')) < unix_timestamp(date('$timeafteroneday')) ".$channelid . $pingtai . $appid ." 
            and uid not in(select uid from paylog 
            where unix_timestamp(date_format(FROM_UNIXTIME(create_time),'%Y-%m-%d')) < unix_timestamp(date('$time')))";
        $result = $this->db->query($sql)->row_array();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

}
