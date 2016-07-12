<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>数据表格页面_AmaAdmin后台管理系统模板 - 源码之家</title>
        <script type="text/javascript" src="<?php echo base_url('resource/js/plugins/jquery.dataTables.min.js') ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('resource/js/plugins/jquery.uniform.min.js') ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('resource/js/custom/tables.js') ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('resource/js/custom/dashboard.js') ?>"></script>

    </head>

    <body class="withvernav">
        <div class="bodywrapper">
            <div class="centercontent tables">
                <form action="<?php echo site_url('roofGarden/roofGardenData/findroofGardenData') ?>" method="post">
                    <div class="pageheader notab">
                        <h1 class="pagetitle">平台数据概览</h1><br/>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <select name="style" style="heigh:13px;width:14px;" >
                            <option value="month">按月查询</option>
                            <option value="day">按日查询</option>
                        </select> &nbsp;
                        From: &nbsp;<input type="text" name="starttime" id="datepickfrom"/> &nbsp; &nbsp; To: &nbsp;<input type="text" name="endtime" id="datepickto"/>
                        <input type="submit" class="radius3"value="查询"/>
                    </div><!--pageheader-->
                </form>
                <div id="contentwrapper" class="contentwrapper">

                    <div class="contenttitle2">
                        <h3>数据显示</h3>
                    </div><!--contenttitle-->

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
                                <th class="head0">Rendering engine</th>
                                <th class="head1">Browser</th>
                                <th class="head0">Platform(s)</th>
                                <th class="head1">Engine version</th>
                                <th class="head0">CSS grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Trident</td>
                                <td>Internet Explorer 4.0</td>
                                <td>Win 95+</td>
                                <td class="center">4</td>
                                <td class="center">X</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet Explorer 5.0</td>
                                <td>Win 95+</td>
                                <td class="center">5</td>
                                <td class="center">C</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet  Explorer 5.5</td>
                                <td>Win 95+</td>
                                <td class="center">5.5</td>
                                <td class="center">A</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet Explorer 6</td>
                                <td>Win 98+</td>
                                <td class="center">6</td>
                                <td class="center">A</td>
                            </tr>
                            <tr>
                                <td>Trident</td>
                                <td>Internet Explorer 7</td>
                                <td>Win XP SP2+</td>
                                <td class="center">7</td>
                                <td class="center">A</td>
                            </tr>
                        </tbody>
                    </table>


                </div><!--contentwrapper-->

            </div><!-- centercontent -->


        </div><!--bodywrapper-->

    </body>
   
</html>
