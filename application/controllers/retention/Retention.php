<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Retention
 *
 * @author temp
 */
class Retention extends CI_Controller{
    //put your code here
    public function __construct() {
        parent::__construct();
    }
    
    //转向用户留存界面
    public function userRetention() {
        $this->load->view('retention/user_retention');
    }
    //跳向付费用户显示页面
   public function draweeRetention() {
        $this->load->view('retention/drawee_retention');
   } 
}
