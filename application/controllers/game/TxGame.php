<?php

/**
 * Project:     支付相关数据统计
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
class TxGame extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper("form");
        $this->load->service('Channel_service');
        $this->load->service('Payment_service');
    }

    //商城道具页面
    public function propTongjiPage() {
        $result['data'] = "";
        //获取全部渠道数据
        $result['channeldata'] = $this->channel_service->findChanneldata();
        $result['appid'] = '10001';
        $this->load->view('game/propTongjiPage.php', $result);
    }
    //跳向查询活跃用户页面
    public function gameActiveUser() {
        $data['appid'] = '10001';
        $data['result'] = $this->channel_service->findChanneldata();
        $this->load->view('user/gameActiveUser', $data);
    }

    //跳向查询游戏日报页面
    public function gameDailyUser() {
        $data['appid'] = '10001';
        $data['result'] = $this->channel_service->findChanneldata();
        $this->load->view('user/gameDailyUser', $data);
    }

    //跳向二次付费用户数页面
    public function gameTwoPayment() {
        $data['appid'] = '10001';
        $data['result'] = $this->channel_service->findChanneldata();
        $this->load->view('payment/gameTwoPayment', $data);
    }

    //转向新玩家价值页面
    public function gameNewUserImportance() {
        $data['appid'] = '10001';
        $data['result'] = $this->channel_service->findChanneldata();
        $this->load->view('user/gameNewUserImportance', $data);
    }

    //转向渠道收入排行页面
    public function channelEarning() {
        $data['appid'] = '10001';
        $data['result'] = $this->channel_service->findChanneldata();
        $this->load->view('channel/channelEarning', $data);
    }

    //转向渠道新进排行
    public function channelIngoing() {
        $data['appid'] = '10001';
        $data['result'] = $this->channel_service->findChanneldata();
        $this->load->view('channel/channelIngoing', $data);
    }
     //新增付费玩家页面
    public function  gameNewPayUserPage() {
        $result['data'] = "";
        $result['appid'] = '10001';
        //获取全部渠道数据
        $result['channeldata'] = $this->channel_service->findChanneldata();
        $this->load->view('payment/gameNewpayuser.php', $result);
        
    }
    //转向付费习惯
    public function gamePaymentFee() {
        $data['appid'] = '10001';
        $data['result'] = $this->channel_service->findChanneldata();
        $data['PaymentFee'] = "";
        $this->load->view('payment/gamePaymentFee', $data);
    }
    
    //转向用户留存
    public function gameRetention() {
        $result['appid'] = '10001';
        //获取全部渠道数据
        $result['channeldata'] = $this->channel_service->findChanneldata();
        $result['data'] = "";
        $this->load->view("retention/gameRetention", $result);
    }
    
    //转向付费用户留存
    public function gamePayRetention() {
        $result['appid'] = '10001';
        //获取全部渠道数据
        $result['channeldata'] = $this->channel_service->findChanneldata();
        $result['data'] = "";
        $this->load->view("retention/gamePayRetention", $result);
    }

}
