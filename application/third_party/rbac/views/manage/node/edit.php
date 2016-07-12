<h2>节点修改</h2>
<br><br>
<form role="form" action="" method="post">
  <div class="form-group">
    <label>目录</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input name="dirc" type="text" class="smallinput"  value="<?php echo $data['dirc']; ?>" disabled>
  </div>
    <br>
  <div class="form-group">
    <label>控制器</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input name="cont" type="text" class="smallinput"  value="<?php echo $data['cont']; ?>" disabled>
  </div>
    <br>
  <div class="form-group">
    <label>方法</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input name="func" type="text" class="smallinput"  value="<?php echo $data['func']; ?>" disabled>
  </div>
    <br>
  <div class="form-group">
    <label>备注</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input name="memo" type="text" class="smallinput" placeholder="在此输入备注" value="<?php echo $data['memo']; ?>">
  </div>
    <br>
  <div class="checkbox">
    <label>
      <input value="1" name="status" type="checkbox" <?php if($data['status']){echo "checked";}?>> 是否启用
    </label>
  </div>
    <br>
  <button type="submit" class="submit radius2">确认修改</button>
  <a class="stdbtn" href="<?php echo site_url('manage/node/index'); ?>">取消操作</a>
</form>