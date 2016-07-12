<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>乐恒互动BI后台管理系统</title>
        <link rel="stylesheet" href="<?php echo base_url('resource/css/style.default.css') ?>" type="text/css" />
        <script type="text/javascript" src="<?php echo base_url('resource/js/plugins/jquery-1.7.min.js') ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('resource/js/plugins/jquery-ui-1.8.16.custom.min.js') ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('resource/js/plugins/jquery.cookie.js') ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('resource/js/custom/general.js') ?>"></script>
    </head>
    <body class="withvernav">
        <div class="bodywrapper">
            <div class="topheader">
                <div class="left">
                    <h1 class="logo">乐恒<span>互动</span></h1>
                    <span class="slogan">乐恒互动BI后台管理系统</span>
                    <br clear="all" />
                </div>
                <div class="right">
                    <div class="userinfo">
                        <img src="<?php echo base_url('resource/images/thumbs/avatar.png'); ?>" alt="" />
                        <span><?php echo rbac_conf(array('INFO','nickname'));?></span>
                    </div>
                    <div class="userinfodrop">
                        <div class="avatar">
                            <a href=""><img src="<?php echo base_url('resource/images/thumbs/avatarbig.png'); ?>" alt="" /></a>
                        </div>
                        <div class="userdata">
                            <h4><?php echo rbac_conf(array('INFO','nickname'));?></h4>
                            <ul>
                                <li><a href="<?php echo site_url('Index/logout'); ?>">退出</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header">
                <ul class="headermenu">
                    <li><a href="<?php echo site_url('product/index/index'); ?>"><span class="icon icon-flatscreen"></span>平台数据</a></li>
                    <li><a href="javascript:void(0);"><span class="icon icon-pencil"></span>铁血风云</a></li>
                </ul>
            </div>
        </div>   


