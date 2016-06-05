<?php if (!defined('THINK_PATH')) exit();?><script type="text/javascript">

function returnJSON() {
    return <?php echo ($json_priv); ?>
}

$("#submit_priv").click(function(){
	var treeObj = $.fn.zTree.getZTreeObj("ztree1");
    var nodes = treeObj.getCheckedNodes(true);
    var ids='';
    //拼凑
    $.each(nodes, function(key, item){
        ids += (ids ? ',' + item.id : item.id);
    });

    $.ajax({
        type: "post",
        url: '/res/admin.php/System/adminPrivSetting/roleid/2?_=1455951499843',
        dataType: "json",
        data : {
            ids : ids,
        },
        success: function(data) {
        	$(this).alertmsg('ok', <?php echo L('message_success_save');?>);
        }
    });
    console.log(ids);
});

</script>
<div class="bjui-pageContent">
    <div style="padding:20px;">
        <div class="clearfix">
            <div style="float:left; overflow:auto;">
                <ul id="ztree1" class="ztree" data-toggle="ztree" data-check-enable="true"
                    data-options="{
                        expandAll: true,
                        nodes:'returnJSON'
                    }"
                ></ul>
            </div>
        </div>
    </div>
</div>
<div class="bjui-pageFooter">
    <ul>
        <li><button type="button" class="btn-close" data-icon="close"><?php echo L('close');?></button></li>
        <li><button type="button" class="btn-default" id="submit_priv" data-icon="save"><?php echo L('save');?></button></li>
    </ul>
</div>