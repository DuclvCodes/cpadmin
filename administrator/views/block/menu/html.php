<div class="page-sidebar nav-collapse collapse" style="font-family: Arial;">
	<!-- BEGIN SIDEBAR MENU -->        
	<ul class="page-sidebar-menu">
            <li>
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                <div class="sidebar-toggler hidden-phone"></div>
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            </li>
            <li>
            <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
            <form class="sidebar-search" method="get" action="/search">
            <input type="hidden" name="mod" value="news" />
                    <div class="input-box">
                        <a href="javascript:;" class="remove"></a>
                        <input name="keyword" type="text" placeholder="Tìm kiếm..." />
                        <input type="button" class="submit" value=" " />
                    </div>
            </form>
            <!-- END RESPONSIVE QUICK SEARCH FORM -->
            </li>
            <?php
                $this->load->model('User_model'); $clsUser = new User_model();
                $mod = current_method()['mod'];
                if ($menu_top) {
                    foreach ($menu_top as $key=>$one) {
                        $allMenu = $clsUser->getMenu($one['mod'], $mod); ?>
            <li class="<?php if (!$key) {
                            echo 'start';
                        }
                        if ($mod==$one['mod']) {
                            echo ' active';
                        } ?>">
                <a href="/<?php echo $one['mod'] ?>">
                <i class="icon-<?php echo $clsUser->getIconMenu($one['mod']) ?>"></i> 
                <span class="title"><?php echo $one['title'] ?></span>
                <?php if ($allMenu) {
                            if ($mod==$one['mod']) {
                                echo '<span class="selected"></span><span class="arrow open"></span>';
                            } else {
                                echo '<span class="arrow"></span>';
                            }
                        } ?>
                </a>
                <?php if ($allMenu) {
                            ?>
                <ul class="sub-menu">
                    <?php foreach ($allMenu as $o) {
                                ?>
                        <li class="<?php if ($o[2]) {
                                    echo 'active';
                                } ?>" id="menu_mod_<?php echo $one['mod'].str_replace('&', '_', str_replace('=', '_', $o[0])); ?>">
                                <a href="/<?php echo $one['mod'] ?><?php echo $o[0] ?>">
                                <?php echo $o[1] ?></a>
                        </li>
                    <?php
                            } ?>
                </ul>
                <?php
                        } ?>
            </li>
            <?php
                    }
                } ?>
        </ul>
	<!-- END SIDEBAR MENU -->
</div>