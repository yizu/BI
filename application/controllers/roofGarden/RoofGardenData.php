<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of roofGardenData
 *
 * @author temp
 */
class roofGardenData extends CI_Controller {
    //put your code here
    public function __construct() {
        parent::__construct();
         $this->load->library('MyOutPut');
    }
   
    //查询平台数据
    public function findroofGardenData(){
       $this->load->service('Roofgarden_service');
        $style= $this->input->post('style',true);            //获取查询状态（按月或按日）；
        $starttime= $this->input->post('starttime',true);       //获取查询开始时间
        $endtime= $this->input->post('endtime',true);        //获取查询结束时间
        $this->roofgarden_service->findRoofGardendata($style, $starttime, $endtime);
    }
}
