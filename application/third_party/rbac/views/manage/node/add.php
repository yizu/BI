<h2>新增节点</h2>
<br><br>
<form role="form" action="" method="post">
  <div class="form-group">
    <label>目录</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input name="dirc" type="text" class="smallinput" placeholder="在此输入目录" value="<?php if(isset($dirc)){echo $dirc;} ?>" <?php if(isset($dirc)){echo "disabled";} ?>>
  </div>
    <br>
  <div class="form-group">
    <label>控制器</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input name="cont" type="text" class="smallinput" placeholder="在此输入控制器" value="<?php if(isset($cont)){echo $cont;} ?>" <?php if(isset($cont)){echo "disabled";} ?>>
  </div>
    <br>
  <div class="form-group">
    <label>方法</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input name="func" type="text" class="smallinput" placeholder="在此输入方法" value="<?php if(isset($func)){echo $func;} ?>" <?php if(isset($func)){echo "disabled";} ?>>
  </div>
    <br>
  <div class="form-group">
    <label>备注</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input name="memo" type="text" class="smallinput" placeholder="在此输入备注" value="">
  </div>
    <br>
  <div class="checkbox">
    <label>
      <input value="1" name="status" type="checkbox" checked> 是否启用
    </label>
  </div>
    <br>
  <button type="submit" class="submit radius2">确认新增</button>
  <a class="stdbtn" href="<?php echo site_url('manage/node/index'); ?>">取消操作</a>
</form>