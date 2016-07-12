<?php

/**
 * Project:     乐恒互动BI系统
 * File:        Game.php
 *
 * <pre>
 * 描述  处理游戏相关业务（成功返回数据失败返回失败状态）
 * </pre>
 *
 * @package application
 * @subpackage Controller
 * @author 刘训鹏 <1352345519@qq.com>
 * @copyright 2015 JoyBI 
 */
class Game extends CI_Controller{
    //put your code here
    public function __construct() {
        parent::__construct();
       // $this->load->service('');
        $this->load->service('Channel_service');
    }

    public function dailyUser(){
        $data['result']= $this->channel_service->findChanneldata();
        $this->load->view('user/game_dailyUser',$data);
    }
}
