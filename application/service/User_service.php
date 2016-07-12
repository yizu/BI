<?php

/**
 * Project:     乐恒互动BI系统
 * File:        User_service.php
 *
 * <pre>
 * 描述  处理用户相关业务（成功返回数据失败返回失败状态）
 * </pre>
 *
 * @package application
 * @subpackage service
 * @author 刘训鹏 <1352345519@qq.com>
 * @copyright 2015 JoyBI 
 */
class User_service extends MY_Service {

    public function __construct() {
        parent::__construct();
        $this->load->model('Loginrecord_model');
        $this->load->model('userRegister_model');
        $this->load->model('Paylog_model');
        $this->load->model('Channel_model');
    }

    /**
     * 查询时间区间内查找活跃用户
     * @param string  $starttime      查询的开始时间
     * @param string $endtime    查询的结束时间
     * @param string $roofGarden    要查询的平台
     * @param string $channelid 要查询的渠道信息
     * @return array 时间区间内查找活跃用户人数数据
     */
    public function findactiveUser($starttime, $endtime, $roofGarden, $channelid, $appid) {
        //实例化结束时间
        $starttime = strtotime($starttime);
        $weekendtime = strtotime($endtime);
        //获取查询的渠道和平台数据
        if (!empty($channelid)) {
            $result = $this->Channel_model->findChanneldata();
            foreach ($result as $key => $res) {
                $channel[$res['channelid']] = $res['channelname'];
            }
            $channelname = $channel[$channelid];
        } else {
            $channelname = '全部';
        }
        if (!empty($roofGarden)) {
            $roofGardenname = $roofGarden;
        } else {
            $roofGardenname = '全部';
        }
        //获取日活跃用户
        $dayactivist = $this->Loginrecord_model->getDayactivist($starttime, $weekendtime, $roofGarden, $channelid, $appid);
        //把日活跃用户变成一个以时间为下标的多为数组
        if ($dayactivist) {
            foreach ($dayactivist as $key => $day) {
                $daylist[strtotime($day['date'])] = $day['sum'];
            }
        }
        while ($starttime < $weekendtime + 86400) {
            //整理日活跃用户
            if ($dayactivist) {
                if (isset($daylist[$starttime])) {
                    $data[date('Y-m-d', $starttime)]['day'] = $daylist[$starttime];
                } else {
                    $data[date('Y-m-d', $starttime)]['day'] = '-';
                }
            } else {
                $data[date('Y-m-d', $starttime)]['day'] = '-';
            }
            $data[date('Y-m-d', $starttime)]['channel'] = $channelname;
            $data[date('Y-m-d', $starttime)]['roofGarden'] = $roofGardenname;
            //获取周活跃用户数据
            $weekctivist = $this->Loginrecord_model->findWeekactivist(strtotime('-1 week', $starttime), $starttime, $roofGarden, $channelid, $appid);
            $data[date('Y-m-d', $starttime)]['week'] = $weekctivist && !empty($weekctivist) && $weekctivist['sum'] != 0 ? $weekctivist['sum'] : '-';
            //获取月活跃用户数据
            $monthctivist = $this->Loginrecord_model->findWeekactivist(strtotime('-1 month', $starttime), $starttime, $roofGarden, $channelid, $appid);
            $data[date('Y-m-d', $starttime)]['month'] = $monthctivist && !empty($monthctivist) && $monthctivist['sum'] != 0 ? $monthctivist['sum'] : '-';
            $starttime = $starttime + 24 * 60 * 60;
        }
        return $data;
    }

    /**
     * 查询时间区间内每天新进用户价值数据
     * @param string  $starttime      查询的开始时间
     * @param string $endtime    查询的结束时间
     * @param string $roofGarden    要查询的平台
     * @param string $channelid 要查询的渠道信息
     * @return array 时间区间内每天新进用户价值数据
     */
    public function findNewUserImportance($starttime, $endtime, $roofGarden, $channelid, $appid) {
        $day = (strtotime($endtime) - strtotime($starttime)) / (24 * 60 * 60);
        $userRegister = $this->userRegister_model->findEnrollment($starttime, $endtime, $roofGarden, $channelid, $appid);
        //把日活跃用户变成一个以时间为下标的多为数组
        if ($userRegister) {
            foreach ($userRegister as $key => $days) {
                $daylist[$days['date']] = $days['zhucerenshu'];
            }
        }
        //控制查询的时间区间在7天之内
        if ($day < 7) {
            //获取渠道数据
            if (isset($channelid) && !empty($channelid)) {
                $channel = $this->Channel_model->findChanneldata();
                foreach ($channel as $key => $res) {
                    $channel[$res['channelid']] = $res['channelname'];
                }
                $channelname = $channel[$channelid];
            } else {
                $channelname = '全部';
            }
            if (isset($roofGarden) && !empty($roofGarden)) {
                $roofGardenname = $roofGarden;
            } else {
                $roofGardenname = '全部';
            }
            $starttime = (int) strtotime($starttime);
            $endtime = (int) strtotime($endtime);
            //循环时间
            while ($starttime <= $endtime) {
                //7日内平均贡献
                $data = $this->userRegister_model->findNewUserImportance($starttime, $starttime + 6 * 24 * 60 * 60, $roofGarden, $channelid, $appid);
                $result[date('Y-m-d', $starttime)]['qitian'] =$data&&!empty($data['gongxian']) && isset($data['gongxian'])&&$daylist&&isset($daylist[date('Y-m-d', $starttime)])? round($data['gongxian']/$daylist[date('Y-m-d', $starttime)], 2) : '-';
                //14日内平均贡献
                $data = $this->userRegister_model->findNewUserImportance($starttime, $starttime + 13 * 24 * 60 * 60, $roofGarden, $channelid, $appid);

                $result[date('Y-m-d', $starttime)]['shisitian'] = $data&&!empty($data['gongxian']) && isset($data['gongxian']) && $daylist&&isset($daylist[date('Y-m-d', $starttime)])? round($data['gongxian']/$daylist[date('Y-m-d', $starttime)], 2) : '-';
                //30日内平均贡献
                $data = $this->userRegister_model->findNewUserImportance($starttime, $starttime + 29 * 24 * 60 * 60, $roofGarden, $channelid, $appid);
                $result[date('Y-m-d', $starttime)]['sanshitian'] =$data&&!empty($data['gongxian']) && isset($data['gongxian'])&&$daylist&&isset($daylist[date('Y-m-d', $starttime)])? round($data['gongxian']/$daylist[date('Y-m-d', $starttime)], 2) : '-';
                $data = $this->userRegister_model->findNewUserImportance($starttime, $starttime + 59 * 24 * 60 * 60, $roofGarden, $channelid, $appid);
                $result[date('Y-m-d', $starttime)]['liushitian'] = $data&&!empty($data['gongxian']) && isset($data['gongxian']) &&$daylist&&isset($daylist[date('Y-m-d', $starttime)])? round($data['gongxian']/$daylist[date('Y-m-d', $starttime)], 2) : '-';
                $result[date('Y-m-d', $starttime)]['channelname'] = $channelname;
                $result[date('Y-m-d', $starttime)]['roofGarden'] = $roofGardenname;
                $result[date('Y-m-d', $starttime)]['zhucerenshu'] = isset($daylist[date('Y-m-d', $starttime)]) ? $daylist[date('Y-m-d', $starttime)] : '-';
                $starttime = (int) $starttime + 24 * 60 * 60;
            }
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 查询时间区间前100名用户相关资料
     * @param string  $starttime      查询的开始时间
     * @param string $endtime    查询的结束时间
     * @param string $roofGarden    要查询的平台
     * @return array 时间区间内前100名用户的相关信息
     */
    public function findCetaceanUser($endtime, $roofGarden) {
        $endtime = strtotime($endtime);
        if (isset($roofGarden) && !empty($roofGarden)) {
            $roofGardenname = $roofGarden;
        } else {
            $roofGardenname = '全部';
        }
        //获取用户
        $result = $this->Paylog_model->findCetaceanUser($endtime);
        if ($result) {
            foreach ($result as $key => $res) {
                $list[] = $res['uid'];
                $result[$res['uid']]['total_fee'] = $res['total_fee'];
                unset($result[$key]);
            }
            //把￥数组处理成用逗号分开的uid字符串
            $uid = implode(',', $list);
            //获取用户名和用户注册时间
            $userlist = $this->userRegister_model->findUsername($uid);
            //获取用户最后登录时间
            $logintimelist = $this->Loginrecord_model->lastlyLongintime($uid);
            foreach ($userlist as $key => $user) {
                $userlist[$user['uid']]['tokentime'] = $user['tokentime'];
                if (!empty($userlist[$key]['username'])) {
                    $userlist[$user['uid']]['username'] = $user['username'];
                } else if (!empty($userlist[$key]['phone'])) {
                    $userlist[$user['uid']]['username'] = $user['phone'];
                } else {
                    $userlist[$user['uid']]['username'] = '';
                }
                unset($userlist[$key]);
            }
            foreach ($logintimelist as $key => $time) {
                $logintimelist[$time['userid']]['logintime'] = $time['logintime'];
                unset($logintimelist[$key]);
            }
            foreach ($result as $key => $res) {
                if (isset($userlist[$key]['tokentime'])) {
                    $result[$key]['tokentime'] = date('Y-m-d', $userlist[$key]['tokentime']);
                } else {
                    $result[$key]['tokentime'] = "";
                }
                $result[$key]['pingtai'] = $roofGardenname;
                if (isset($userlist[$key]['username'])) {
                    $result[$key]['username'] = $userlist[$key]['username'];
                } else {
                    $result[$key]['username'] = "";
                }
                if (isset($logintimelist[$key]['logintime'])) {
                    $result[$key]['logintime'] = date('Y-m-d', $logintimelist[$key]['logintime']);
                } else {
                    $result[$key]['logintime'] = "";
                }
            }
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 查询时间区间内查找每天日报
     * @param string  $starttime      查询的开始时间
     * @param string $endtime    查询的结束时间
     * @param string $roofGarden    要查询的平台
     * @param string $channelid 要查询的渠道信息
     * @return array 时间区间内每天日报人数数据
     */
    public function finddailyUser($starttime, $endtime, $roofGarden, $channelid, $appid) {
        $userRegister = $this->userRegister_model->findEnrollment($starttime, $endtime, $roofGarden, $channelid, $appid);
        $Paylog = $this->Paylog_model->PaymentNumber($starttime, $endtime, $roofGarden, $channelid, $appid);
        $starttime = strtotime($starttime);
        $endtime = strtotime($endtime);
        $dayactivist = $this->Loginrecord_model->getDayactivist($starttime, $endtime, $roofGarden, $channelid, $appid);
        for ($i = $starttime; $i <= $endtime; $i += 86400) {
            $userlist[date('Y-m-d', $i)] = '';
        }
        if ($Paylog && is_array($Paylog)) {
            if (empty($roofGarden) || $roofGarden == 'Android') {
                foreach ($Paylog as $key => $pay) {
                    $userlist[$pay['date']]['number'] = $pay['number'];
                    $userlist[$pay['date']]['total_fee'] = $pay['total_fee'];
                }
            }
        }

        if ($userRegister && is_array($userRegister)) {
            foreach ($userRegister as $key => $user) {
                $userlist[$user['date']]['zhucerenshu'] = $user['zhucerenshu'];
            }
        }
        if ($dayactivist && is_array($dayactivist)) {
            foreach ($dayactivist as $day) {
                $userlist[$day['date']]['huoyue'] = $day['sum'];
            }
        }

        if (!empty($channelid)) {
            $result = $this->Channel_model->findChanneldata();
            foreach ($result as $key => $res) {
                $channel[$res['channelid']] = $res['channelname'];
            }
            $channelname = $channel[$channelid];
        } else {
            $channelname = '全部';
        }
        if (!empty($roofGarden)) {
            $roofGardenname = $roofGarden;
        } else {
            $roofGardenname = '全部';
        }
        while ($starttime <= $endtime) {
            $userlist[date('Y-m-d', $starttime)]['date'] = date('Y-m-d', $starttime);
            $userlist[date('Y-m-d', $starttime)]['pingtai'] = $roofGardenname;
            $userlist[date('Y-m-d', $starttime)]['qudao'] = $channelname;
            if (isset($userlist[date('Y-m-d', $starttime)]['number']) && isset($userlist[date('Y-m-d', $starttime)]['huoyue']) && $userlist[date('Y-m-d', $starttime)]['number'] != 0 && $userlist[date('Y-m-d', $starttime)]['huoyue'] != 0) {
                $userlist[date('Y-m-d', $starttime)]['fufeishentou'] = round(($userlist[date('Y-m-d', $starttime)]['number'] / $userlist[date('Y-m-d', $starttime)]['huoyue'] * 100), 2) . '%';
            }
            if (isset($userlist[date('Y-m-d', $starttime)]['total_fee']) && isset($userlist[date('Y-m-d', $starttime)]['number']) && $userlist[date('Y-m-d', $starttime)]['number'] != 0 && $userlist[date('Y-m-d', $starttime)]['total_fee'] != 0) {
                $userlist[date('Y-m-d', $starttime)]['arppu'] = round($userlist[date('Y-m-d', $starttime)]['total_fee'] / $userlist[date('Y-m-d', $starttime)]['number'], 2);
            }
            if (isset($userlist[date('Y-m-d', $starttime)]['total_fee']) && isset($userlist[date('Y-m-d', $starttime)]['huoyue']) && $userlist[date('Y-m-d', $starttime)]['huoyue'] != 0 && $userlist[date('Y-m-d', $starttime)]['total_fee'] != 0) {
                $userlist[date('Y-m-d', $starttime)]['活跃arppu'] = round($userlist[date('Y-m-d', $starttime)]['total_fee'] / $userlist[date('Y-m-d', $starttime)]['huoyue'], 2);
            }
            if (!isset($userlist[date('Y-m-d', $starttime)]['number'])) {
                $userlist[date('Y-m-d', $starttime)]['number'] = '-';
            }
            if (!isset($userlist[date('Y-m-d', $starttime)]['total_fee'])) {
                $userlist[date('Y-m-d', $starttime)]['total_fee'] = '-';
            }
            if (!isset($userlist[date('Y-m-d', $starttime)]['zhucerenshu'])) {
                $userlist[date('Y-m-d', $starttime)]['zhucerenshu'] = '-';
            }
            if (!isset($userlist[date('Y-m-d', $starttime)]['huoyue'])) {
                $userlist[date('Y-m-d', $starttime)]['huoyue'] = '-';
            }
            if (!isset($userlist[date('Y-m-d', $starttime)]['活跃arppu'])) {
                $userlist[date('Y-m-d', $starttime)]['活跃arppu'] = '-';
            }
            if (!isset($userlist[date('Y-m-d', $starttime)]['fufeishentou'])) {
                $userlist[date('Y-m-d', $starttime)]['fufeishentou'] = '-';
            }
            if (!isset($userlist[date('Y-m-d', $starttime)]['arppu'])) {
                $userlist[date('Y-m-d', $starttime)]['arppu'] = '-';
            }

            $starttime = (int) $starttime + 24 * 60 * 60;
        }
        ksort($userlist);
        return $userlist;
    }

}