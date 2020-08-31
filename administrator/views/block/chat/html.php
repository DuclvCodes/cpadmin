<li class="dropdown" id="header_inbox_bar">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"><i class="icon-envelope"></i><span class="badge" id="lbl_sum_message"><?php $sum = array_sum($chat_read); if ($sum>0) {
    echo $sum;
} ?></span></a>
    
    <ul class="dropdown-menu extended inbox" id="wrap_chat_listuser" data-user="_<?=implode('_', $allUser)?>_" style="width: 518px !important;">
		<li>
			<ul class="dropdown-menu-list scroller" style="height:309px">
				
                <?php $showed = array(); $showed[$me_id] = $me_id; if ($allRoom) {
    foreach ($allRoom as $room_id) {
        $oneRoom = $clsRoom->getOne($room_id); ?>
                
					<?php if ($oneRoom['is_multi']) {
            ?>
                        <li>
                            <a href="#" class="btn_ichat" data-id="<?=$oneRoom['user_path']?>">
                                <span class="photo" style="float: left;"><i class="icon-group" style="font-size: 34px;color: #999;"></i></span>
                                <span class="subject">
                                    <span class="from"><?php echo $clsRoom->getRoomName($room_id); ?></span>
                                    <span class="time"><?=$core->time_ago(strtotime($oneRoom['last_update']))?></span>
                                </span>
                                <span class="message"><?=$oneRoom['last_message']?></span> 
                                <?php if (isset($chat_read[$room_id]) && $chat_read[$room_id]>0) {
                echo '<span class="badge">'.$chat_read[$room_id].'</span>';
            } ?> 
                            </a>
                        </li>
                    <?php
        } else {
            $user_id = intval(trim(str_replace('_'.$me_id.'_', '_', $oneRoom['user_path']), '_'));
            $showed[$user_id] = $user_id; ?>
                        <li id="exp_oneuser_<?=$user_id?>">
                            <a href="#" class="btn_ichat" data-id="<?='_'.min($me_id, $user_id).'_'.max($me_id, $user_id).'_'?>">
                                <span class="photo"><img src="<?php echo $clsUser->getImage($user_id, 55, 55, 'image', '/files/User/noavatar.jpg') ?>" alt="" /></span>
            					<span class="subject">
                					<span class="from"><?php echo $clsUser->getLashName($user_id) ?></span>
                					<span class="time"><?=$core->time_ago(strtotime($oneRoom['last_update']))?></span>
            					</span>
                                <span class="message"><?=$oneRoom['last_message']?></span>
                                <?php if (isset($chat_read[$room_id]) && $chat_read[$room_id]>0) {
                echo '<span class="badge">'.$chat_read[$room_id].'</span>';
            } ?>
        					</a>
                        </li>
                    <?php
        } ?>
					
                <?php
    }
} ?>
                
                <?php if ($allUser) {
    foreach ($allUser as $user_id) {
        if (!in_array($user_id, $showed)) {
            $oneUser = $clsUser->getOne($user_id); ?>
                <li id="exp_oneuser_<?=$user_id?>">
					<a href="#" class="btn_ichat" data-id="<?='_'.min($me_id, $user_id).'_'.max($me_id, $user_id).'_'?>">
    					<span class="photo"><img src="<?php echo $clsUser->getImage($user_id, 55, 55, 'image', '/files/User/noavatar.jpg') ?>" alt="" /></span>
    					<span class="subject">
        					<span class="from"><?php echo $clsUser->getLashName($user_id) ?></span>
        					<span class="time">&nbsp;</span>
    					</span>
    					<span class="message">&nbsp;</span>  
					</a>
				</li>
                <?php
        }
    }
} ?>
			</ul>
		</li>
	</ul>
</li>