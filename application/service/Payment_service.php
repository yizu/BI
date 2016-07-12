<?php

/**
 * Project:     乐恒互动BI系统
 * File:        Payment_service.php
 *
 * <pre>
 * 描述  处理收入相关业务（成功返回数据失败返回失败状态）
 * </pre>
 *
 * @package application
 * @subpackage service
 * @author 刘训鹏 <1352345519@qq.com>
 * @copyright 2015 JoyBI 
 */
class Payment_service extends MY_Service {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('Paylog_model');
        $this->load->model('Channel_model');
        $this->load->model('Paylist_model');
    }

    //付费习惯
    public function findPaymentFee($starttime, $endtime, $roofGarden, $channelid, $appid) {
        $starttime = strtotime($starttime);
        $endtime = strtotime($endtime);
        $paymentFee = $this->Paylog_model->findPaymentFee($starttime, $endtime, $roofGarden, $channelid, $appid);
        $paylist = $this->Paylist_model->findPaylist();
        if ($paylist) {
            if ($paymentFee) {
                foreach ($paymentFee as $key => $plist) {
                    $paymentFee[$plist['create_time']][$plist['payname']] = $plist;
                    unset($paymentFee[$key]);
                }
                while ($starttime <= $endtime) {
                    if (isset($paymentFee[date('Y-m-d', $starttime)])) {
                        foreach ($paylist as $pay) {
                            if (!isset($paymentFee[date('Y-m-d', $starttime)][$pay['payname']])) {
                                $paymentFee[date('Y-m-d', $starttime)][$pay['payname']]['create_time'] = date('Y-m-d', $starttime);
                                $paymentFee[date('Y-m-d', $starttime)][$pay['payname']]['payname'] = $pay['payname'];
                                $paymentFee[date('Y-m-d', $starttime)][$pay['payname']]['degree'] = '-';
                                $paymentFee[date('Y-m-d', $starttime)][$pay['payname']]['people'] = '-';
                                $paymentFee[date('Y-m-d', $starttime)][$pay['payname']]['zongjia'] = '-';
                            }
                        }
                    } else {
                        foreach ($paylist as $key => $list) {
                            $paymentFee[date('Y-m-d', $starttime)][$list['payname']]['create_time'] = date('Y-m-d', $starttime);
                            $paymentFee[date('Y-m-d', $starttime)][$list['payname']]['payname'] = $list['payname'];
                            $paymentFee[date('Y-m-d', $starttime)][$list['payname']]['degree'] = '-';
                            $paymentFee[date('Y-m-d', $starttime)][$list['payname']]['people'] = '-';
                            $paymentFee[date('Y-m-d', $starttime)][$list['payname']]['zongjia'] = '-';
                        }
                    }
                    $starttime = $starttime + 24 * 60 * 60;
                }
                ksort($paymentFee);
                foreach ($paymentFee as $key => $list) {
                    foreach ($list as $ke => $pay) {
                        $paymentFee[] = $pay;
                    }
                    unset($paymentFee[$key]);
                }
                return $paymentFee;
            } else {
                while ($starttime <= $endtime) {

                    foreach ($paylist as $key => $list) {
                        $PaymentFeelist[date('Y-m-d', $starttime)][$list['payname']]['create_time'] = date('Y-m-d', $starttime);
                        $PaymentFeelist[date('Y-m-d', $starttime)][$list['payname']]['payname'] = $list['payname'];
                        $PaymentFeelist[date('Y-m-d', $starttime)][$list['payname']]['degree'] = '-';
                        $PaymentFeelist[date('Y-m-d', $starttime)][$list['payname']]['people'] = '-';
                        $PaymentFeelist[date('Y-m-d', $starttime)][$list['payname']]['zongjia'] = '-';
                    }
                    $starttime = $starttime + 24 * 60 * 60;
                }
                foreach ($PaymentFeelist as $key => $list) {
                    foreach ($list as $ke => $pay) {
                        $PayFeelist[] = $pay;
                    }
                }
                return $PayFeelist;
            }
        } else {
            return false;
        }
    }

    //新增付费用户数
    public function getNewPayUser($starttime, $endtime, $channelid, $appid) {

        $resultArray = array();

        for ($i = strtotime($starttime); $i <= strtotime($endtime); $i += 86400) {
            $dateArray[] = date("Y-m-d", $i);
        }
        //获取付费用户数和充值金额
        $payInfo = $this->Paylog_model->PaymentNumber($starttime, $endtime, '', $channelid, $appid);
        if (isset($payInfo) && is_array($payInfo)) {
            $payInfo = array_column($payInfo, 'number', 'date');
            $payFee = array_column($payInfo, 'total_fee', 'date');
            foreach ($dateArray as $key => $value) {
                if (array_key_exists($value, $payInfo)) {
                    $resultArray[$key]['time'] = $dateArray[$key];
                    $resultArray[$key]['number'] = $payInfo[$value];
                } else {
                    $resultArray[$key]['time'] = $dateArray[$key];
                    $resultArray[$key]['number'] = '-';
                }
                if (array_key_exists($value, $payFee)) {
                    $resultArray[$key]['time'] = $dateArray[$key];
                    $resultArray[$key]['total_fee'] = $payFee[$value];
                } else {
                    $resultArray[$key]['time'] = $dateArray[$key];
                    $resultArray[$key]['total_fee'] = '-';
                }
            }
        } else {
            foreach ($dateArray as $key => $value) {
                $resultArray[$key]['time'] = $dateArray[$key];
                $resultArray[$key]['number'] = '-';
                $resultArray[$key]['total_fee'] = '-';
            }
        }
        //获取每天新增付费用户的人数
        foreach ($dateArray as $key => $value) {
            $payInfo[] = $this->Paylog_model->getPayNumFirst($value, '', $channelid, $appid);
        }
        if (isset($payInfo) && is_array($payInfo)) {
            $paycount = array_column($payInfo, 'number', 'date');
            foreach ($dateArray as $key => $value) {
                if (array_key_exists($value, $paycount)) {
                    $resultArray[$key]['time'] = $dateArray[$key];
                    $resultArray[$key]['paycount'] = $paycount[$value];
                } else {
                    $resultArray[$key]['time'] = $dateArray[$key];
                    $resultArray[$key]['paycount'] = '-';
                }
            }
        } else {
            foreach ($dateArray as $key => $value) {
                $resultArray[$key]['time'] = $dateArray[$key];
                $resultArray[$key]['paycount'] = '-';
            }
        }

        //计算留存率
        foreach ($resultArray as $key => $value) {
            if (isset($resultArray[$key]['paycount']) && $resultArray[$key]['paycount'] != '-' && isset($resultArray[$key]['total_fee']) && $resultArray[$key]['total_fee'] != '-') {
                $resultArray[$key]['arppu'] = round($resultArray[$key]['total_fee'] / $resultArray[$key]['paycount'] ,2)*'100' . '%';
            } else {
                $resultArray[$key]['arppu'] = '-';
            }
            $resultArray[$key]['pingtai'] = '全平台';
        }
        return $resultArray;
    }

    //商品道具销售
    public function getPropData($starttime, $pingtai, $channelid, $appid) {
        $pingtai= empty($pingtai)?'全部':$pingtai;
        //查询时间区间内道具名称，销售的个数，销售单价，销售总额等
        $propInfo = $this->Paylog_model->getPropData($starttime, $pingtai, $channelid, $appid);
        //通过渠道ID获取渠道名称
        if (!empty($channelid)) {
            $channelName = $this->Channel_model->getChannelNameByid($channelid);
        }else{
            $channelName['channelname']="全部";
        }

        if (isset($propInfo) && is_array($propInfo)) {
            foreach ($propInfo as $key => $value) {
                $propInfo[$key]['pingtai'] = $pingtai;
                $propInfo[$key]['channelname'] = $channelName['channelname'];
            }
            return $propInfo;
        } else {
            return "";
        }
    }

    //二次付费用户数
    public function getTwoPayment($starttime, $endtime, $roofGarden, $channelid, $appid) {
        $starttime = strtotime($starttime);
        $endtime = strtotime($endtime);
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
        $result = $this->Paylog_model->getPayment($starttime, $endtime, $roofGarden, $channelid, $appid);
        $list = $this->Paylog_model->getTwoPayment($starttime, $endtime, $roofGarden, $channelid, $appid);
        if ($result && $list) {

            $twopaymentlist['time'] = date('Y-m-d', $starttime) . '-----' . date('Y-m-d', $endtime);
            $twopaymentlist['ercifufei'] = !empty($list) ? count($list) : '-';
            $twopaymentlist['fufeirenshu'] = !empty($result) ? $result['uid'] : "-";
            $twopaymentlist['pingtai'] = $roofGardenname;
            $twopaymentlist['qudao'] = $channelname;
            if (!empty($list) && !empty($result)) {
                $twopaymentlist['zhanbi'] = round($twopaymentlist['ercifufei'] / $result['uid'], 2) * '100' . '%';
            } else {
                $twopaymentlist['zhanbi'] = '-';
            }
            return $twopaymentlist;
        } else {
            return false;
        }
    }

}
