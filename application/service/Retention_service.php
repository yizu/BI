<?php

/**
 * Project:     乐恒互动BI数据统计后台
 * File:        Retention_service.php
 *
 * <pre>
 * 描述：留存数据业务层
 * </pre>
 *
 * @package application
 * @subpackage controller
 * @author 李杨 <768216362@qq.com>
 * @copyright 2016 BI, Inc.
 */
class Retention_service extends MY_Service {

    public function __construct() {
        parent::__construct();
        $this->load->model('UserRegister_model');
        $this->load->model('Loginrecord_model');
        $this->load->model('Paylog_model');
        $this->load->model('Channel_model');
    }

    //获取用户留存数据
    public function getRetentionAll($starttime, $endtime , $pingtai, $channelid, $appid) {
        //处理拼接参数
        if ($pingtai == 'all') {
            $pingtai = "";
        }
        $resultArray = array();

        for ($i = strtotime($starttime); $i <= strtotime($endtime); $i += 86400) {
            $dateArray[] = date("Y-m-d", $i);
        }
        //获取每天新增人数
        $registerInfo = $this->UserRegister_model->getRegisterCountBytime($starttime, $endtime, $pingtai,$channelid, $appid);
        if (isset($registerInfo) && is_array($registerInfo)) {
            $registercount = array_column($registerInfo, 'registercount', 'registertime');
            foreach ($dateArray as $key => $value) {
                if (array_key_exists($value, $registercount)) {
                    $resultArray[$key]['time'] = $dateArray[$key];
                    $resultArray[$key]['registercount'] = $registercount[$value];
                } else {
                    $resultArray[$key]['time'] = $dateArray[$key];
                    $resultArray[$key]['registercount'] = '-';
                }
            }
        } else {
            foreach ($dateArray as $key => $value) {
                $resultArray[$key]['time'] = $dateArray[$key];
                $resultArray[$key]['registercount'] = '-';
            }
        }
        //求次日留存登陆数
        foreach ($dateArray as $key => $value) {
            $followingRetention[] = $this->Loginrecord_model->getCiriRetention($value, $pingtai,$channelid, $appid);
        }
        if (isset($followingRetention) && is_array($followingRetention)) {
            $ciriRetention = array_column($followingRetention, 'ciriRetention', 'logintime');
            foreach ($dateArray as $key => $value) {
                if (array_key_exists($value, $ciriRetention)) {
                    $resultArray[$key]['time'] = $dateArray[$key];
                    $resultArray[$key]['ciriretention'] = $ciriRetention[$value];
                } else {
                    $resultArray[$key]['time'] = $dateArray[$key];
                    $resultArray[$key]['ciriretention'] = '-';
                }
            }
        } else {
            foreach ($dateArray as $key => $value) {
                $resultArray[$key]['time'] = $dateArray[$key];
                $resultArray[$key]['ciriretention'] = '-';
            }
        }
        //求三日留存的登陆数
        foreach ($dateArray as $key => $value) {
            $sanriRetention[] = $this->Loginrecord_model->getSanRiRetention($value,$pingtai,$channelid,$appid);
        }
        if (isset($sanriRetention) && is_array($sanriRetention)) {
            $sanriRetention = array_column($sanriRetention, 'sanriRetention', 'logintime');
            foreach ($dateArray as $key => $value) {
                if (array_key_exists($value, $sanriRetention)) {
                    $resultArray[$key]['time'] = $dateArray[$key];
                    $resultArray[$key]['sanriretention'] = $sanriRetention[$value];
                } else {
                    $resultArray[$key]['time'] = $dateArray[$key];
                    $resultArray[$key]['sanriretention'] = '-';
                }
            }
        } else {
            foreach ($dateArray as $key => $value) {
                $resultArray[$key]['time'] = $dateArray[$key];
                $resultArray[$key]['sanriretention'] = '-';
            }
        }
        
        //求7日留存的登陆数
        foreach ($dateArray as $key => $value) {
            $qiriRetention[] = $this->Loginrecord_model->getQiriRetention($value,$pingtai,$channelid,$appid);
        }
        if (isset($qiriRetention) && is_array($qiriRetention)) {
            $qiriRetention = array_column($qiriRetention, 'qiriRetention', 'logintime');
            foreach ($dateArray as $key => $value) {
                if (array_key_exists($value, $qiriRetention)) {
                    $resultArray[$key]['time'] = $dateArray[$key];
                    $resultArray[$key]['qiriretention'] = $qiriRetention[$value];
                } else {
                    $resultArray[$key]['time'] = $dateArray[$key];
                    $resultArray[$key]['qiriretention'] = '-';
                }
            }
        } else {
            foreach ($dateArray as $key => $value) {
                $resultArray[$key]['time'] = $dateArray[$key];
                $resultArray[$key]['qiriretention'] = '-';
            }
        }
        
        //求14日留存的登陆数
        foreach ($dateArray as $key => $value) {
            $shisiriRetention[] = $this->Loginrecord_model->getShisiriRetention($value,$pingtai,$channelid,$appid);
        }
        if (isset($shisiriRetention) && is_array($shisiriRetention)) {
            $shisiriRetention = array_column($shisiriRetention, 'shisiriRetention', 'logintime');
            foreach ($dateArray as $key => $value) {
                if (array_key_exists($value, $shisiriRetention)) {
                    $resultArray[$key]['time'] = $dateArray[$key];
                    $resultArray[$key]['shisiriRetention'] = $shisiriRetention[$value];
                } else {
                    $resultArray[$key]['time'] = $dateArray[$key];
                    $resultArray[$key]['shisiriRetention'] = '-';
                }
            }
        } else {
            foreach ($dateArray as $key => $value) {
                $resultArray[$key]['time'] = $dateArray[$key];
                $resultArray[$key]['shisiriRetention'] = '-';
            }
        }
        //求30日留存的登陆数
        foreach ($dateArray as $key => $value) {
            $sanshiriRetention[] = $this->Loginrecord_model->getSanshiriRetention($value,$pingtai,$channelid,$appid);
        }
        if (isset($sanshiriRetention) && is_array($sanshiriRetention)) {
            $sanshiriRetention = array_column($sanshiriRetention, 'sanshiriRetention', 'logintime');
            foreach ($dateArray as $key => $value) {
                if (array_key_exists($value, $sanshiriRetention)) {
                    $resultArray[$key]['time'] = $dateArray[$key];
                    $resultArray[$key]['sanshiriRetention'] = $sanshiriRetention[$value];
                } else {
                    $resultArray[$key]['time'] = $dateArray[$key];
                    $resultArray[$key]['sanshiriRetention'] = '-';
                }
            }
        } else {
            foreach ($dateArray as $key => $value) {
                $resultArray[$key]['time'] = $dateArray[$key];
                $resultArray[$key]['sanshiriRetention'] = '-';
            }
        }
        $channelName = $this->Channel_model->getChannelNameByid($channelid);
        //计算留存率
        foreach ($resultArray as $key => $value) {
            if (isset($resultArray[$key]['registercount']) && $resultArray[$key]['registercount'] != '-' && isset($resultArray[$key]['ciriretention']) && $resultArray[$key]['ciriretention'] != '-') {
                $resultArray[$key]['ciriretentionlv'] = round(($resultArray[$key]['ciriretention'] / $resultArray[$key]['registercount'] * 100), 2) . '%';
            } else {
                $resultArray[$key]['ciriretentionlv'] = '-';
            }
            if (isset($resultArray[$key]['registercount']) && $resultArray[$key]['registercount'] != '-' && isset($resultArray[$key]['sanriretention']) && $resultArray[$key]['sanriretention'] != '-') {
                $resultArray[$key]['sanriretentionlv'] = round(($resultArray[$key]['sanriretention'] / $resultArray[$key]['registercount']  * 100), 2) . '%';
            } else {
                $resultArray[$key]['sanriretentionlv'] = '-';
            }
            if (isset($resultArray[$key]['registercount']) && $resultArray[$key]['registercount'] != '-' && isset($resultArray[$key]['qiriretention']) && $resultArray[$key]['qiriretention'] != '-') {
                $resultArray[$key]['qiriretentionlv'] = round(($resultArray[$key]['qiriretention'] / $resultArray[$key]['registercount'] * 100), 2) . '%';
            } else {
                $resultArray[$key]['qiriretentionlv'] = '-';
            }
            if (isset($resultArray[$key]['registercount']) && $resultArray[$key]['registercount'] != '-' && isset($resultArray[$key]['shisiriRetention']) && $resultArray[$key]['shisiriRetention'] != '-') {
                $resultArray[$key]['shisiriretentionlv'] = round(($resultArray[$key]['shisiriRetention'] / $resultArray[$key]['registercount'] * 100), 2) . '%';
            } else {
                $resultArray[$key]['shisiriretentionlv'] = '-';
            }
            if (isset($resultArray[$key]['registercount']) && $resultArray[$key]['registercount'] != '-' && isset($resultArray[$key]['sanshiriRetention']) && $resultArray[$key]['sanshiriRetention'] != '-') {
                $resultArray[$key]['sanshiriRetentionlv'] = round(($resultArray[$key]['sanshiriRetention'] / $resultArray[$key]['registercount']* 100), 2) . '%';
            } else {
                $resultArray[$key]['sanshiriRetentionlv'] = '-';
            }
            if ($pingtai == "") {
                $resultArray[$key]['pingtai'] = '全平台';
            } else {
                $resultArray[$key]['pingtai'] = $pingtai;
            }
            $resultArray[$key]['channelname'] = $channelName['channelname'];
        }
        return $resultArray;
    }
  
    //获取用户留存数据
    public function getPayRetentionAll($starttime, $endtime , $pingtai, $channelid, $appid) {
        //处理拼接参数
        if ($pingtai == 'all') {
            $pingtai = "";
        }
        
        $resultArray = array();

        for ($i = strtotime($starttime); $i <= strtotime($endtime); $i += 86400) {
            $dateArray[] = date("Y-m-d", $i);
        }
        //获取首次付费用户的人数
        foreach ($dateArray as $key => $value) {
            $payInfo[] = $this->Paylog_model->getPayNumFirst($value, $pingtai, $channelid, $appid);
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
        //求次日留存登陆数
        foreach ($dateArray as $key => $value) {
            $followingRetention[] = $this->Loginrecord_model->getPayCiriRetention($value, $pingtai, $channelid, $appid);
        }
        if (isset($followingRetention) && is_array($followingRetention)) {
            $ciriRetention = array_column($followingRetention, 'ciriRetention', 'logintime');
            foreach ($dateArray as $key => $value) {
                if (array_key_exists($value, $ciriRetention)) {
                    $resultArray[$key]['time'] = $dateArray[$key];
                    $resultArray[$key]['ciriretention'] = $ciriRetention[$value];
                } else {
                    $resultArray[$key]['time'] = $dateArray[$key];
                    $resultArray[$key]['ciriretention'] = '-';
                }
            }
        } else {
            foreach ($dateArray as $key => $value) {
                $resultArray[$key]['time'] = $dateArray[$key];
                $resultArray[$key]['ciriretention'] = '-';
            }
        }
        //求三日留存的登陆数
        foreach ($dateArray as $key => $value) {
            $sanriRetention[] = $this->Loginrecord_model->getPaySanRiRetention($value, $pingtai, $channelid, $appid);
        }
        if (isset($sanriRetention) && is_array($sanriRetention)) {
            $sanriRetention = array_column($sanriRetention, 'sanriRetention', 'logintime');
            foreach ($dateArray as $key => $value) {
                if (array_key_exists($value, $sanriRetention)) {
                    $resultArray[$key]['time'] = $dateArray[$key];
                    $resultArray[$key]['sanriretention'] = $sanriRetention[$value];
                } else {
                    $resultArray[$key]['time'] = $dateArray[$key];
                    $resultArray[$key]['sanriretention'] = '-';
                }
            }
        } else {
            foreach ($dateArray as $key => $value) {
                $resultArray[$key]['time'] = $dateArray[$key];
                $resultArray[$key]['sanriretention'] = '-';
            }
        }
        
        //求7日留存的登陆数
        foreach ($dateArray as $key => $value) {
            $qiriRetention[] = $this->Loginrecord_model->getPayQiriRetention($value, $pingtai, $channelid, $appid);
        }
        if (isset($qiriRetention) && is_array($qiriRetention)) {
            $qiriRetention = array_column($qiriRetention, 'qiriRetention', 'logintime');
            foreach ($dateArray as $key => $value) {
                if (array_key_exists($value, $qiriRetention)) {
                    $resultArray[$key]['time'] = $dateArray[$key];
                    $resultArray[$key]['qiriretention'] = $qiriRetention[$value];
                } else {
                    $resultArray[$key]['time'] = $dateArray[$key];
                    $resultArray[$key]['qiriretention'] = '-';
                }
            }
        } else {
            foreach ($dateArray as $key => $value) {
                $resultArray[$key]['time'] = $dateArray[$key];
                $resultArray[$key]['qiriretention'] = '-';
            }
        }
        
        //求14日留存的登陆数
        foreach ($dateArray as $key => $value) {
            $shisiriRetention[] = $this->Loginrecord_model->getPayShisiriRetention($value, $pingtai, $channelid, $appid);
        }
        if (isset($shisiriRetention) && is_array($shisiriRetention)) {
            $shisiriRetention = array_column($shisiriRetention, 'shisiriRetention', 'logintime');
            foreach ($dateArray as $key => $value) {
                if (array_key_exists($value, $shisiriRetention)) {
                    $resultArray[$key]['time'] = $dateArray[$key];
                    $resultArray[$key]['shisiriretention'] = $shisiriRetention[$value];
                } else {
                    $resultArray[$key]['time'] = $dateArray[$key];
                    $resultArray[$key]['shisiriretention'] = '-';
                }
            }
        } else {
            foreach ($dateArray as $key => $value) {
                $resultArray[$key]['time'] = $dateArray[$key];
                $resultArray[$key]['shisiriretention'] = '-';
            }
        }
        //求30日留存的登陆数
        foreach ($dateArray as $key => $value) {
            $sanshiriRetention[] = $this->Loginrecord_model->getPaySanshiriRetention($value, $pingtai, $channelid, $appid);
        }
        if (isset($sanshiriRetention) && is_array($sanshiriRetention)) {
            $sanshiriRetention = array_column($sanshiriRetention, 'sanshiriRetention', 'logintime');
            foreach ($dateArray as $key => $value) {
                if (array_key_exists($value, $sanshiriRetention)) {
                    $resultArray[$key]['time'] = $dateArray[$key];
                    $resultArray[$key]['sanshiriRetention'] = $sanshiriRetention[$value];
                } else {
                    $resultArray[$key]['time'] = $dateArray[$key];
                    $resultArray[$key]['sanshiriRetention'] = '-';
                }
            }
        } else {
            foreach ($dateArray as $key => $value) {
                $resultArray[$key]['time'] = $dateArray[$key];
                $resultArray[$key]['sanshiriRetention'] = '-';
            }
        }
        $channelName = $this->Channel_model->getChannelNameByid($channelid);
        //计算留存率
        foreach ($resultArray as $key => $value) {
            if (isset($resultArray[$key]['paycount']) && $resultArray[$key]['paycount'] != '-' && isset($resultArray[$key]['ciriretention']) && $resultArray[$key]['ciriretention'] != '-') {
                $resultArray[$key]['ciriretentionlv'] = round(($resultArray[$key]['ciriretention'] / $resultArray[$key]['paycount'] * 100), 2) . '%';
            } else {
                $resultArray[$key]['ciriretentionlv'] = '-';
            }
            if (isset($resultArray[$key]['paycount']) && $resultArray[$key]['paycount'] != '-' && isset($resultArray[$key]['sanriretention']) && $resultArray[$key]['sanriretention'] != '-') {
                $resultArray[$key]['sanriretentionlv'] = round(($resultArray[$key]['sanriretention'] / $resultArray[$key]['paycount']  * 100), 2) . '%';
            } else {
                $resultArray[$key]['sanriretentionlv'] = '-';
            }
            if (isset($resultArray[$key]['paycount']) && $resultArray[$key]['paycount'] != '-' && isset($resultArray[$key]['qiriretention']) && $resultArray[$key]['qiriretention'] != '-') {
                $resultArray[$key]['qiriretentionlv'] = round(($resultArray[$key]['qiriretention'] / $resultArray[$key]['paycount'] * 100), 2) . '%';
            } else {
                $resultArray[$key]['qiriretentionlv'] = '-';
            }
            if (isset($resultArray[$key]['paycount']) && $resultArray[$key]['paycount'] != '-' && isset($resultArray[$key]['shisiriretention']) && $resultArray[$key]['shisiriretention'] != '-') {
                $resultArray[$key]['shisiriretentionlv'] = round(($resultArray[$key]['shisiriretention'] / $resultArray[$key]['paycount'] * 100), 2) . '%';
            } else {
                $resultArray[$key]['shisiriretentionlv'] = '-';
            }
            if (isset($resultArray[$key]['paycount']) && $resultArray[$key]['paycount'] != '-' && isset($resultArray[$key]['sanshiriRetention']) && $resultArray[$key]['sanshiriRetention'] != '-') {
                $resultArray[$key]['sanshiriRetentionlv'] = round(($resultArray[$key]['sanshiriRetention'] / $resultArray[$key]['paycount'] * 100), 2) . '%';
            } else {
                $resultArray[$key]['sanshiriRetentionlv'] = '-';
            }
            if ($pingtai == "") {
                $resultArray[$key]['pingtai'] = '全平台';
            } else {
                $resultArray[$key]['pingtai'] = $pingtai;
            }
            $resultArray[$key]['channelname'] = $channelName['channelname'];
        }
        return $resultArray;
    }  
}
