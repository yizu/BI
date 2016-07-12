<?php

/**
 * Project:     乐恒互动BI数据统计后台
 * File:        Index.php
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
class Index extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->service('Retention_service');
         $this->load->helper("form");
    }

    //加载首页
    public function index() {
        //取消重写VIEW
        //$this->view_override = FALSE;
        $result['data'] = "";
        $this->load->view("retention/index", $result);
    }

    //获取留存数据
    public function getRetentionData() {
        //获取时间段
        $starttime = $this->input->post('starttime', TRUE);
        $endtime = $this->input->post('endtime', TRUE);
        $type = $this->input->post('roofGarden', TRUE);

        $starttime = date("Y-m-d", (int) strtotime($starttime));
        $endtime = date("Y-m-d", (int) strtotime($endtime));
        $result['data'] = $this->retention_service->getRetentionAll($starttime, $endtime , $type, '', '');
        $this->load->view("retention/index", $result);
    }
    
    
    public function payRetentionIndex() {
        $result['data'] = "";
        $this->load->view("retention/payretention", $result);
    }
    
    
    //获取付费用户的留存等数据
    public function getPayRetentionData() {
        $result['data'] = "";
        //获取时间段
        $starttime = $this->input->post('starttime', TRUE);
        $endtime = $this->input->post('endtime', TRUE);
        $type = $this->input->post('roofGarden', TRUE);

        $starttime = date("Y-m-d", (int) strtotime($starttime));
        $endtime = date("Y-m-d", (int) strtotime($endtime));
        //付费用户留存不区分平台，因为目前只有安卓接入支付。先保留区分平台的方法
        $result['data'] = $this->retention_service->getPayRetentionAll($starttime, $endtime , $type, '', '');
        $this->load->view("retention/payretention", $result);
    }

}
