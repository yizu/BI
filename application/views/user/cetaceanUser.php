<script type="text/javascript" src="<?php echo base_url('resource/js/plugins/jquery.dataTables.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('resource/js/plugins/jquery.uniform.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('resource/js/custom/tables.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('resource/js/custom/dashboard.js') ?>"></script>
<div class="bodywrapper">
    <div class="overviewhead">
        <div class="contenttitle2">
            <h3>&nbsp;&nbsp;鲸鱼用户</h3>
        </div>
        <div class="overviewhead">
            <form action="<?php echo site_url('user/User/findCetaceanUser') ?>" method="post" onsubmit="return check()">
                &nbsp;&nbsp;&nbsp;&nbsp;时间段： <input type="text" name="endtime" id="datepickto" value="<?php echo set_value('endtime'); ?>"/>
                &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;
                平台：
                <select  name="roofGarden">
                    <option value="" <?php echo set_select('roofGarden', ''); ?>>全部</option>
                    <option value="Android" <?php echo set_select('roofGarden', 'Android'); ?>>安卓</option>
                    <option hidden value="iOS" <?php echo set_select('roofGarden', 'iOS'); ?>>IOS</option>
                </select>&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;
                <input type="submit" class="radius3"value="查询"/>
                &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;
                <input id="daochu" type="button" class="stdbtn btn_yellow"value="导出到EXCEL"/>
            </form>
        </div>
        <form id="download" action="<?php echo site_url('Export/daochu/') ?>" method="post" >
            <input id="jsonData" type="hidden" name="data" value='<?php
            if (isset($CetaceanUser_list) && is_array($CetaceanUser_list)) {
                $i = 1;
                foreach ($CetaceanUser_list as $key => $res) {
                    $CetaceanUser_list[$key]['paiming'] = $i;
                    $i++;
                }
                echo json_encode($CetaceanUser_list);
            } else {
                echo '1';
            }
            ?>'/>
            <input id="title" type="hidden" name="title" value="<?php echo '排名|平台|账号|充值金额|注册日期|最后登录日期,paiming|pingtai|username|total_fee|tokentime|logintime' ?>"/>
        </form>
        <br clear="all" />
        <br clear="all" />
        <br clear="all" />
        <div id="contentwrapper" class="contentwrapper">
            <table cellpadding="0" cellspacing="0" border="0" class="stdtable">
                <colgroup>
                    <col class="con0" />
                    <col class="con1" />
                    <col class="con0" />
                    <col class="con1" />
                    <col class="con0" />
                </colgroup>
                <thead>
                    <tr>
                        <th class="head0">排名</th>
                        <th class="head1">平台</th>
                        <th class="head1">账号</th>
                        <th class="head0">充值金额</th>
                        <th class="head0">注册日期</th>
                        <th class="head0">最后登录日期</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($CetaceanUser_list)) {
                        if ($CetaceanUser_list) {
                            $i = 1;
                            foreach ($CetaceanUser_list as $key => $user) {
                                ?>
                                <tr>
                                    <td><?php echo $user['paiming'] ?></td>
                                    <td><?php echo $user['pingtai']; ?></td>
                                    <td><?php echo $user['username'] ?></td>
                                    <td><?php echo $user['total_fee'] ?></td>
                                    <td><?php echo $user['tokentime'] ?></td>
                                    <td><?php echo $user['logintime'] ?></td>
                                </tr>
                                <?php
                                $i++;
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="5">无数据</td>  
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    function check() {
        var starttime = jQuery("#datepickfrom").val();
        var endtime = jQuery("#datepickto").val();
        if (starttime == "") {
            alert("查询开始时间不能为空");
            return false;
        }
        if (endtime == "") {
            alert("查询结束时间不能时空");
            return false;
        }
        if (starttime > endtime) {
            alert("起始时间不能大于结束时间");
            return false;
        }
    }
    jQuery(document).ready(function () {
        jQuery('#daochu').bind('click', function () {
            var jsonStr = jQuery("#jsonData").val();
            console.log(jsonStr);
            if (jsonStr != '1') {
                jQuery("#download").submit();
            } else {
                alert("数据为空不能导出");
                return false;
            }

        });
    });
</script>

