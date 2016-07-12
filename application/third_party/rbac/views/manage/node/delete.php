<style>
    .table td:first-child{width:30%}
    .table td:nth-child(2){width:40%}
</style>
<h2>您确定要删除？</h2>
<br><br>
<h4>请慎重操作！</h4>
<br>
友情提示：
<ul>
    <li>删除目录时将删除目录下多有控制器与方法！</li>
    <li>删除控制器时将删除其下所有方法！</li>
    <li>删除同时将取消其挂接的导航菜单</li>
</ul>
<hr/>
<br><br>
<form method="POST" action="">
    <input type="hidden" name="verfiy" value="1" >
    <input class="submit radius2"  type="submit" value="确定删除">
    <a class="stdbtn" href="<?php echo site_url('manage/node/index'); ?>">取消操作</a>
</form>
