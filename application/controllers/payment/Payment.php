<?php

/**
 * Project:     乐恒互动BI系统
 * File:        Payment.php
 *
 * <pre>
 * 描述：类
 * </pre>
 *
 * @package application
 * @subpackage controller
 * @author 刘训鹏 <1352345519@qq.com>
 * @copyright .
 */
class Payment extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();

        $this->load->service('Channel_service');
        $this->load->library('MyOutPut');
        $this->load->helper('form');
        $this->load->service('Payment_service');
    }

    //付费习惯页面
    public function paymentFee() {
        $data['result'] = $this->channel_service->findChanneldata();
        $this->load->view('payment/paymentFee', $data);
    }

    //付费习惯
    public function findPaymentFee() {
        $starttime = $this->input->post('starttime', TRUE);
        $endtime = $this->input->post('endtime', TRUE);
        $roofGarden = $this->input->post('roofGarden', TRUE);
        $channelid = $this->input->post('channelid', TRUE);
        $data['PaymentFee'] = $this->payment_service->findPaymentFee($starttime, $endtime, $roofGarden,$channelid,'');
        $this->load->view('payment/paymentFee', $data);
    }

    //二次付费页面
    public function twoPayment() {
        $data['result'] = $this->channel_service->findChanneldata();
        $this->load->view('payment/twopayment', $data);
    }

    //二次付费用户
    public function getTwoPayment() {
        $starttime = $this->input->post('starttime', TRUE);
        $endtime = $this->input->post('endtime', TRUE);
        $roofGarden = $this->input->post('roofGarden', TRUE);
        $channelid = $this->input->post('channelid', TRUE);
        $data['result'] = $this->channel_service->findChanneldata();
        $data['twoPayment']=$this->payment_service->getTwoPayment($starttime, $endtime, $roofGarden, $channelid,'');
         $this->load->view('payment/twopayment', $data);
    }
    
    //新增付费玩家页面
    public function newPayUserPage() {
        $result['data'] = "";
        $this->load->view('payment/newpayuser.php', $result);
        
    }
    
    
    //获取新增付费用户数据
    public function getNewPayUserData() {
        //获取时间段
        $starttime = $this->input->post('starttime', TRUE);
        $endtime = $this->input->post('endtime', TRUE);
        $type = $this->input->post('roofGarden', TRUE);
        
        $starttime = date("Y-m-d", (int) strtotime($starttime));
        $endtime = date("Y-m-d", (int) strtotime($endtime));
        switch ($type) {
            case 'all':
                $result['data'] = $this->payment_service->getNewPayUser($starttime, $endtime, '' ,'');
                break;
            case 'Android':
                $result['data'] = $this->payment_service->getNewPayUser($starttime, $endtime, '' ,'');
                break;
            case 'IOS':
                $result['data'] = "";
                break;
            default:
                break;
        }
        $this->load->view("payment/newpayuser", $result);
    }

}
