<?php if (!defined('THINK_PATH')) exit();?><script type="text/javascript">
var fileUploader = KindEditor.editor({
    allowFileManager : true,
    uploadJson       : '<?php echo U('Attachment/uploadJson');?>',            //更改默认的上传控件
    fileManagerJson  : '<?php echo U('Attachment/fileManagerJson');?>',  //更改默认的空间控件
});
KindEditor('#a_insertfile').click(function() {
    fileUploader.loadPlugin('insertfile', function() {
        fileUploader.plugin.fileDialog({
            fileUrl : KindEditor('#a_attachment').val(),
            clickFn : function(url, title) {
                KindEditor('#a_attachment').val(url);
                $('#a_attachment_clear').show();
                fileUploader.hideDialog();
            }

        });
    });
});

$("#a_attachment_clear").click(function(){
    $('#a_attachment').val('');
    $('#a_attachment_preview').html('')
    $('#a_attachment_clear').hide();
});
</script>
<div class="bjui-pageContent">
    <form action="/admin.php/Basis/add?_=1465049310082" id="j_custom_form" data-toggle="validate" data-alertmsg="false">
        <input type="hidden" name="info[catid]" value="<?php echo ($catid); ?>">
        <input type="hidden" name="id" value="<?php echo ($Detail["id"]); ?>">
        <input type="hidden" name="check" value="<?php echo ($check); ?>">
        <table class="table table-condensed table-hover" width="100%">
            <tbody>
                <tr>
                    <td>
                        <label for="j_custom_name" class="control-label x85"><?php echo L('title');?>：</label>
                        <input type="text" name="info[title]" id="j_custom_name" value="<?php echo ($Detail["title"]); ?>" data-rule="required" size="30" class="required">
                    </td>                    
                </tr>
                <tr>
                    <td>
                        <label for="j_custom_attachment" class="control-label x85">附件：</label>
                        <input type="text" class="form-control" name="info[attachment]" id="a_attachment" value="<?php echo ($Detail["attachment"]); ?>" readonly/>
                        <input type="button" id="a_insertfile" value="选择文件" />
                        <a href="javascript:;" id="a_attachment_clear" <?php if(empty($Detail["attachment"])): ?>style="display:none;"<?php endif; ?>>取消</a>
                    </td>                    
                </tr>                
                <tr>
                    <td colspan="2">
                        <label for="j_custom_url" class="control-label x85">url：</label>
                        <input type="text" class="form-control" name="info[attachment]" id="a_attachment" value="<?php echo ($Detail["attachment"]); ?>"/>
                    </td>
                </tr>
                <tr>
                	<td>
                        <label for="j_custom_listorder" class="control-label x85">序号：</label>
                        <input type="text" class="form-control" name="info[attachment]" id="a_attachment" value="<?php echo ($Detail["attachment"]); ?>" data-rule="required,digits"/>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>
<div class="bjui-pageFooter">
    <ul>
        <li><button type="button" class="btn-close" data-icon="close"><?php echo L('close');?></button></li>
        <li><button type="submit" class="btn-default" data-icon="save"><?php echo L('save');?></button></li>
    </ul>
</div>