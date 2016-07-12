<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>乐恒互动BI后台管理系统</title>
        <link rel="stylesheet" href="<?php echo base_url(); ?>resource/css/style.default.css" type="text/css" />
        <script type="text/javascript" src="<?php echo base_url(); ?>resource/js/plugins/jquery-1.7.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>resource/js/plugins/jquery-ui-1.8.16.custom.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>resource/js/plugins/jquery.cookie.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>resource/js/plugins/jquery.uniform.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>resource/js/custom/general.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>resource/js/custom/index.js"></script>
    </head>
    <body class="loginpage">
        <div class="loginbox">
            <div class="loginboxinner">

                <div class="logo">
                    <h1 class="logo">乐恒<span>互动</span></h1>
                    <span class="slogan">BI后台管理系统</span>
                </div>
                <br clear="all" /><br />
                <div class="nousername">
                    <div class="loginmsg">密码不正确.</div>
                </div><!--nousername-->
                <div class="nopassword">
                    <div class="loginmsg">密码不正确.</div>
                    <div class="loginf">
                        <div class="thumb"><img alt="" src="<?php echo base_url(); ?>resource/images/thumbs/avatar1.png" /></div>
                        <div class="userlogged">
                            <h4></h4>
                            <a href="index.html">Not <span></span>?</a>
                        </div>
                    </div>
                </div>
                <form id="login" action="login" method="post">
                    <div class="username">
                        <div class="usernameinner">
                            <input type="text" name="username" id="username" />
                        </div>
                    </div>

                    <div class="password">
                        <div class="passwordinner">
                            <input type="password" name="password" id="password" />
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" data-loading-text="正在登录">登录</button>
                </form>
            </div>
        </div>
    </body>
</html>
