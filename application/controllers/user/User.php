<?php

/**
 * Project:     乐恒互动BI系统
 * File:        User.php
 *
 * <pre>
 * 描述  处理用户相关业务（成功返回数据失败返回失败状态）
 * </pre>
 *
 * @package application
 * @subpackage Controller
 * @author 刘训鹏 <1352345519@qq.com>
 * @copyright 2015 JoyBI 
 */
class User extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->library('MyOutPut');
        $this->load->service('User_service');
        $this->load->service('Channel_service');
        $this->load->helper("form");
    }

    //跳入到平台活跃用户查询页面
    public function roofGardenActiveUser() {
        $data['result'] = $this->channel_service->findChanneldata();
        $this->load->view('user/roofGardenActiveUser',$data);
    }

    //跳入到平台日报查询
    public function roofGardenDailyUser() {
        $data['result'] = $this->channel_service->findChanneldata();
        $this->load->view('user/roofGardenDailyUser',$data);
    }
    //查询活跃用户
    public function findactiveUser() {
        $starttime = $this->input->post('starttime', TRUE);
        $endtime = $this->input->post('endtime', TRUE);
        $roofGarden = $this->input->post('roofGarden', TRUE);
        $channelid = $this->input->post('channelid', TRUE);
        $data['result'] = $this->channel_service->findChanneldata();
        $data['activeUser'] = $this->user_service->findactiveUser($starttime, $endtime, $roofGarden, $channelid,'');
        $this->load->view('user/roofGardenActiveUser', $data);
    }

    //查询日报
    public function finddailyUser() {
        $starttime = $this->input->post('starttime', TRUE);
        $endtime = $this->input->post('endtime', TRUE);
        $roofGarden = $this->input->post('roofGarden', TRUE);
        $channelid = $this->input->post('channelid', TRUE);
        $data['result'] = $this->channel_service->findChanneldata();
        $data['userlist'] = $this->user_service->finddailyUser($starttime, $endtime, $roofGarden, $channelid,'');
        $this->load->view('user/roofGardenDailyUser', $data);
    }
    //转向新玩家价值页面
    public function newUserImportance(){
        $data['result'] = $this->channel_service->findChanneldata();
        $this->load->view('user/newUserImportance', $data);
    }
    //新增玩家价值
    public function findNewUserImportance() {
        $starttime = $this->input->post('starttime', TRUE);
        $endtime = $this->input->post('endtime', TRUE);
        $roofGarden = $this->input->post('roofGarden', TRUE);
        $channelid = $this->input->post('channelid', TRUE);
        $data['result'] = $this->channel_service->findChanneldata();
        $data['newUserImportance']=$this->user_service->findNewUserImportance($starttime, $endtime, $roofGarden, $channelid,'');
        $this->load->view('user/newUserImportance', $data);
    }
    //转向鲸鱼用户页面
    public  function cetaceanUser(){
        $this->load->view('user/cetaceanUser');
    }
    //寻找鲸鱼用户
    public  function findCetaceanUser(){
        $endtime = $this->input->post('endtime', TRUE);
        $roofGarden = $this->input->post('roofGarden', TRUE);
        $date['CetaceanUser_list']=$this->user_service->findCetaceanUser( $endtime, $roofGarden);
        $this->load->view('user/cetaceanUser',$date);
    }
}
