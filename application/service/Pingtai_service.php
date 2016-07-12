<?php

/**
 * Project:     乐恒互动BI数据统计后台
 * File:        Pingtai_service.php
 *
 * <pre>
 * 描述：平台数据业务层
 * </pre>
 *
 * @package application
 * @subpackage controller
 * @author 李杨 <768216362@qq.com>
 * @copyright 2016 BI, Inc.
 */
class Pingtai_service extends MY_Service {

    public function __construct() {
        parent::__construct();
        $this->load->model('UserRegister_model');
        $this->load->model('Loginrecord_model');
        $this->load->model('Paylog_model');
    }

    //统计活跃用户（按日统计）
    public function getPingtaiAllDay($starttime, $endtime) {

        $resultArray = array();

        for ($i = strtotime($starttime); $i <= strtotime($endtime); $i += 86400) {
            $dateArray[] = date("Y-m-d", $i);
        }
        //获取每天新增人数
        $registerInfo = $this->UserRegister_model->getRegisterCountBytime($starttime, $endtime , '', '', '');
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
        //获取每天的活跃用户
        $loginInfo = $this->Loginrecord_model->getLoginCountBytime($starttime, $endtime);
        if (isset($loginInfo) && is_array($loginInfo)) {
            $logincount = array_column($loginInfo, 'logincount', 'logintime');
            foreach ($dateArray as $key => $value) {
                if (array_key_exists($value, $logincount)) {
                    $resultArray[$key]['time'] = $dateArray[$key];
                    $resultArray[$key]['logincount'] = $logincount[$value];
                } else {
                    $resultArray[$key]['time'] = $dateArray[$key];
                    $resultArray[$key]['logincount'] = '-';
                }
            }
        } else {
            foreach ($dateArray as $key => $value) {
                $resultArray[$key]['time'] = $dateArray[$key];
                $resultArray[$key]['logincount'] = '-';
            }
        }
        //获取付费玩家和收入
        $payLogInfo = $this->Paylog_model->getPayLogInfo($starttime, $endtime);
        if (isset($payLogInfo) && is_array($payLogInfo)) {
            $paynum = array_column($payLogInfo, 'paynum', 'paytime');
            foreach ($dateArray as $key => $value) {
                if (array_key_exists($value, $paynum)) {
                    $resultArray[$key]['time'] = $dateArray[$key];
                    $resultArray[$key]['paynum'] = $paynum[$value];
                } else {
                    $resultArray[$key]['time'] = $dateArray[$key];
                    $resultArray[$key]['paynum'] = '-';
                }
            }
            $totalfee = array_column($payLogInfo, 'totalfee', 'paytime');
            foreach ($dateArray as $key => $value) {
                if (array_key_exists($value, $totalfee)) {
                    $resultArray[$key]['time'] = $dateArray[$key];
                    $resultArray[$key]['totalfee'] = $totalfee[$value];
                } else {
                    $resultArray[$key]['time'] = $dateArray[$key];
                    $resultArray[$key]['totalfee'] = '-';
                }
            }
        } else {
            foreach ($dateArray as $key => $value) {
                $resultArray[$key]['time'] = $dateArray[$key];
                $resultArray[$key]['paynum'] = '-';
                $resultArray[$key]['totalfee'] = '-';
            }
        }
        //计算付费渗透率、付费arppu
        foreach ($resultArray as $key => $value) {
            if (isset($resultArray[$key]['logincount']) && $resultArray[$key]['logincount'] != '-') {
                $resultArray[$key]['shentoulv'] = round($resultArray[$key]['paynum'] / $resultArray[$key]['logincount'] * 100) . '%';
            } else {
                $resultArray[$key]['shentoulv'] = '-';
            }
            if (isset($resultArray[$key]['paynum']) && $resultArray[$key]['paynum'] != '-') {
                $resultArray[$key]['arppu'] = round($resultArray[$key]['totalfee'] / $resultArray[$key]['paynum'] * 100) . '%';
            } else {
                $resultArray[$key]['arppu'] = '-';
            }
        }
        return $resultArray;
    }

    //统计活跃用户（按月统计）
    public function getPingtaiAllMonth($starttime, $endtime) {

        $resultArray = array();

        for ($i = strtotime($starttime); $i <= strtotime($endtime); $i += 86400) {
            $dateArray[] = date("Y-m", $i);
        }
        //获取每天新增人数
        $registerInfo = $this->UserRegister_model->getRegisterCountByMonth($starttime, $endtime);
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
        //获取每天的活跃用户
        $loginInfo = $this->Loginrecord_model->getLoginCountByMonth($starttime, $endtime);
        if (isset($loginInfo) && is_array($loginInfo)) {
            $logincount = array_column($loginInfo, 'logincount', 'logintime');
            foreach ($dateArray as $key => $value) {
                if (array_key_exists($value, $logincount)) {
                    $resultArray[$key]['time'] = $dateArray[$key];
                    $resultArray[$key]['logincount'] = $logincount[$value];
                } else {
                    $resultArray[$key]['time'] = $dateArray[$key];
                    $resultArray[$key]['logincount'] = '-';
                }
            }
        } else {
            foreach ($dateArray as $key => $value) {
                $resultArray[$key]['time'] = $dateArray[$key];
                $resultArray[$key]['logincount'] = '-';
            }
        }
        //获取付费玩家和收入
        $payLogInfo = $this->Paylog_model->getPayLogInfoByMonth($starttime, $endtime);
        if (isset($payLogInfo) && is_array($payLogInfo)) {
            $paynum = array_column($payLogInfo, 'paynum', 'paytime');
            foreach ($dateArray as $key => $value) {
                if (array_key_exists($value, $paynum)) {
                    $resultArray[$key]['time'] = $dateArray[$key];
                    $resultArray[$key]['paynum'] = $paynum[$value];
                } else {
                    $resultArray[$key]['time'] = $dateArray[$key];
                    $resultArray[$key]['paynum'] = '-';
                }
            }
            $totalfee = array_column($payLogInfo, 'totalfee', 'paytime');
            foreach ($dateArray as $key => $value) {
                if (array_key_exists($value, $totalfee)) {
                    $resultArray[$key]['time'] = $dateArray[$key];
                    $resultArray[$key]['totalfee'] = $totalfee[$value];
                } else {
                    $resultArray[$key]['time'] = $dateArray[$key];
                    $resultArray[$key]['totalfee'] = '-';
                }
            }
        } else {
            foreach ($dateArray as $key => $value) {
                $resultArray[$key]['time'] = $dateArray[$key];
                $resultArray[$key]['paynum'] = '-';
                $resultArray[$key]['totalfee'] = '-';
            }
        }
        //计算付费渗透率、付费arppu
        foreach ($resultArray as $key => $value) {
            if (isset($resultArray[$key]['logincount']) && $resultArray[$key]['logincount'] != '-') {
                $resultArray[$key]['shentoulv'] = round($resultArray[$key]['paynum'] / $resultArray[$key]['logincount'] * 100) . '%';
            } else {
                $resultArray[$key]['shentoulv'] = '-';
            }
            if (isset($resultArray[$key]['paynum']) && $resultArray[$key]['paynum'] != '-') {
                $resultArray[$key]['arppu'] = round($resultArray[$key]['totalfee'] / $resultArray[$key]['paynum'] * 100) . '%';
            } else {
                $resultArray[$key]['arppu'] = '-';
            }
        }
        $resultArray = $this->_unique_arr($resultArray);
        return $resultArray;
    }
}
