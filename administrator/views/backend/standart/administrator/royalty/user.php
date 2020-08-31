<style>
#listUsetNB {display: inline-block; width: 100%; margin: 0; padding: 0; list-style: none;}
#listUsetNB li {width: 170px; float: left; margin-right: 20px; background: #f5f5f5; margin-bottom: 13px; box-shadow: 1px 1px 1px rgba(0,0,0,0.2); border-radius: 3px !important;}
#listUsetNB .photo img {border-top-left-radius: 3px !important; border-top-right-radius: 3px !important;}
#listUsetNB .title {padding: 8px 8px 0 8px; margin: 0;}
#listUsetNB .title a {font-size: 14px; color: #666; font-weight: bold;}
#listUsetNB .title a:hover {color: #427fed; text-decoration: underline;}
#listUsetNB .email {margin: 0 8px; font-size: 11px; color: #999;}
#listUsetNB .royalty {margin: 3px 8px 16px;}
#listUsetNB .royalty .btn {width: 126px;}
</style>
<?php $act = current_method()['act']; ?>
<?php $mod = current_method()['mod']; ?>
<div class="page-container row-fluid">
	<?php getBlock('menu') ?>
	<div class="page-content">
		<div class="container-fluid">
            <br />
            <?php getBlock('tab_royalty') ?>
            
			<h3 class="page-title" style="margin-top: 0; text-align: center;">
                Tổng kết nhuận bút các nhân sự
            </h3>
            <form class="form-search" action="" method="get">
				<input type="hidden" name="mod" value="<?php echo $mod ?>" />
                <input type="hidden" name="act" value="<?php echo $act ?>" />
				<div class="btn form-date-range">
					<i class="icon-calendar"></i>
					&nbsp;<span></span> 
					<b class="caret"></b>
                    <input name="txt_start" value="<?=$txt_start?>" class="txt_start" type="hidden" />
                    <input name="txt_end" value="<?=$txt_end?>" class="txt_end" type="hidden" />
				</div>
				<button type="submit" class="btn green">Lọc &nbsp; <i class="m-icon-swapright m-icon-white"></i></button>
                <button id="btn_send_all" type="button" class="btn blue pull-right"><i class="icon-envelope-alt"></i> Gửi email đến toàn bộ nhân sự</button>
			</form>
            
            <div id="wrap_sending" style="display: none;">
                <p style="margin: 0; font-family: Arial; color: #888;">Đang gửi ... <span class="name" style="float: right;"></span></p>
                <div class="progress progress-striped active">
    				<div style="width: 0%;" class="bar"></div>
    			</div>
            </div>
            
			<div class="row-fluid" style="font-family: Arial;">
				<ul id="listUsetNB">
                    <?php if ($res) {
    foreach ($res as $user_id=>$royalty) {
        if (!$royalty) {
            break;
        }
        $oneUser = $clsUser->getOne($user_id); ?>
                    <li data-id="<?=$user_id?>" class="js">
                        <a href="#" target="_blank" class="photo">
                            <img src="<?=$clsUser->getImage($user_id, 170, 150)?>" />
                        </a>
                        <p class="title"><a href="#" target="_blank" id="txtFullname<?=$user_id?>"><?=$oneUser['fullname']?></a></p>
                        <p class="email"><?=$oneUser['email']?></p>
                        <p class="royalty"><a href="#" class="btn blue"><?=toString($royalty)?> VNĐ</a></p>
                    </li>
                    <?php
    }
} ?>
                </ul>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    function sendMail(user_id) {
        var total = $('#listUsetNB li').size();
        var left = $('#listUsetNB li.js').size();
        $('#wrap_sending .name').text($('#txtFullname'+user_id).text());
        $.ajax({
    		type: "GET",
    		url: "/royalty/sendMail&txt_start=<?=$txt_start?>&txt_end=<?=$txt_end?>",
    		data:  {user_id: user_id},
    		dataType: "html",
    		success: function(msg){
    			if(msg==0) {
                    $('#wrap_sending').hide();
                    $('#listUsetNB li').addClass('js');
                    $('#wrap_sending .bar').width('0%');
                    alert('ERROR');
    			}
                else if(msg==1) {
                    $('#wrap_sending .bar').width(((total-left)/total*100)+'%');
                    var obj = $('#listUsetNB li.js:eq(0)');
                    if(obj.length>0) {
                        obj.removeClass('js');
                        var user_id = obj.attr('data-id');
                        setTimeout(function(){
                            sendMail(user_id);
                        }, 500);
                    }
                    else {
                        setTimeout(function(){
                            $('#wrap_sending').hide();
                            $('#listUsetNB li').addClass('js');
                            $('#wrap_sending .bar').width('0%');
                        }, 1000);
                    }
                }
    		},
            error: function(request,error) {alert("Can't do because: " + error );}
    	});
        return true;
    }
    $('#btn_send_all').click(function(){
        $(this).blur();
        if(confirm('Hành động này sẽ gửi email đến toàn bộ nhân sự. Bạn có muốn tiếp tục?')) {
            var obj = $('#listUsetNB li.js:eq(0)');
            obj.removeClass('js');
            var user_id = obj.attr('data-id');
            $('#wrap_sending').show();
            sendMail(user_id);
        }
        return false;
    });
});
</script>