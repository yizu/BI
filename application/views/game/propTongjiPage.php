<script type="text/javascript" src="<?php echo base_url('resource/js/plugins/jquery.dataTables.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('resource/js/plugins/jquery.uniform.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('resource/js/custom/tables.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('resource/js/custom/dashboard.js') ?>"></script>
<div class="bodywrapper">
    <!--            <div class="centercontent tables">-->
    <div class="overviewhead">
        <br clear="all" />
        <div class="contenttitle2 nomargintop">
            <h3>商品道具销售</h3>
        </div>
        <div class="overviewhead">
            <form onsubmit="return check()" action="<?php echo site_url('Game/GameCommon/getPropData') ?>" method="post" >
                请选择时间: &nbsp;<input type="text" id="datepickfrom" name="starttime" value="<?php echo set_value('starttime'); ?>" /> &nbsp; &nbsp; &nbsp;<input hidden type="text" id="datepickto" name="endtime" value="<?php echo set_value('endtime'); ?>"/>
                &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;
                平台：
                <select  name="roofGarden">
                    <option value="" <?php echo set_select('roofGarden', ''); ?>>全部</option>
                    <option value="Android" <?php echo set_select('roofGarden', 'Android'); ?>>安卓</option>
                    <option value="iOS" <?php echo set_select('roofGarden', 'iOS'); ?>>IOS</option>
                </select>&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;
                渠道：
                <select name="channelid" >
                    <option value="" <?php echo set_select('channelid', ''); ?> >全部</option>
                    <?php foreach ($channeldata as $res) { ?>
                        <option value="<?php echo $res['channelid'] ?>" <?php echo set_select('channelid', $res['channelid']); ?> ><?php echo $res['channelname'] ?></option>
                    <?php } ?>
                </select> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="hidden" id="appid" name="appid" value="<?php echo $appid ?>" />
                <input type="submit" class="radius3"value="查询" />
                &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;
                <input id="daochu" type="button" class="stdbtn btn_yellow"value="导出到EXCEL"/>
            </form>
        </div>
        <form id="download" action="<?php echo site_url('Export/daochu/') ?>" method="post" >
            <input id="jsonData" type="hidden" name="data" value='<?php
            if (isset($data) && is_array($data)) {
                echo json_encode($data);
            } else {
                echo '1';
            }
            ?>'/>
            <input id="title" type="hidden" name="title" value="<?php echo '时间|平台|渠道|道具名称|销售次数|单价|销售总额,create_time|pingtai|channelname|body|number|total_fee|sumfee' ?>"/>
        </form>
        <br clear="all" />
        <br clear="all" />
        <br clear="all" />
        <table cellpadding="0" cellspacing="0" border="0" class="stdtable stdtablecb overviewtable2">
            <colgroup>
                <col class="con0" />
                <col class="con1" />
                <col class="con0" />
                <col class="con1" />
                <col class="con0" />
                <col class="con1" />
            </colgroup>
            <thead>
                <tr>
                    <th class="head0">时间</th>
                    <th class="head0">平台</th>
                    <th class="head1">渠道</th>
                    <th class="head0">道具名称</th>
                    <th class="head1">销售次数</th>
                    <th class="head0">单价</th>
                    <th class="head0">销售总额</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($data) {
                    foreach ($data as $key => $value) {
                        echo "<tr> 
                                    <td> " . $value['create_time'] . " </td>
                                    <td> " . $value['pingtai'] . " </td>
                                    <td>" . $value['channelname'] . "</td>
                                    <td>" . $value['body'] . "</td>
                                    <td>" . $value['number'] . "</td>
                                    <td>" . $value['total_fee'] . "</td>
                                    <td>" . $value['sumfee'] . "</td>
                                </tr>";
                    }
                }
                ?>
            </tbody>
        </table>
        <br clear="all" />
        <div id="activities" class="subcontent" style="display: none;">
            &nbsp;
        </div><!-- #activities -->
    </div><!--contentwrapper-->
    <br clear="all" />
</div><!-- centercontent -->
</div><!--bodywrapper-->
<script>
    function check() {
        var starttime = jQuery("#datepickfrom").val();
        var endtime = jQuery("#datepickto").val();
        if (starttime == "") {
            alert("查询开始时间不能为空");
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