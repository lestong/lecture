<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageContent">
    <form action="/admin.php/System/adminAdd/?_=1465048292171" class="pageForm" data-toggle="validate">
        <input type="hidden" name="dialog.id" value="edce142bc2ed4ec6b623aacaf602a4de">
        <table class="table table-condensed table-hover">
            <tbody>
                <!-- <tr>
                    <td colspan="2" align="center"><h3>* 我是一个弹出窗口</h3></td>
                </tr> -->
                <tr>
                    <td>
                        <label for="j_dialog_name" class="control-label x90"><?php echo L('username');?>：</label>
                        <?php if(empty($Detail)): ?><input type="text" name="username" data-rule="required;remote[<?php echo U('System/ajax_checkUsername');?>]" size="20" value="<?php echo ($Detail["username"]); ?>" class="required">
                        <?php else: ?>
                        <input type="text" disabled size="20" value="<?php echo ($Detail["username"]); ?>"><?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="j_dialog_tel" class="control-label x90"><?php echo L('name');?>：</label>
                        <input type="text" name="nickname" data-rule="required" size="20" value="<?php echo ($Detail["nickname"]); ?>" class="required">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="j_dialog_profession" class="control-label x90"><?php echo L('role');?>：</label>
                        <select data-toggle="selectpicker" name="roleid">
                            <?php if(is_array($roles)): foreach($roles as $key=>$role): ?><option value="<?php echo ($key); ?>" <?php if(($Detail["roleid"]) == $key): ?>selected<?php endif; ?>><?php echo ($role[rolename]); ?></option><?php endforeach; endif; ?>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>
<div class="bjui-pageFooter">
    <ul>
        <li><button type="button" class="btn-close"><?php echo L('close');?></button></li>
        <li><button type="submit" class="btn-default"><?php echo L('save');?></button></li>
    </ul>
</div>