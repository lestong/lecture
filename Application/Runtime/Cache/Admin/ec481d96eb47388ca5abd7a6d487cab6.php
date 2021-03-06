<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageHeader">
    <form id="pagerForm" data-toggle="ajaxsearch" action="/admin.php/Basis/Index?_=1465048305894" method="post">
        <input type="hidden" name="pageSize" value="">
        <input type="hidden" name="pageCurrent" value="">
        <input type="hidden" name="orderField" value="">
        <input type="hidden" name="orderDirection" value="">
        <div class="bjui-searchBar">
            <select name="searchtype" data-toggle="selectpicker">
                <option value="0" selected=""><?php echo L('title');?></option>
            </select>&nbsp;
            <input type="text" id="keyword" value="<?php echo ($keyword); ?>" name="keyword" class="form-control" size="10">&nbsp;
            <button type="submit" class="btn-default" data-icon="search"><?php echo L('btn_search');?></button>&nbsp;
            <a class="btn btn-orange" href="javascript:;" data-toggle="reloadsearch" data-clear-query="true" data-icon="undo"><?php echo L('btn_reload_search');?></a>
            <div class="pull-right">
                <button type="button" class="btn-green" data-url="<?php echo U('Basis/add');?>" data-toggle="navtab" data-id="Basis_edit"><?php echo L('add');?></button>&nbsp;
                <button type="button" class="btn-red" data-url="<?php echo U('Basis/delete');?>" data-toggle="doajaxchecked" data-confirm-msg="<?php echo L('msg_confirm_delete');?>" data-idname="ids" data-group="ids"><?php echo L('del_checked');?></a></button>
            </div>
        </div>
    </form>
</div>
<div class="bjui-pageContent tableContent">
    <table data-toggle="tablefixed" data-width="100%" data-nowrap="true">
        <thead>
            <tr>
                <th width="26"><input type="checkbox" class="checkboxCtrl" data-group="ids" data-toggle="icheck"></th>
                <th width="50" data-order-field="id" align="center">ID</th>
                <th><?php echo L('title');?></th>
                <th width="120" >链接</th>
                <th width="120" >序号</th>
                <th align="center" width="120"><?php echo L('manage');?></th>
            </tr>
        </thead>
        <tbody>
            <?php if(is_array($page_list)): foreach($page_list as $key=>$item): ?><tr data-id="<?php echo ($item["id"]); ?>">
                <td><?php echo ($item["id"]); ?></td>
                <td><a href="<?php echo U('Basis/view?id='.$item['id']);?>" data-toggle="navtab" data-id="Basis_view" data-title="<?php echo ($item["title"]); ?>"><?php echo ($item["title"]); ?></a></td>
                <td><?php echo D('Admin/BasisCategory')->getName($item['sort1']);?> - <?php echo D('Admin/BasisCategory')->getName($item['sort2']);?></td>
                <td><?php echo (getClassName($item["classid"])); ?></td>
                <td align="center"><?php echo (date("Y-m-d",$item["create_time"])); ?></td>
                <td><input type="checkbox" name="ids" data-toggle="icheck" value="<?php echo ($item["id"]); ?>"></td>
                <td align="center">
                    <?php if(!empty($item["edit_enable"])): ?><a class="btn btn-green" href="<?php echo U('Basis/edit?id='.$item['id']);?>" data-toggle="navtab" data-id="Basis_edit" data-title="<?php echo ($item["title"]); ?>"><span><?php echo L('edit');?></span></a>
                    <a class="btn btn-red" href="<?php echo U('Basis/delete?ids='.$item['id']);?>" data-toggle="doajax" data-confirm-msg="<?php echo L('msg_confirm_delete');?>"><span><?php echo L('delete');?></span></a><?php endif; ?>
                </td>
            </tr><?php endforeach; endif; ?>
            
        </tbody>
    </table>
</div>
<div class="bjui-pageFooter">
    <div class="pages">
        <span><?php echo L('pagination_per_page');?>&nbsp;</span>
        <div class="selectPagesize">
            <select data-toggle="selectpicker" data-toggle-change="changepagesize">
                <option value="30" <?php if(($page["pageSize"]) == "30"): ?>selected<?php endif; ?>>30</option>
                <option value="60" <?php if(($page["pageSize"]) == "30"): ?>selected<?php endif; ?>>60</option>
                <option value="120" <?php if(($page["pageSize"]) == "30"): ?>selected<?php endif; ?>>120</option>
                <option value="150" <?php if(($page["pageSize"]) == "30"): ?>selected<?php endif; ?>>150</option>
            </select>
        </div>
        <span>&nbsp;<?php echo L('pagination_count_desc', array('totalCount' => $page['totalCount']));?></span>
    </div>
    <div class="pagination-box" data-toggle="pagination" data-total="<?php echo ($page["totalCount"]); ?>" data-page-size="<?php echo ($page["pageSize"]); ?>" data-page-current="<?php echo ($page["pageCurrent"]); ?>"></div>
</div>