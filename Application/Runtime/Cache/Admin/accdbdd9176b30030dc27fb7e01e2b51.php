<?php if (!defined('THINK_PATH')) exit();?><script>
$('#icon').on('afterchange.bjui.lookup', function(e, data) {
    var myvalue = 'fa fa-' + data.value
    //
    $("#icon_img").removeClass();
    $("#icon_img").addClass(myvalue);
    // do something...
})
</script>
<div class="bjui-pageContent">
    <form action="/admin.php/System/adminNodeEdit/id/8/pc_hash/?_=1465046137724" class="pageForm" data-toggle="validate">
        <input type="hidden" name="dialog.id" value="edce142bc2ed4ec6b623aacaf602a4de">
        <table class="table table-condensed table-hover">
            <tbody>
                <tr>
                    <td>
                        <label for="j_dialog_operation" class="control-label x90">上级菜单：</label>
                        <select name="info[parentid]" data-toggle="selectpicker">
                            <option value="0">作为一级菜单</option>
                            <?php echo $select_categorys;?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="j_dialog_code" class="control-label x90">菜单名：</label>
                        <input type="text" name="info[name]" data-rule="required" size="20" value="<?php echo ($Detail["name"]); ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="j_dialog_name" class="control-label x90">文件名：</label>
                        <input type="text" name="info[c]" data-rule="required" size="20" value="<?php echo ($Detail["c"]); ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="j_dialog_tel" class="control-label x90">方法名：</label>
                        <input type="text" name="info[a]" size="20" value="<?php echo ($Detail["a"]); ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="j_dialog_tel" class="control-label x90">图标：</label>
                        <?php if(!empty($Detail["icon"])): ?><i id="icon_img" class="fa fa-<?php echo ($Detail["icon"]); ?>"></i>
                        <?php else: ?>
                        <i id="icon_img"></i><?php endif; ?>
                        <input type="text" id="icon" name="icon" size="20" data-toggle="lookup" data-url="<?php echo U('System/adminNodeIcon');?>" value="<?php echo ($Detail["icon"]); ?>">

                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="j_dialog_profession" class="control-label x90"><?php echo L('order');?>：</label>
                        <input type="text" name="info[listorder]" data-rule="required" size="20" value="<?php echo ((isset($Detail["listorder"]) && ($Detail["listorder"] !== ""))?($Detail["listorder"]):0); ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="j_dialog_display" class="control-label x90">是否显示：</label>
                        <input type="radio" name="info[display]" id="j_dialog_display_yes" value="1" data-toggle="icheck" data-label="显示"  <?php if(((isset($Detail["display"]) && ($Detail["display"] !== ""))?($Detail["display"]):1) == "1"): ?>checked<?php endif; ?>>
                        <input type="radio" name="info[display]" id="j_dialog_display_no" value="0" data-toggle="icheck" data-label="隐藏" <?php if(($Detail["display"]) == "0"): ?>checked<?php endif; ?>>
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