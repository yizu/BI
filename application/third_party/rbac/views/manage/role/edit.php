<h2>角色编辑</h2>
<br><br>
<form role="form" action="" method="post">
  <div class="form-group">
      <label>角色名</label>&nbsp;&nbsp;&nbsp;&nbsp;
    <input name="rolename" type="text" class="smallinput" value="<?php echo $data['rolename']; ?>">
  </div>
    <br>
  <div class="checkbox">
    <label>
      <input value="1" name="status" type="checkbox" <?php if($data["status"]){echo "checked";}?>> 是否启用
    </label>
  </div>
    <br>
  <input type="hidden" name="id" value="<?php echo $data['id'];?>">
  <button type="submit" class="submit radius2">确认修改</button>
  <a class="stdbtn" href="<?php echo site_url('manage/role/index'); ?>">取消修改</a>
</form>