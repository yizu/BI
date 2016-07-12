<h2>新增用户</h2>
<br><br>
<form role="form" action="" method="post">
  <div class="form-group">
    <label>用户名</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input name="username" type="text" class="smallinput"  placeholder="在此输入帐号" value="">
  </div>
    <br>
  <div class="form-group">
    <label>昵称</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input name="nickname" type="text" class="smallinput" placeholder="在此输入昵称" value="">
  </div>
    <br>
  <div class="form-group">
    <label>Email</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input name="email" type="email" class="smallinput" placeholder="在此输入Email" value="">
  </div>
    <br>
  <div class="form-group">
    <label>角色</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <select name="role"  class="smallinput" >
    	<option value=''>暂无角色</option>
    	<?php 
    		foreach($role_data as $vo){
    			echo "<option value='{$vo->id}'>{$vo->rolename}</option>";
    		}
    	?>
    </select>
  </div>
    <br>
  <div class="form-group">
    <label>新密码</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input name="password" type="password" class="smallinput" placeholder="在此输入密码" value="">
  </div>
    <br>
  <div class="form-group">
    <label>确认密码</label>&nbsp;&nbsp;&nbsp;
    <input name="password2" type="password" class="smallinput" placeholder="在此确认密码" value="">
  </div>
    <br>
  <div class="checkbox">
    <label>
      <input value="1" name="status" type="checkbox" checked > 是否启用
    </label>
  </div>
    <br>
  <button type="submit" class="submit radius2">确认新增</button>
  <a class="stdbtn" href="<?php echo site_url('manage/member/index'); ?>">取消修改</a>
</form>