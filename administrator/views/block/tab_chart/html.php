<?php $act = current_method()['act']; ?>
<ul class="nav nav-tabs">
    <li class="<?=($act=='index')?'active':''?>"><a href="/chart"><i class="icon-bar-chart"></i> Toàn trang</a></li>
    <li class="<?=($act=='category')?'active':''?>"><a href="/chart/category"><i class="icon-bar-chart"></i> Chuyên mục lớn</a></li>
    <li class="<?=($act=='news')?'active':''?>"><a href="/chart/news"><i class="icon-bar-chart"></i> Bài viết</a></li>
    <li class="<?=($act=='tops')?'active':''?>"><a href="/chart/tops"><i class="icon-bar-chart"></i> Top views</a></li>
</ul>