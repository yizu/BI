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
class Export extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->library('Excel');
    }

    public function index() {
        $data = $this->input->post_get('data', TRUE);
        $title = $this->input->post_get('title', TRUE);
        $content = json_decode($data, TRUE);
        $title = explode('|', $title);
        if (is_array($content) && is_array($title)) {
            $this->excel->exports($content, $title); // 传入的为二维数组
        } else {
            echo "导出数据出错";
        }
    }

    public function daochu() {
        $data = $this->input->post_get('data', TRUE);
        $title = $this->input->post_get('title', TRUE);
        $content = json_decode($data, TRUE);
        $title = explode(',', $title);
        $head = explode('|', $title[0]);
        $xiaobiao = explode('|', $title[1]);
        foreach ($content as $key => $res) {
            if(!isset($content[$key]['date'])){
                $content[$key]['date']=$key;
            }
        }
         foreach ($content as $key => $res) {
            foreach ($xiaobiao as $ke => $xb) {
                $datelist[$key][$xiaobiao[$ke]] = $res[$xiaobiao[$ke]];
            }
        }
        if (is_array($datelist) && is_array($head)) {
            $this->excel->exports($datelist, $head); // 传入的为二维数组
        } else {
            echo "导出数据出错";
        }
    }

}
