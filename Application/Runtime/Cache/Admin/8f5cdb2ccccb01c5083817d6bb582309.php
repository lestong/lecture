<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageHeader">
    <form id="pagerForm" data-toggle="ajaxsearch" action="/admin.php/System/adminManage?_=1465046996577" method="post">
        <input type="hidden" name="pageSize" value="${model.pageSize}">
        <input type="hidden" name="pageCurrent" value="${model.pageCurrent}">
        <input type="hidden" name="orderField" value="${param.orderField}">
        <input type="hidden" name="orderDirection" value="${param.orderDirection}">
        <div class="bjui-searchBar">
            <label><?php echo L('username');?>：</label><input type="text" id="username" value="<?php echo ($username); ?>" name="username" class="form-control" size="10">&nbsp;
            <label><?php echo L('role');?>:</label>
            <select name="roleid" data-toggle="selectpicker">
                <option value=""><?php echo L('select_all_role');?></option>
                <?php if(is_array($roles)): foreach($roles as $key=>$role): ?><option value="<?php echo ($key); ?>" <?php if(($roleid) == $key): ?>selected<?php endif; ?> ><?php echo ($role[rolename]); ?></option><?php endforeach; endif; ?>
            </select>&nbsp;
            <button type="submit" class="btn-default" data-icon="search"><?php echo L('btn_search');?></button>&nbsp;
            <a class="btn btn-orange" href="javascript:;" data-toggle="reloadsearch" data-clear-query="true" data-icon="undo"><?php echo L('btn_reload_search');?></a>
            <div class="pull-right">
                <button type="button" class="btn-green" data-url="<?php echo U('System/adminAdd');?>/" data-toggle="dialog" mask="true" data-width="520" data-height="188" data-icon="plus">添加管理员</button>&nbsp;
                <div class="btn-group">
                    <button type="button" class="btn-default dropdown-toggle" data-toggle="dropdown" data-icon="copy"><?php echo L('operation_batch');?><span class="caret"></span></button>
                    <ul class="dropdown-menu right" role="menu">
                        <li><a href="<?php echo U('System/adminDelete');?>" data-toggle="doajaxchecked" data-confirm-msg="<?php echo L('msg_confirm_delete');?>" data-idname="ids" data-group="ids"><?php echo L('del_checked');?></a></li>
                    </ul>
                </div>
                
            </div>
        </div>
    </form>
</div>
<div class="bjui-pageContent tableContent">
    <table data-toggle="tablefixed" data-width="100%" data-nowrap="true">
        <thead>
            <tr>
                <th width="26"><input type="checkbox" class="checkboxCtrl" data-group="ids" data-toggle="icheck"></th>
                <th width="50">ID</th>
                <th width="120"><?php echo L('username');?></th>
                <th width="120"><?php echo L('role');?></th>
                <th><?php echo L('name');?></th>
                <th width="120" align="center">最后登录IP</th>
                <th width="120" align="center">最后登录时间</th>
                <th width="150" align="center"><?php echo L('manage');?></th>
            </tr>
        </thead>
        <tbody>
            <?php if(is_array($page_list)): foreach($page_list as $key=>$item): ?><tr data-id="<?php echo ($item["userid"]); ?>">
                <td><input type="checkbox" name="ids" data-toggle="icheck" value="<?php echo ($item["userid"]); ?>"></td>
                <td><?php echo ($item["userid"]); ?></td>
                <td><?php echo ($item["username"]); ?></td>
                <td><?php echo ($roles[$item['roleid']]['rolename']); ?></td>
                <td><?php echo ($item["nickname"]); ?></td>
                <td align="center"><?php echo ($item["last_login_ip"]); ?></td>
                <td align="center"><?php if(!empty($item["last_login_time"])): echo (date("Y-m-d",$item["last_login_time"])); endif; ?></td>
                <td align="center">
                    <a class="btn btn-green" href="<?php echo U('System/adminEdit?userid='.$item['userid']);?>" data-toggle="dialog" mask="true" data-width="520" data-height="188"><span><?php echo L('edit');?></span></a> | 
                    <?php if(($item["userid"]) > "1"): ?><a class="btn btn-green" title="密码将重置为1q2w3e4" href="<?php echo U('System/adminResetPassword?userid='.$item['userid']);?>" data-toggle="doajax" data-confirm-msg="确定要重置密码吗？">重置密码</a> | <a class="btn btn-green" href="<?php echo U('System/adminDelete?ids='.$item['userid']);?>" data-toggle="doajax" data-confirm-msg="<?php echo L('msg_confirm_delete');?>"><?php echo L('delete');?></a>
                    <?php else: ?>
                        <button class="btn btn-default">重置密码</button> | <button class="btn btn-default"><?php echo L('delete');?></button><?php endif; ?>
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