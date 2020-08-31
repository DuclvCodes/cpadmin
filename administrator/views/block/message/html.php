<?php if ($news_id) {
    ?>
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption"><i class="icon-comment"></i> Thảo luận</div>
	</div>
	<div class="portlet-body">
        <ul class="chats" id="list_log_news">
            <?php
                $clsNews = new News_model();
    $oneNews = $clsNews->getOne($news_id);
    $path_user = array();
    $path_user[$oneNews['user_id']] = $oneNews['user_id']; ?>
            <?php if ($allLog) {
        foreach ($allLog as $log_id) {
            $oneLog = $clsLog->getOne($log_id);
            $path_user[$oneLog['user_id']] = $oneLog['user_id']; ?>
			<li class="<?=($user_id==$oneLog['user_id'])?'out':'in'?>">
				<img class="avatar" alt="" src="<?php echo $clsUser->getImage($oneLog['user_id'], 45, 45, 'image', '/files/User/noavatar.jpg') ?>" width="45" height="45" />
				<div class="message">
					<span class="arrow"></span>
					<a href="#" class="name"><?php echo $clsUser->getLashName($oneLog['user_id']) ?></a>
					<span class="datetime">at <?php echo date(DATETIME_FORMAT, strtotime($oneLog['reg_date'])) ?></span>
					<span class="body"><?php echo $oneLog['title'] ?></span>
				</div>
			</li>
            <?php
        }
    } ?>
		</ul>
        <div class="chat-form">
			<div class="input-cont">   
				<input id="txt_input_log" class="m-wrap" type="text" placeholder="Type a message here..." maxlength="255" />
			</div>
			<div class="btn-cont"> 
				<span class="arrow"></span>
				<a id="btn_add_log" href="" data-path="<?php echo implode('|', $path_user) ?>" data-avatar="<?php echo $clsUser->getImage($user_id, 45, 45, 'image', '/files/User/noavatar.jpg') ?>" data-name="<?php echo $clsUser->getLashName($user_id) ?>" data-regdate="<?php echo date(DATETIME_FORMAT) ?>" data-id="<?php echo $news_id ?>" class="btn blue icn-only"><i class="icon-ok icon-white"></i></a>
			</div>
		</div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    var k = 0;
    $('#btn_add_log').click(function(){
        k++;
        var title = $('#txt_input_log').val(); $('#txt_input_log').val('');
        if(title!='') {
            var avatar = $(this).attr('data-avatar');
            var name = $(this).attr('data-name');
            var regdate = $(this).attr('data-regdate');
            var news_id = $(this).attr('data-id');
            var path = $(this).attr('data-path');
            $('#list_log_news').append('<li id="me_send_'+k+'" class="out"><img class="avatar" alt="" src="'+avatar+'" width="45" height="45" /><div class="message"><span class="arrow"></span><a href="#" class="name">'+name+'</a><span class="datetime"> at '+regdate+'</span><span class="body">'+title+'</span></div></li>');
            $.ajax({
        		type: "POST",
        		url: "/api/addLog",
        		data:  {news_id: news_id, title: title, path: path},
        		dataType: "html",
        		success: function(msg){
        			if(msg!='1') {alert(msg); $('#me_send_'+k).remove();}
        		}
        	});
        }
        return false;
    });
    $('#txt_input_log').keyup(function(e){
        if(e.which==13) {
            $('#btn_add_log').click();
            return false;
        }
    });
});
</script>
<?php
} ?>