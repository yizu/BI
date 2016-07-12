<?php

/**
 * Project:     游戏公共基类
 * File:        Payment.php
 *
 * <pre>
 * 描述：类
 * </pre>
 *
 * @package application
 * @subpackage controller
 * @author 李杨 <768216362@qq.com>
 * @copyright 2016 BI, Inc.
 */
class GameCommon extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->service('Channel_service');
        $this->load->service('Payment_service');
        $this->load->library('MyOutPut');
        $this->load->service('User_service');
        $this->load->service('Channel_service');
        $this->load->service('Retention_service');
        $this->load->helper("form");
    }

    //查询活跃用户
    public function findactiveUser() {
        $starttime = $this->input->post('starttime', TRUE);
        $endtime = $this->input->post('endtime', TRUE);
        $roofGarden = $this->input->post('roofGarden', TRUE);
        $channelid = $this->input->post('channelid', TRUE);
        $appid = $this->input->post('appid', TRUE);
        $data['appid'] = $appid;
        $data['result'] = $this->channel_service->findChanneldata();
        $data['activeUser'] = $this->user_service->findactiveUser($starttime, $endtime, $roofGarden, $channelid, $appid);
        $this->load->view('user/gameActiveUser', $data);
    }

    //查询日报
    public function finddailyUser() {
        $starttime = $this->input->post('starttime', TRUE);
        $endtime = $this->input->post('endtime', TRUE);
        $roofGarden = $this->input->post('roofGarden', TRUE);
        $channelid = $this->input->post('channelid', TRUE);
        $data['result'] = $this->channel_service->findChanneldata();
        $appid = $this->input->post('appid', TRUE);
        $data['appid'] = $appid;
        $data['userlist'] = $this->user_service->finddailyUser($starttime, $endtime, $roofGarden, $channelid, $appid);
        $this->load->view('user/gameDailyUser', $data);
    }

    //查询二次付费用户数
    public function getTwoPayment() {
        $starttime = $this->input->post('starttime', TRUE);
        $endtime = $this->input->post('endtime', TRUE);
        $roofGarden = $this->input->post('roofGarden', TRUE);
        $channelid = $this->input->post('channelid', TRUE);
        $data['result'] = $this->channel_service->findChanneldata();
        $appid = $this->input->post('appid', TRUE);
        $data['appid'] = $appid;
        $data['twoPayment'] = $this->payment_service->getTwoPayment($starttime, $endtime, $roofGarden, $channelid, $appid);
        $this->load->view('payment/gameTwoPayment', $data);
    }

    //新增玩家价值
    public function findNewUserImportance() {
        $starttime = $this->input->post('starttime', TRUE);
        $endtime = $this->input->post('endtime', TRUE);
        $roofGarden = $this->input->post('roofGarden', TRUE);
        $channelid = $this->input->post('channelid', TRUE);
        $appid = $this->input->post('appid', TRUE);
        $data['appid'] = $appid;
        $data['result'] = $this->channel_service->findChanneldata();
        $data['newUserImportance'] = $this->user_service->findNewUserImportance($starttime, $endtime, $roofGarden, $channelid, $appid);
        $this->load->view('user/gameNewUserImportance', $data);
    }

    //付费习惯
    public function findPaymentFee() {
        $starttime = $this->input->post('starttime', TRUE);
        $endtime = $this->input->post('endtime', TRUE);
        $roofGarden = $this->input->post('roofGarden', TRUE);
        $channelid = $this->input->post('channelid', TRUE);
        $appid = $this->input->post('appid', TRUE);
        $data['result'] = $this->channel_service->findChanneldata();
        $data['appid'] = $appid;
        $data['PaymentFee'] = $this->payment_service->findPaymentFee($starttime, $endtime, $roofGarden,$channelid, $appid);
        $this->load->view('payment/gamePaymentFee', $data);
    }

    //新增付费玩家
    public function getNewPayUserData() {
        //获取时间段
        $starttime = $this->input->post('starttime', TRUE);
        $endtime = $this->input->post('endtime', TRUE);
        $type = $this->input->post('roofGarden', TRUE);
        $channel = $this->input->post('channelid', TRUE);
        $appid = $this->input->post('appid', TRUE);
        $starttime = date("Y-m-d", (int) strtotime($starttime));
        $endtime = date("Y-m-d", (int) strtotime($endtime));
        switch ($type) {
            case '':
                $result['data'] = $this->payment_service->getNewPayUser($starttime, $endtime, $channel, $appid);
                break;
            case 'Android':
                $result['data'] = $this->payment_service->getNewPayUser($starttime, $endtime, $channel, $appid);
                break;
            case 'IOS':
                $result['data'] = "";
                break;
            default:
                $result['data'] = $this->payment_service->getNewPayUser($starttime, $endtime, $channel, $appid);
                break;
        }
        $result['appid'] = $appid;
        //获取全部渠道数据
        $result['channeldata'] = $this->channel_service->findChanneldata();
        $this->load->view("payment/gameNewpayuser", $result);
    }

    //获取商城道具相关数据
    public function getPropData() {
        //获取时间段
        $starttime = $this->input->post('starttime', TRUE);
        $endtime = $this->input->post('endtime', TRUE);
        $pingtai = $this->input->post('roofGarden', TRUE);
        $channel = $this->input->post('channelid', TRUE);
        $appid = $this->input->post('appid', TRUE);
        $starttime = date("Y-m-d", (int) strtotime($starttime));
        $endtime = date("Y-m-d", (int) strtotime($endtime));
        $result['channeldata'] = $this->channel_service->findChanneldata();
        $result['data'] = $this->payment_service->getPropData($starttime, $pingtai, $channel, $appid);
        $result['appid'] = $appid;
        if ($result['data']) {
            $this->load->view("game/propTongjiPage.php", $result);
        } else {
            $result['data'] = "";
            $this->load->view("game/propTongjiPage.php", $result);
        }
    }

    //获取留存数据
    public function getRetentionData() {
        //获取时间段
        $starttime = $this->input->post('starttime', TRUE);
        $endtime = $this->input->post('endtime', TRUE);
        $pingtai = $this->input->post('roofGarden', TRUE);
        $channel = $this->input->post('channelid', TRUE);
        $appid = $this->input->post('appid', TRUE);
        $starttime = date("Y-m-d", (int) strtotime($starttime));
        $endtime = date("Y-m-d", (int) strtotime($endtime));
        $result['appid'] = $appid;
        $result['channeldata'] = $this->channel_service->findChanneldata();
        $result['data'] = $this->retention_service->getRetentionAll($starttime, $endtime, $pingtai, $channel, $appid);
        $this->load->view("retention/gameRetention", $result);
    }

    //获取付费用户留存数据
    public function getPayRetentionData() {
        //获取时间段
        $starttime = $this->input->post('starttime', TRUE);
        $endtime = $this->input->post('endtime', TRUE);
        $pingtai = $this->input->post('roofGarden', TRUE);
        $channel = $this->input->post('channelid', TRUE);
        $appid = $this->input->post('appid', TRUE);
        $starttime = date("Y-m-d", (int) strtotime($starttime));
        $endtime = date("Y-m-d", (int) strtotime($endtime));
        $result['appid'] = $appid;
        $result['channeldata'] = $this->channel_service->findChanneldata();
        $result['data'] = $this->retention_service->getPayRetentionAll($starttime, $endtime, $pingtai, $channel, $appid);
        $this->load->view("retention/gamePayRetention", $result);
    }

}

?>