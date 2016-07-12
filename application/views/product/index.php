<script type="text/javascript" src="<?php echo base_url('resource/js/plugins/jquery.dataTables.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('resource/js/plugins/jquery.uniform.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('resource/js/custom/tables.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('resource/js/custom/dashboard.js') ?>"></script>
<div class="bodywrapper">
    <!--            <div class="centercontent tables">-->
    <div class="overviewhead">
        <br clear="all" />
        <div class="contenttitle2 nomargintop">
            <h3>平台数据概览</h3>
        </div>

        <div class="overviewhead">
            <form onsubmit="return check()" action="<?php echo site_url('product/index/getPingTaiData') ?>" method="post" >
                <div class="selector" id="overviewselect">
                    <span id="show">按日查询</span>
                    <select id="select" name="type" class="uniformselect" style="opacity: 0;">
                        <option value="day">按日查询</option>
                        <option value="month">按月查询</option>
                    </select>
                </div>
                &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;
                请选择时间: &nbsp;<input type="text" id="datepickfrom" name="starttime" /> &nbsp; &nbsp; &nbsp;<input type="text" id="datepickto" name="endtime" />
                <input type="submit" class="radius3"value="查询" />
                &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;
                <input id="daochu" type="button" class="stdbtn btn_yellow"value="导出到EXCEL"/>
            </form>
        </div>
        <form id="download" action="<?php echo site_url('Export/index/') ?>" method="post" >
            <input id="jsonData" type="hidden" name="data" value='<?php
            if ($data && isset($data) && is_array($data)) {
                echo json_encode($data);
            } else {
                echo '1';
            }
            ?>'/>
            <input id="title" type="hidden" name="title" value="<?php echo '时间|新进用户|活跃用户|付费玩家|收入|付费渗透率|付费' ?>"/>
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
                    <th class="head0">新进用户</th>
                    <th class="head0">活跃用户</th>
                    <th class="head1">付费玩家</th>
                    <th class="head0">收入</th>
                    <th class="head1">付费渗透率</th>
                    <th class="head0">付费</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($data) {
                    foreach ($data as $key => $value) {
                        echo "<tr> 
                                    <td> " . $value['time'] . " </td>
                                    <td>" . $value['registercount'] . "</td>
                                    <td>" . $value['logincount'] . "</td>
                                    <td>" . $value['paynum'] . "</td>
                                    <td>" . $value['totalfee'] . "</td>
                                    <td>" . $value['shentoulv'] . "</td>
                                    <td>" . $value['arppu'] . "</td>
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
    }


    jQuery(document).ready(function () {
        jQuery('#overviewselect').bind('change', function () {
            var selectvalue = jQuery('#select').val();
            if (selectvalue == 'month') {
                jQuery("#show").text("按月查询");
            }
            if (selectvalue == 'day') {
                jQuery("#show").text("按日查询");
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