<?php if (!defined('THINK_PATH')) exit();?><style>
.steps_bar ul { border-left:solid 1px #ccc; overflow:hidden;} 
.steps_bar ul li { float:left; height:60px; padding-right:19px; line-height:60px; text-align:center; background:url(../images/stepbar.png) no-repeat 100% 0 #f1f1f1; font-weight:bold;} 
.steps_bar ul li span { display:block; height:58px; padding:0 30px; background:##f1f1f1; border-top:solid 1px #ccc; border-bottom:solid 1px #ccc;} 
.steps_bar ul li.done { color:#fff; background-position:100% -120px; background-color:#646464;} 
.steps_bar ul li.current_prev { color:#fff; background-position:100% -60px; background-color:#646464;} 
.steps_bar ul li.done span, .steps_bar ul li.current_prev span { background:#646464;} 
.steps_bar ul li.current { color:#fff; background-color:#b70a06;} 
.steps_bar ul li.current span { background:#b70a06;} 
.steps_bar ul li.last { background-position:100% -180px; background-color:transparent;} 
.steps_bar ul li.last span { background:#f1f1f1;} 
.steps_bar ul li.last.current { background-position:100% -240px;} 
.steps_bar ul li.last.current span { background:#b70a06;}
</style>

<div class="bjui-pageHeader">


<div class="steps_bar"> 
<ul> 
<li class="done"><span>STEP 1</span></li> 
<li class="current_prev"><span>STEP 2</span></li> 
<li class="current"><span>STEP 3</span></li> 
<li><span>STEP 4</span></li> 
<li class="last"><span>STEP 5</span></li> 
</ul> 
</div> 
</div>
<div class="bjui-pageContent">
    <form action="/res/admin.php/Training/choose?_=1455961560881" id="j_custom_form" data-toggle="validate" data-alertmsg="false">
        <table class="table table-condensed table-hover" width="100%">
            <tbody>
                <tr>
                    <td>
                        <label class="control-label x100"><?php echo L('applicant_unit');?>：</label>
                        <?php if(empty($applicant_unit)): ?><select data-toggle="selectpicker" name="units[]" data-live-search="true" data-rule="required">
                            <?php if(is_array($unit)): foreach($unit as $key=>$ApplicantUnits): ?><option value="<?php echo ($key); ?>" <?php if(($Detail["applicant_unit_id"]) == $key): ?>selected<?php endif; ?>><?php echo ($ApplicantUnits); ?></option><?php endforeach; endif; ?>
                        </select>
                        <!-- <input type="hidden" name="class.id" class="doc_lookup" size="5">
                        <input type="text" name="class.name" id="j_custom_profession" value="" size="15" data-toggle="lookup" data-url="<?php echo U('Task/ajax_chooseClass');?>" data-group="class" data-width="600" data-height="300" data-rule="required" readonly> -->
                        <?php else: ?>
                        <input type="text" value="" class="form-control" disabled><?php endif; ?>
                        
                    </td>
                </tr>
                <!-- 
                <tr>
                    <td>
                        <label for="j_custom_name" class="control-label x85"><?php echo L('applicant_unit');?>：</label>
                        <input type="text" name="info[applicant_unit]" id="j_custom_name" value="<?php echo ($Detail["applicant_unit"]); ?>" data-rule="required" size="30" class="required">
                    </td>
                    
                </tr>-->
                <tr>
                    <td>
                        <label for="j_custom_name" class="control-label x85"><?php echo L('organizer');?>：</label>
                        <input type="text" name="info[organizer]" id="j_custom_name" value="<?php echo ($Detail["organizer"]); ?>" data-rule="required" size="30" class="required">
                    </td>
                    
                </tr>
                
                <tr>
                    <td colspan="4">
                        <label for="j_custom_content" class="control-label x85"><?php echo L('memo');?>：</label>
                        <div style="display: inline-block; vertical-align: middle;">
                            <textarea name="info[note]" id="j_form_content" class="j-content" style="width: 700px;" data-toggle="kindeditor" data-minheight="200" ><?php echo ($Detail["note"]); ?></textarea>
                        </div>
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