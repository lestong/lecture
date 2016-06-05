<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageContent">
    <form action="/res/admin.php/Training/addApplicantUnit/?_=1455948637210" id="j_custom_form" data-toggle="validate" data-alertmsg="false">
        <table class="table table-condensed table-hover" width="100%">
            <tbody>
                <tr>
                    <td>
                        <label for="j_custom_name" class="control-label x85"><?php echo L('applicant_unit');?>：</label>
                        <input type="text" name="info[applicant_unit]" id="j_custom_name" value="<?php echo ($Detail["applicant_unit"]); ?>" data-rule="required" size="30" class="required">
                    </td>
                    
                </tr>
             <!--  
                <tr>
                    <td colspan="4">
                        <label for="j_custom_content" class="control-label x85"><?php echo L('memo');?>：</label>
                        <div style="display: inline-block; vertical-align: middle;">
                            <textarea name="info[note]" id="j_form_content" class="j-content" style="width: 70px;" data-toggle="kindeditor" data-minheight="200" ><?php echo ($Detail["note"]); ?></textarea>
                        </div>
                    </td>
                </tr>-->
                <tr>
                    <td>
                        <label for="j_custom_content" class="control-label x85"><?php echo L('memo');?>：</label>
                        <textarea name="info[note]" id="j_form_content" data-toggle="autoheight" cols="30"><?php echo ($Detail["note"]); ?></textarea>
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