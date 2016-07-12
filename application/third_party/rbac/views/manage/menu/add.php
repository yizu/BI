<h2>新增子菜单</h2>
<br><br>
<form role="form" action="" method="post">
    <div class="form-group">
        <label>标题</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input name="title" type="text" class="smallinput" placeholder="在此输入标题" value="">
    </div>
    <br>
    <div class="form-group">
        <label>挂接节点</label>&nbsp;&nbsp;
        <select name="node"  class="form-control">
            <option value=''>不进行挂接</option>
            <?php
            foreach ($node as $vo) {
                $select = $data["node_id"] == $vo->id ? "selected" : "";
                echo "<option value='{$vo->id}' {$select} >{$vo->memo} [{$vo->dirc}/{$vo->cont}/{$vo->func}]</option>";
            }
            ?>
        </select>
    </div>
    <br>
    <div class="form-group">
        <label>排序</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input name="sort" type="number" class="smallinput" placeholder="在此输入排序" value="1">
    </div>
    <div class="checkbox">
        <label>
            <input value="1" name="status" type="checkbox" checked> 是否显示
        </label>
    </div>
   <br>
    <input type="hidden" name="level" value="<?php echo $level; ?>">
    <input type="hidden" name="p_id" value="<?php echo $p_id; ?>">
    <button type="submit" class="submit radius2">确认修改</button>
    <a class="stdbtn" href="<?php echo site_url('manage/menu/index'); ?>">取消修改</a>
</form>