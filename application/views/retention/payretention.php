<script type="text/javascript" src="<?php echo base_url('resource/js/plugins/jquery.dataTables.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('resource/js/plugins/jquery.uniform.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('resource/js/custom/tables.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('resource/js/custom/dashboard.js') ?>"></script>
<div class="bodywrapper">
    <!--            <div class="centercontent tables">-->
    <div class="overviewhead">
        <br clear="all" />
        <div class="contenttitle2 nomargintop">
            <h3>付费用户留存</h3>
        </div>

        <div class="overviewhead">
            <form onsubmit="return check()" action="<?php echo site_url('retention/index/getPayRetentionData') ?>" method="post" >
                请选择时间: &nbsp;<input type="text" id="datepickfrom" name="starttime" value="<?php echo set_value('starttime'); ?>"/> &nbsp; &nbsp; &nbsp;<input type="text" id="datepickto" name="endtime" value="<?php echo set_value('endtime'); ?>"/>
                &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;
                平台：
                <select  name="roofGarden">
                    <option value="" <?php echo set_select('roofGarden', ''); ?>>全部</option>
                    <option value="Android" <?php echo set_select('roofGarden', 'Android'); ?>>安卓</option>
                    <option hidden value="iOS" <?php echo set_select('roofGarden', 'iOS'); ?>>IOS</option>
                </select>&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;
                <!--
                &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;
                渠道：
                <div class="selector" id="overviewselect">
                    <span id="show">全平台</span>
                    <select id="select" name="type" class="uniformselect" style="opacity: 0;">
                        <option value="day">按日查询</option>
                        <option value="month">按月查询</option>
                    </select>
                </div>
                &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;
                -->
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
            <input id="title" type="hidden" name="title" value="<?php echo '时间|平台|付费用户数|次日留存率|3日留存率|7日留存率|14日留存率|30日留存率,time|pingtai|paycount|ciriretentionlv|sanriretentionlv|qiriretentionlv|shisiriretentionlv|sanshiriRetentionlv' ?>"/>
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
                    <th class="head1">付费用户数</th>
                    <th class="head0">次日留存率</th>
                    <th class="head1">3日留存率</th>
                    <th class="head0">7日留存率</th>
                    <th class="head0">14日留存率</th>
                    <th class="head1">30日留存率</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($data) {
                    foreach ($data as $key => $value) {
                        echo "<tr> 
                                    <td> " . $value['time'] . " </td>
                                    <td> " . $value['pingtai'] . " </td>
                                    <td>" . $value['paycount'] . "</td>
                                    <td>" . $value['ciriretentionlv'] . "</td>
                                    <td>" . $value['sanriretentionlv'] . "</td>
                                    <td>" . $value['qiriretentionlv'] . "</td>
                                    <td>" . $value['shisiriretentionlv'] . "</td>
                                    <td>" . $value['sanshiriRetentionlv'] . "</td>
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
        var selectvalue = jQuery('#select').val();
        if (selectvalue == 'IOS') {
            alert("暂无IOS付费用户数据");
            return false;
        }
    }

    jQuery(document).ready(function () {
        jQuery('#overviewselect').bind('change', function () {
            var selectvalue = jQuery('#select').val();
            if (selectvalue == 'Android') {
                jQuery("#show").text("Android");
            }
            if (selectvalue == 'IOS') {
                jQuery("#show").text("IOS");
            }
            if (selectvalue == 'all') {
                jQuery("#show").text("全平台");
            }

        });
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