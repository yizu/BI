<?php

/**
 * Project:     乐恒互动BI系统
 * File:        Channel.php
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
class Channel extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->service('Channel_service');
        $this->load->library('MyOutPut');
        $this->load->helper("form");
    }

    //查询渠道新进排行
    public function findChannelIngoing() {
        $starttime = $this->input->post('starttime', TRUE);
        $endtime = $this->input->post('endtime', TRUE);
        $roofGarden = $this->input->post('roofGarden', TRUE);
        $channelid = $this->input->post('channelid', TRUE);
        $data['result'] = $this->channel_service->findChanneldata();
        $appid = $this->input->post('appid', TRUE);
        $data['appid'] = $appid;
        $data['channelarray'] = $this->channel_service->findChannelIngoing($starttime, $endtime, $roofGarden, $channelid, $appid);
        $this->load->view('channel/channelIngoing', $data);
    }

    //查询渠道收入排行
    public function findchannelEarning() {
        $starttime = $this->input->post('starttime', TRUE);
        $endtime = $this->input->post('endtime', TRUE);
        $roofGarden = $this->input->post('roofGarden', TRUE);
        $channelid = $this->input->post('channelid', TRUE);
        $data['result'] = $this->channel_service->findChanneldata();
        $appid = $this->input->post('appid', TRUE);
        $data['appid'] = $appid;
        $data['channelarray'] = $this->channel_service->findchannelEarning($starttime, $endtime, $roofGarden, $channelid);
        $this->load->view('channel/channelEarning', $data);
    }

}
