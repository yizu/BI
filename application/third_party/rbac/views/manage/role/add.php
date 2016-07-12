<h2>新增角色</h2>
<br><br>
<form role="form" action="" method="post">
  <div class="form-group">
      <label>角色名</label>&nbsp;&nbsp;&nbsp;&nbsp;
    <input name="rolename" type="text" class="smallinput"  placeholder="在此输入角色名" value="">
  </div>
     <br>
  <div class="checkbox">
    <label>
      <input value="1" name="status" type="checkbox" checked > 是否启用
      
    </label>
       <br>
  </div>
    <br>
  <button type="submit" class="submit radius2">确认新增</button>
  <a class="stdbtn" href="<?php echo site_url('manage/role/index'); ?>">取消修改</a>
</form>