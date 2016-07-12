<style>
.table td:first-child{width:30%}
.table td:nth-child(2){width:40%}
</style>
<h2>您确定要删除此用户(<?php echo $data["nickname"]; ?>)？</h2>
<br><br>
<form method="POST" action="">
	<input type="hidden" name="verfiy" value="1" >
	<input class="submit radius2"  type="submit" value="确定删除">
	<a class="stdbtn" href="<?php echo site_url('manage/member/index'); ?>">取消修改</a>
</form>
