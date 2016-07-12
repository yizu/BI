<?php

/**
 * Project:     乐恒互动BI系统
 * File:        Channel_service.php
 *
 * <pre>
 * 描述  处理渠道相关业务（成功返回数据失败返回失败状态）
 * </pre>
 *
 * @package application
 * @subpackage service
 * @author 刘训鹏 <1352345519@qq.com>
 * @copyright 2015 JoyBI 
 */
class Channel_service extends MY_Service {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('Channel_model');
        $this->load->model('UserRegister_model');
        $this->load->model('Loginrecord_model');
        $this->load->model('Paylog_model');
    }

    /**
     * 查找渠道数据
     * @return array 渠道数据（渠道id和渠道名）；
     */
    public function findChanneldata() {
        $result = $this->Channel_model->findChanneldata();
        if ($result) {
            return $result;
        } else {
            return '';
        }
    }

    /**
     * 查询渠道新进排行
     * @param string  $starttime      查询的开始时间
     * @param string $endtime    查询的结束时间
     * @param string $roofGarden    要查询的平台
     * @param string $channelid 要查询的渠道信息
     * @return array 查询新进排行数据
     */
    public function findChannelIngoing($starttime, $endtime, $roofGarden, $channelid, $appid) {
        $starttime = strtotime($starttime);
        $endtime = strtotime($endtime);
        //渠道用户每天注册信息
        $result = $this->Channel_model->findChanneldata();
        $userlist = $this->UserRegister_model->findChannelIngoing($starttime, $endtime, $roofGarden, $channelid, $appid);

        $loginlist = $this->Loginrecord_model->findChannelIngoing($starttime, $endtime, $roofGarden, $channelid, $appid);
        foreach ($result as $key => $res) {
            $channellist[$res['channelid']] = $res['channelname'];
        }
        if ($userlist && $loginlist) {
            if (count($userlist) == 1 && count($loginlist) == 1 && !empty($channelid)) {
                $channelarray[$channellist[$userlist[0]['channelid']]] = array_merge($userlist[0], $loginlist[0]);
                $channelarray[$channellist[$userlist[0]['channelid']]]['channelid'] = $channellist[$userlist[0]['channelid']];
            } else {
                foreach ($loginlist as $list) {
                    $login[$list['channelid']] = $list['huoyuerenshu'];
                }
                foreach ($userlist as $list) {
                    $user[$list['channelid']] = $list['zhucerenshu'];
                }

                foreach ($channellist as $key => $list) {
                    if (array_key_exists($key, $login)) {
                        $channelarray[$channellist[$key]]['huoyuerenshu'] = $login[$key];
                        $channelarray[$channellist[$key]]['channelid'] = $channellist[$key];
                    } else {
                        $channelarray[$channellist[$key]]['channelid'] = $channellist[$key];
                        $channelarray[$channellist[$key]]['huoyuerenshu'] = '0';
                    }
                    if (array_key_exists($key, $user)) {
                        $channelarray[$channellist[$key]]['zhucerenshu'] = $user[$key];
                    } else {
                        $channelarray[$channellist[$key]]['zhucerenshu'] = '0';
                    }
                }
            }
        } else {
            if (count($userlist) == 1 && count($loginlist) == 1 && !empty($channelid)) {
                $channelarray[$channellist[$channelid]]['channelid'] = $channellist[$channelid];
                $channelarray[$channellist[$channelid]]['huoyuerenshu'] = '0';
                $channelarray[$channellist[$channelid]]['zhucerenshu'] = '0';
            } else {
                foreach ($channellist as $key => $res) {
                    $channelarray[$channellist[$key]]['channelid'] = $channellist[$key];
                    $channelarray[$channellist[$key]]['huoyuerenshu'] = '0';
                    $channelarray[$channellist[$key]]['zhucerenshu'] = '0';
                }
            }
        }
        foreach ($channelarray as $i => $res) {
            foreach ($channelarray as $j => $re) {
                if ($channelarray[$i]['huoyuerenshu'] > $channelarray[$j]['huoyuerenshu']) {
                    $temp = $channelarray[$i];
                    $channelarray[$i] = $channelarray[$j];
                    $channelarray[$j] = $temp;
                }
            }
        }
        return $channelarray;
    }

    /**
     * 查询渠道收入排行
     * @param string  $starttime      查询的开始时间
     * @param string $endtime    查询的结束时间
     * @param string $roofGarden    要查询的平台
     * @param string $channelid 要查询的渠道信息
     * @return array 查询新进排行数据
     */
    public function findchannelEarning($starttime, $endtime, $roofGarden, $channelid) {
        $starttime = strtotime($starttime);
        $endtime = strtotime($endtime);
        $result = $this->Channel_model->findChanneldata();
        //获取渠道收入排行数据
        $channelEarningArray = $this->Paylog_model->findchannelEarning($starttime, $endtime, $roofGarden, $channelid);
        foreach ($result as $key => $res) {
            $channellist[$res['channelid']] = $res['channelname'];
        }
        if ($channelEarningArray) {
            if (count($channelEarningArray) && !empty($channelid)) {
                
                $channelarray[$channellist[$channelEarningArray[0]['channelid']]] = $channelEarningArray[0];
                $channelarray[$channellist[$channelEarningArray[0]['channelid']]]['arppu'] = $channelEarningArray[0]['zongjia'] / $channelEarningArray[0]['number'];
                $channelarray[$channellist[$channelEarningArray[0]['channelid']]]['channelid'] = $channellist[$channelEarningArray[0]['channelid']];
            } else {
                //把渠道排行变为以渠道为下标的数组
                foreach ($channelEarningArray as $list) {
                    $user[$list['channelid']]['number'] = $list['number'];
                    $user[$list['channelid']]['zongjia'] = $list['zongjia'];
                    $user[$list['channelid']]['arppu'] = round($list['zongjia'] / $list['number'], 2);
                    $user[$list['channelid']]['channelid']=$channellist[$list['channelid']];
                }
                //判断
                foreach ($channellist as $key => $list) {
                    if (array_key_exists($key, $user)) {
                        $channelarray[$channellist[$key]]['channelid'] = $channellist[$key];
                        $channelarray[$channellist[$key]] = $user[$key];
                    } else {
                        $channelarray[$channellist[$key]]['channelid'] = $channellist[$key];
                        $channelarray[$channellist[$key]]['number'] = '0';
                        $channelarray[$channellist[$key]]['zongjia'] = '0';
                        $channelarray[$channellist[$key]]['arppu'] = '0';
                    }
                }
            }

        } else {
            if (count($channelEarningArray) == 1 && !empty($channelid)) {
                $channelarray[$channellist[$channelid]]['channelid'] = $channellist[$channelid];
                $channelarray[$channellist[$channelid]]['number'] = '0';
                $channelarray[$channellist[$channelid]]['zongjia'] = '0';
                $channelarray[$channellist[$channelid]]['arppu'] = '0';
            } else {
                foreach ($channellist as $key => $res) {
                    $channelarray[$channellist[$key]]['channelid'] = $channellist[$key];
                    $channelarray[$channellist[$key]]['number'] = '0';
                    $channelarray[$channellist[$key]]['zongjia'] = '0';
                    $channelarray[$channellist[$key]]['arppu'] = '0';
                }
            }
        }
        //利用冒泡排序对数组进行排序
        foreach ($channelarray as $i => $res) {
            foreach ($channelarray as $j => $re) {
                if ($channelarray[$i]['zongjia']>$channelarray[$j]['zongjia']) {
                    $temp = $channelarray[$i];
                    $channelarray[$i] = $channelarray[$j];
                    $channelarray[$j] = $temp;
                }
            }
        }
        return $channelarray;
    }

}
