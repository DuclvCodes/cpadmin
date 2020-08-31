<style>
.btn_trash {line-height: 16px; margin-top: 7px; text-decoration: none; border-bottom: 1px solid #d84a38; color: #d84a38; display: inline-block; font-size: 12px; padding: 0 3px;}
.btn_trash:hover {background: #d84a38; color: #FFF !important;}
.tbl_vertical_center td {vertical-align: middle !important;}
#form_default label.lv2 {margin-left: 20px;}
</style>
<div class="page-container row-fluid">
	<?php getBlock('menu') ?>
	<div class="page-content">
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
					<h3 class="page-title">
						Quản lý bình chọn <small><?php echo $title ?></small>
					</h3>
					<ul class="breadcrumb">
						<li>
							<i class="icon-home"></i>
							<a href="/">Bảng điều khiển</a> 
							<i class="icon-angle-right"></i>
						</li>
						<li>
							<a href="/vote">Bình chọn</a>
							<i class="icon-angle-right"></i>
						</li>
						<li><a href="#">Chỉnh sửa</a></li>
					</ul>
				</div>
			</div>
            
			<div class="row-fluid" style="font-family: Arial;">
				<div class="span12">
					
                    <form action="" method="post" enctype="multipart/form-data" class="horizontal-form" id="form_default">
                        <div class="row-fluid">
                                <div class="span8">
                                    <?php if (isset($msg)) {
    echo $msg;
} ?>

                                    <div class="control-group">
                                            <label class="control-label" for="f_title">Tên bình chọn</label>
                                            <div class="controls">
                                                    <input name="title" type="text" id="f_title" class="m-wrap span12 required" placeholder="tiêu đề ..." value="<?php echo $title ?>" />
                                            </div>
                                    </div>

                                    <div class="portlet box blue" style="margin-top: 18px;">
                                        <div class="portlet-title">
                                                <div class="caption"><i class="icon-globe"></i> Câu hỏi</div>
                                        </div>
                                        <div class="portlet-body">
                                        <div class="control-group">
                                            <div class="controls">
                                                    <input type="hidden" name="is_predict" value="0" />
                                                    <input type="hidden" name="vote_id" value="<?=$one['vote_id']?>" />
                                                    <label><input name="is_predict" value="1" type="checkbox" <?php if ($is_predict) {
    echo "checked='checked'";
} ?> style="margin: 0 0 1px;" /> Dự đoán số người trả lời đúng</label>
                                            </div>
                                        </div>
                                        <?php foreach ($answers as $key => $answer) {
    ?>
                                        <div class="control-group">
                                            <div class="controls">
                                                <input name="answers[<?=$key?>]" value="<?=$answer?>" class="m-wrap required" placeholder="Lựa chọn 1" />
                                                <i class="icon-remove js_close hide"></i>
                                            </div>
                                        </div>
                                            <?php
} ?>
                                        <div class="control-group">
                                            <div class="control-label">
                                                <a class="add_choose" href="#"><i class="icon-plus"></i> Lựa chọn khác</a>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                                <!--/span-->
                            <div class="span4">
                                <?php if ($is_trash==0) {
        ?>
                                    <div class="portlet box blue">
                                    <div class="portlet-title">
                                            <div class="caption"><i class="icon-share"></i> Cài đặt</div>
                                    </div>
                                    <div class="portlet-body">

                                        <div class="controls controls-row">
<!--                                            <a href="/vote/trash?id=<?php echo $_GET['id'] ?>" title="" class="btn_trash">Bỏ vào thùng rác</a>-->
                                            <button type="submit" class="btn green pull-right"><i class="icon-save"></i> Cập nhật</button>
                                        </div>                                                                                                                                                     
                                    </div>
                                </div>
                                <?php
    } else {
        ?>
                                <div class="portlet box blue">
                                    <div class="portlet-title">
                                        <div class="caption"><i class="icon-trash"></i> Thùng rác</div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="controls controls-row">
                                            <a href="/vote/delete?id=<?php echo $_GET['id'] ?>" title="" class="btn_trash">Xóa vĩnh viễn</a>
                                            <a href="/vote/restore?id=<?php echo $_GET['id'] ?>" class="btn green pull-right"><i class="icon-undo"></i> Phục hồi</a>
                                        </div>                                                                                                                                                     
                                    </div>
                                    </div>
                                        <?php
    } ?>

                                    </div>

                                    <!--/span-->
                                </div>
                        
                    </form>

                </div>
            </div>
            <!-- END PAGE CONTENT-->
        </div>
        <!-- END PAGE CONTAINER-->
    </div>
    <!-- END PAGE -->    
</div>
<script type="text/javascript">
$(document).ready(function(){
    var i = 3;
    $('.add_choose').click(function(){
        var obj = $(this).parents('.control-group');
        obj.before('<div class="control-group"><div class="controls"><input name="answers[]" value="" class="m-wrap required" placeholder="Lựa chọn '+i+'" /><i class="icon-remove js_close"></i></div></div>');
        event_remove();
        i++;
        if(i==4) $('.icon-remove').removeClass('hide');
        $('.icon-remove:last').parents('.control-group').find('input').focus();
        return false;
    });
    function event_remove() {
        $('.js_close').removeClass('js_close').click(function(){
            $(this).parents('.control-group').remove();
            i--;
            if(i==3) $('.icon-remove').addClass('hide');
            var k = 1;
            $('.icon-remove').each(function(){
                $(this).parents('.control-group').find('input').attr('placeholder', 'Lựa chọn '+k);
                k++;
            });
            return false;
        });
    }
    event_remove();
    $('#frm_vote .required').each(function(){
        var e = $(this).parents('.control-group');
        $(this).keyup(function(){
            if(e.hasClass('error')) e.removeClass('error');
        });
        $(this).change(function(){
            if(e.hasClass('error')) e.removeClass('error');
        });
    });
    $('#frm_vote').submit(function(){
        var is_error = false;
        $(this).find('.required').each(function(){
            var val = $(this).val();
            if(!val || val=='' || val=='0') {
                $(this).parents('.control-group').addClass('error');
                is_error = true;
            }
        });
        if(is_error==true) {
            $(this).find('.error:eq(0) .required').focus();
            alert('Vui lòng nhập đầy đủ thông tin');
            return false;
        }
    });
});
</script>