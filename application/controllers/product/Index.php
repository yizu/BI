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
        $this->load->service('Pingtai_service');
    }

    //加载首页
    public function index() {
        //取消重写VIEW
        //$this->view_override = FALSE;
        $result['data'] = "";
        $this->load->view("product/index", $result);
    }

    //获取平台概览数据
    public function getPingTaiData() {
        //获取时间段
        $starttime = $this->input->post('starttime', TRUE);
        $endtime = $this->input->post('endtime', TRUE);
        $type = $this->input->post('type', TRUE);

        $starttime = date("Y-m-d", (int) strtotime($starttime));
        $endtime = date("Y-m-d", (int) strtotime($endtime));
        //获取新进入用户

        switch ($type) {
            case 'day':
                $result['data'] = $this->pingtai_service->getPingtaiAllDay($starttime, $endtime);
                break;
            case 'month':
                $result['data'] = $this->pingtai_service->getPingtaiAllMonth($starttime, $endtime);
                break;
            default:
                break;
        }
        $this->load->view("product/index", $result);
    }

}
