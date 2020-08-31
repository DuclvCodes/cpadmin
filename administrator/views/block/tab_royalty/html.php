<?php $act = current_method()['act']; ?>
<ul class="nav nav-tabs">
    <li class="<?=($act=='index')?'active':''?>"><a href="/royalty"><i class="icon-bar-chart"></i> Tổng quan</a></li>
    <?php $clsUser=new User_model(); if ($clsUser->permission('emailnb')) {
    ?>
    <li class="<?=($act=='user')?'active':''?>"><a href="/royalty/user"><i class="icon-bar-chart"></i> Gửi email</a></li>
    <?php
} ?>
</ul>