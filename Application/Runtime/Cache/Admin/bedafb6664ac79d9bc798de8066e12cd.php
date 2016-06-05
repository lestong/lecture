<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageContent">
    <form id="s_profile" action="/admin.php/System/profile?_=1455117001194" data-toggle="validate" method="post">
        <hr>
        <div class="form-group">
            <label class="control-label x85">账号：</label>
            <input type="text"  value="<?php echo ($Detail["username"]); ?>" placeholder="旧密码" size="20" disabled>
        </div>
        <div class="form-group" style="margin: 20px 0 20px; ">
            <label for="s_nickname" class="control-label x85">昵称：</label>
            <input type="text" data-rule="required" name="nickname" id="s_nickname" value="<?php echo ($Detail["nickname"]); ?>" placeholder="昵称" size="20" class="required">
        </div>
    </form>
</div>
<div class="bjui-pageFooter">
    <ul>
        <li><button type="button" class="btn-close"><?php echo L('close');?></button></li>
        <li><button type="submit" class="btn-default"><?php echo L('save');?></button></li>
    </ul>
</div>