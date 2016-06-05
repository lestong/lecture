<?php if (!defined('THINK_PATH')) exit();?><ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
    <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
    <li class="sidebar-toggler-wrapper">
        <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
        <div class="sidebar-toggler"></div> <!-- END SIDEBAR TOGGLER BUTTON -->
    </li>
    <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
    <?php if(is_array($menu_list)): foreach($menu_list as $key=>$item): ?><li class="start <?php if(($item["c"]) == CONTROLLER_NAME): ?>active open<?php endif; ?>"><a href="javascript:;"><i class="icon-home"></i><span class="title"><?php echo ($item["name"]); ?></span><span class="arrow <?php if(($item["c"]) == CONTROLLER_NAME): ?>open<?php endif; ?>"></span></a>
        <ul class="sub-menu">
            <?php if(is_array($item["_child"])): foreach($item["_child"] as $key=>$child): ?><li class="<?php if(($child['c'] == CONTROLLER_NAME) AND ($child['a'] == ACTION_NAME)): ?>active<?php endif; ?>"><a href="<?php echo U($child['c'].'/'.$child['a']);?>"><i class="icon-bar-chart"></i><?php echo ($child["name"]); ?></a></li><?php endforeach; endif; ?>
        </ul>
    </li><?php endforeach; endif; ?>
</ul>