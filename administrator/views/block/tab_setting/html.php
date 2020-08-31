<?php $mod = current_method()['mod']; ?>
<ul class="nav nav-tabs">
    <li class="<?=($mod=='setting')?'active':''?>"><a href="/setting"><i class="icon-cogs"></i> Cài đặt chung</a></li>
    <li class="<?=($mod=='category')?'active':''?>"><a href="/category"><i class="icon-folder-close"></i> Quản lý chuyên mục</a></li>
    <li class="<?=($mod=='group')?'active':''?>"><a href="/group"><i class="icon-folder-close"></i> Quản lý nhóm quản trị</a></li>
    <li class="<?=($mod=='box')?'active':''?>"><a href="/box"><i class="icon-columns"></i> Hộp tin</a></li>
    <li class="<?=($mod=='page')?'active':''?>"><a href="/page"><i class="icon-paste"></i> Trang tĩnh</a></li>
</ul>