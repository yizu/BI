<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>二次付费用户</title>
        <script type="text/javascript" src="<?php echo base_url('resource/js/plugins/jquery.dataTables.min.js') ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('resource/js/plugins/jquery.uniform.min.js') ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('resource/js/custom/tables.js') ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('resource/js/custom/dashboard.js') ?>"></script>
    </head>
    <body class="withvernav">
        <div class="bodywrapper">
            <!--            <div class="centercontent tables">-->
            <div class="overviewhead">
                <div class="contenttitle2">
                    <h3>&nbsp;&nbsp;二次付费用户</h3>
                </div>
                <div class="overviewhead">
                    <form action="<?php echo site_url('/payment/Payment/getTwoPayment') ?>" method="post" onsubmit="return check()">
                        &nbsp;&nbsp;&nbsp;&nbsp;时间段：
                        &nbsp;&nbsp;<input type="text" id="datepickfrom" name="starttime" value="<?php echo set_value('starttime'); ?>"/> &nbsp; 至 &nbsp;<input type="text" name="endtime" id="datepickto" value="<?php echo set_value('endtime'); ?>"/>
                        &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;
                        平台：
                        <select  name="roofGarden">
                            <option value="" <?php echo set_select('roofGarden', ''); ?>>全部</option>
                            <option value="Android" <?php echo set_select('roofGarden', 'Android'); ?>>安卓</option>
                            <option hidden value="iOS" <?php echo set_select('roofGarden', 'iOS'); ?>>IOS</option>
                        </select>&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;
                        
                        <select hidden name="channelid" >
                            <option value="" <?php echo set_select('channelid', ''); ?> >全部</option>
                            <?php foreach ($result as $res) { ?>
                                <option value="<?php echo $res['channelid'] ?>" <?php echo set_select('channelid', $res['channelid']); ?> ><?php echo $res['channelname'] ?></option>
                            <?php } ?>
                        </select> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="submit" class="radius3"value="查询"/>
                    </form>
                </div>
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
                                <th class="head1">时间</th>
                                <th class="head1">平台</th>
                                <th class="head1">付费人数(去重)</th>
                                <th class="head0">二次付费人数</th>
                                <th class="head1">二次占比</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            if (isset($twoPayment)) {
                                if ($twoPayment) {
                                    ?>
                                    <tr>
                                        <td><?php echo $twoPayment['time']; ?></td>
                                        <td><?php echo $twoPayment['pingtai']; ?></td>
                                        <td class="center"><?php echo $twoPayment['fufeirenshu']; ?></td>
                                        <td class="center"><?php echo $twoPayment['ercifufei']; ?></td>
                                        <td class="center"><?php echo $twoPayment['zhanbi']; ?></td>
                                    </tr>
                                    <?php
                                } else {
                                    ?>
                                    <tr>  
                                        <td colspan="6">无任何信息</td>
                                    </tr>
                                     
                            <?php }}
                                ?>
                        </tbody>
                    </table>
                </div>
            </div>
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
    }
</script>