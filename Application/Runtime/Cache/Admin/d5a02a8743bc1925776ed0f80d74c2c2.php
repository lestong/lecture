<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageHeader">
    <!-- <a href="<?php echo U('System/adminRoleAdd');?>" class="btn btn-green" data-toggle="dialog" data-width="520" data-height="188" data-mask="true">添加角色</a> -->
</div>
<div class="bjui-pageContent tableContent">
    <table class="table table-bordered table-hover table-striped table-top" data-selected-multi="true">
        <thead>
            <tr>
                <th width="50">ID</th>
                <th width="150"><?php echo L('role');?></th>
                <th><?php echo L('description');?></th>
                <!-- <th width="120" align="center"><?php echo L('open');?></th> -->
                <th width="300" align="center"><?php echo L('manage');?></th>
            </tr>
        </thead>
        <tbody>
            <?php if(is_array($page_list)): foreach($page_list as $key=>$item): ?><tr data-id="<?php echo ($item[roleid]); ?>">
                <td><?php echo ($item[roleid]); ?></td>
                <td><?php echo ($item[rolename]); ?></td>
                <td><?php echo ($item[description]); ?></td>
                <!-- <td align="center">
                    <a title="确认启用或禁用该角色吗？" data-toggle="doajax" data-confirm-msg="确定要删除该管理员吗？" href="<?php echo U('System/adminRoleForbid');?>/roleid/<?php echo ($item[roleid]); ?>/disabled/<?php echo ($item[disabled]); ?>/pc_hash/<?php echo ($pc_hash); ?>">
                        <?php if(($item[disabled]) == "1"): ?>是<?php else: ?>否<?php endif; ?>
                    </a>
                </td> -->
                <td align="center">
                    <?php if(($item["roleid"]) > "1"): ?><a class="btn btn-green" href="<?php echo U('System/adminPrivSetting?roleid='.$item['roleid']);?>" data-toggle="dialog" mask="true" data-width="520" data-height="450">权限设置</a> | <a class="btn btn-green"href="<?php echo U('System/adminRoleEdit?roleid='.$item['roleid']);?>" data-toggle="dialog" mask="true" data-width="520" data-height="188"><?php echo L('edit');?></a> <!--| <a href="<?php echo U('System/adminRoleDelete');?>/roleid/<?php echo ($item[roleid]); ?>/pc_hash/<?php echo ($pc_hash); ?>" data-toggle="doajax" data-confirm-msg="确定要删除该角色吗？"><span>删除</span></a> -->
                    <?php else: ?>
                        <button class="btn btn-default">权限设置</button>  | <button class="btn btn-default"><?php echo L('edit');?></button> <!-- | <font color="#cccccc"><?php echo L('delete');?></font> --><?php endif; ?>
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