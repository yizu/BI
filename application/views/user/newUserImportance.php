<script type="text/javascript" src="<?php echo base_url('resource/js/plugins/jquery.dataTables.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('resource/js/plugins/jquery.uniform.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('resource/js/custom/tables.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('resource/js/custom/dashboard.js') ?>"></script>
<div class="bodywrapper">
    <!--            <div class="centercontent tables">-->
    <div class="overviewhead">
        <div class="overviewhead">
            <div class="contenttitle2">
                <h3 class="pagetitle">新玩家价值</h3>
            </div>
            <form action="<?php echo site_url('user/User/findNewUserImportance') ?>" method="post" onsubmit="return check()">
                &nbsp;&nbsp;&nbsp;&nbsp;时间段：
                &nbsp;&nbsp;<input type="text" id="datepickfrom" name="starttime" value="<?php echo set_value('starttime'); ?>"/> &nbsp; 至 &nbsp;<input type="text" name="endtime" id="datepickto" value="<?php echo set_value('endtime'); ?>"/>
                &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;
                平台：
                <select  name="roofGarden">
                    <option value="" <?php echo set_select('roofGarden', ''); ?>>全部</option>
                    <option value="Android" <?php echo set_select('roofGarden', 'Android'); ?>>安卓</option>
                    <option hidden="hidden" value="iOS" <?php echo set_select('roofGarden', 'iOS'); ?>>IOS</option>
                </select>&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;
                <select hidden name="channelid" >
                    <option value="" <?php echo set_select('channelid', ''); ?> >全部</option>
                    <?php foreach ($result as $res) { ?>
                        <option value="<?php echo $res['channelid'] ?>" <?php echo set_select('channelid', $res['channelid']); ?> ><?php echo $res['channelname'] ?></option>
                    <?php } ?>
                </select> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="submit" class="radius3"value="查询"/>
                &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;
                <input id="daochu" type="button" class="stdbtn btn_yellow"value="导出到EXCEL"/>
            </form>
        </div><!--pageheader-->
          <form id="download" action="<?php echo site_url('Export/daochu/') ?>" method="post" >
            <input id="jsonData" type="hidden" name="data" value='<?php
            if (isset($newUserImportance) && is_array($newUserImportance)) {
                echo json_encode($newUserImportance);
            } else {
                echo '1';
            }
            ?>'/>
            <input id="title" type="hidden" name="title" value="<?php echo '时间|平台|新增玩家|7日内平均贡献|14日内平均贡献|30日内平均贡献|60日内平均贡献,date|roofGarden|zhucerenshu|qitian|shisitian|sanshitian|liushitian' ?>"/>
        </form>
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
                        <th class="head0">时间</th>
                        <th class="head1">平台</th>
                        <th class="head0">新增玩家</th>
                        <th class="head1">7日内平均贡献</th>
                        <th class="head0">14日内平均贡献</th>
                        <th class="head1">30日内平均贡献</th>
                        <th class="head0">60日内平均贡献</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($newUserImportance)) {
                        if ($newUserImportance) {
                            foreach ($newUserImportance as $key => $importance) {
                                ?>
                                <tr>
                                    <td><?php echo $key ?></td>
                                    <td><?php echo $importance['roofGarden'] ?></td>
                                    <td><?php echo $importance['zhucerenshu'] ?></td>
                                    <td><?php echo $importance['qitian'] ?></td>
                                    <td><?php echo $importance['shisitian'] ?></td>
                                    <td><?php echo $importance['sanshitian'] ?></td>
                                    <td><?php echo $importance['liushitian'] ?></td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                        <h4>您输入的时间区间不合法</h4>
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
        starttime = starttime.replace(/-/g, '/');
        var starttime = new Date(starttime).getTime();
        var endtime = endtime.replace(/-/g, '/');
        var endtime = new Date(endtime).getTime();
        var days = parseInt((endtime - starttime) / (24 * 60 * 60 * 1000));
        if (days > 7) {
            alert("时间范围不能超过7天");
            return false;
        }
    }
    jQuery(document).ready(function () {
        jQuery('#daochu').bind('click', function () {
            var jsonStr = jQuery("#jsonData").val();
            console.log(jsonStr);
            if (jsonStr!='1') {
                jQuery("#download").submit();
            } else {
                alert("数据为空不能导出");
                return false;
            }

        });
    });
</script>