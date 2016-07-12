<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>活跃用户</title>
<script type="text/javascript" src="<?php echo base_url('resource/js/plugins/jquery.dataTables.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('resource/js/plugins/jquery.uniform.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('resource/js/custom/tables.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('resource/js/custom/dashboard.js') ?>"></script>

<div class="bodywrapper">
    <!--            <div class="centercontent tables">-->
    <div class="overviewhead">
        <div class="contenttitle2">
            <h3>&nbsp;&nbsp;日报</h3>
        </div>
        <div class="overviewhead">
            <form action="<?php echo site_url('Game/GameCommon/finddailyUser') ?>" method="post" onsubmit="return check()">
                &nbsp;&nbsp;&nbsp;&nbsp;时间段：
                &nbsp;&nbsp;<input type="text" id="datepickfrom" name="starttime" value="<?php echo set_value('starttime'); ?>"/> &nbsp; 至 &nbsp;<input type="text" name="endtime" id="datepickto" value="<?php echo set_value('endtime'); ?>"/>
                &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;
                平台：
                <select  name="roofGarden">
                    <option value="" <?php echo set_select('roofGarden', ''); ?>>全部</option>
                    <option value="Android" <?php echo set_select('roofGarden', 'Android'); ?>>安卓</option>
                    <option value="iOS" <?php echo set_select('roofGarden', 'iOS'); ?>>IOS</option>
                </select>&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;
                渠道：
                <select name="channelid" >
                    <option value="" <?php echo set_select('channelid', ''); ?> >全部</option>
                    <?php foreach ($result as $res) { ?>
                        <option value="<?php echo $res['channelid'] ?>" <?php echo set_select('channelid', $res['channelid']); ?> ><?php echo $res['channelname'] ?></option>
                    <?php } ?>
                </select> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input hidden name="appid" value="<?php echo $appid; ?>"/>
                <input type="submit" class="radius3"value="查询"/>
                &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;
                <input id="daochu" type="button" class="stdbtn btn_yellow"value="导出到EXCEL"/>
            </form>
            <form id="download" action="<?php echo site_url('Export/daochu/') ?>" method="post" >
                <input id="jsonData" type="hidden" name="data" value='<?php
                if (isset($userlist) && is_array($userlist)) {
                    echo json_encode($userlist);
                } else {
                    echo '1';
                }
                ?>'/>
                <input id="title" type="hidden" name="title" value="<?php echo '时间|平台|渠道|注册|活跃|付费人数|收入(元)|付费渗透率|arppu|活跃arppu,date|pingtai|qudao|zhucerenshu|huoyue|number|total_fee|fufeishentou|arppu|活跃arppu' ?>"/>
            </form>
        </div>

        <br clear="all" />
        <br clear="all" />
        <br clear="all" />
        <div id="contentwrapper" class="contentwrapper">
            <!--contenttitle-->
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
                        <th class="head0">时间</th>
                        <th class="head1">平台</th>
                        <th class="head0">渠道</th>
                        <th class="head1">注册</th>
                        <th class="head0">活跃</th>
                        <th class="head1">付费人数</th>
                        <th class="head0">收入（元）</th>
                        <th class="head1">付费渗透率</th>
                        <th class="head0">arppu</th>
                        <th class="head1">活跃arppu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($userlist)) {
                        if ($userlist) {
                            foreach ($userlist as $key => $list) {
                                ?>
                                <tr>
                                    <td><?php echo $key ?></td>
                                    <td><?php echo $list['pingtai']; ?></td>
                                    <td><?php echo $list['qudao']; ?></td>
                                    <td class="center"><?php echo $list['zhucerenshu']; ?></td>
                                    <td class="center"><?php echo $list['huoyue']; ?></td>
                                    <td class="center"><?php echo $list['number']; ?></td>
                                    <td class="center"><?php echo $list['total_fee']; ?></td>
                                    <td class="center"><?php echo $list['fufeishentou']; ?></td>
                                    <td class="center"><?php echo $list['arppu']; ?></td>
                                    <td class="center"><?php echo $list['活跃arppu']; ?></td>

                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="10">暂无数据</td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div><!--pageheader-->
</div>
</body>
</html>
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
        starttime = starttime.replace(/-/g, '/');
        var starttime = new Date(starttime).getTime();
        var endtime = endtime.replace(/-/g, '/');
        var endtime = new Date(endtime).getTime();
        var days = parseInt((endtime - starttime) / (24 * 60 * 60 * 1000));
        if (days > 30) {
            alert("时间范围不能超过30天");
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

