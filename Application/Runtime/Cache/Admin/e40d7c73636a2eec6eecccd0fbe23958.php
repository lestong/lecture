<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageContent">
    <form action="/admin.php/System/adminRoleEdit/roleid/3?_=1465032860047" class="pageForm" data-toggle="validate">
        <input type="hidden" name="dialog.id" value="edce142bc2ed4ec6b623aacaf602a4de">
        <table class="table table-condensed table-hover">
            <tbody>
                <tr>
                    <td>
                        <label for="j_dialog_operation" class="control-label x90"><?php echo L('role');?>：</label>
                        <input type="text" name="info[rolename]" data-rule="required" size="20" value="<?php echo ($Detail["rolename"]); ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="j_dialog_code" class="control-label x90"><?php echo L('description');?>：</label>
                        <textarea name="info[description]" cols="20" class="form-control" style="width: 337px; margin: 0px; height: 50px;"><?php echo ($Detail[description]); ?></textarea>
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