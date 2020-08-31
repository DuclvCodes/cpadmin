<?php $act = current_method()['act']; ?>
<ul class="nav nav-tabs">
    <li class="<?=($act=='index')?'active':''?>"><a href="/report"><i class="icon-bar-chart"></i> Số lượng bài viết theo chuyên mục</a></li>
    <li class="<?=($act=='user')?'active':''?>"><a href="/report/user"><i class="icon-bar-chart"></i> Số lượng bài viết theo nhân sự</a></li>
</ul>