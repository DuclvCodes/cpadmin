<?php $mod = current_method()['mod']; ?>
<ul class="nav nav-tabs">
    <li class="<?=($mod=='ads')?'active':''?>"><a href="/ads"><i class="icon-cogs"></i> Vùng quảng cáo</a></li>
    <li class="<?=($mod=='code')?'active':''?>"><a href="/code"><i class="icon-folder-close"></i> Đối tác quảng cáo</a></li>
    <li class="<?=($mod=='tvc')?'active':''?>"><a href="/tvc"><i class="icon-folder-close"></i> TVC</a></li>
</ul>