<?php $mod = current_method()['mod']; ?>
<div class="page-container row-fluid">
	<?php getBlock('menu') ?>
	<div class="page-content">
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
					<h3 class="page-title">
						Tường thuật trực tiếp <small><?=$title?></small>
                        <a href="/<?php echo $mod ?>/edit?id=<?=$news_id?>" class="btn black pull-right"><i class="icon-edit" style="margin-right: 8px;"></i> Chỉnh sửa nội dung</a>
					</h3>
					<ul class="breadcrumb">
						<li>
							<i class="icon-home"></i>
							<a href="/">Bảng điều khiển</a> 
							<i class="icon-angle-right"></i>
						</li>
						<li>
							<a href="/<?php echo $mod ?>">Tin tức</a>
							<i class="icon-angle-right"></i>
						</li>
                        <li>
							<a href="/<?php echo $mod ?>">Chỉnh sửa</a>
							<i class="icon-angle-right"></i>
						</li>
						<li><a href="#">Tường thuật trực tiếp</a></li>
					</ul>
				</div>
			</div>
            
			<div class="row-fluid" style="font-family: Arial;">
				<div class="span12">
					
                    <form action="" method="post" enctype="multipart/form-data" class="horizontal-form" id="form_default">
						<div class="row-fluid">
                            
                            <div class="span8">
                                <?php echo isset($msg) ? $msg : ''; ?>
                                <div class="portlet box blue hide box_insert_content">
        							<div class="portlet-title">
        								<div class="caption"><i class="icon-edit"></i> Nhập dữ liệu</div>
        							</div>
        							<div class="portlet-body">
                                        <div class="control-group">
        									<label class="control-label" for="f_action_path">Nội dung cần chèn thêm</label>
        									<div class="controls" style="display: inline-block; width: 100%; overflow: auto;">
        										<textarea name="content" id="f_content" class="tinymce m-wrap span12" rows="15"></textarea>
        									</div>
        								</div>
        							</div>
        						</div>
                                <div class="portlet box blue box_content">
        							<div class="portlet-title">
        								<div class="caption"><i class="icon-bookmark"></i> Nội dung</div>
        							</div>
        							<div class="portlet-body">
                                        <h3 style="font-weight: normal;"><?=$title?></h3>
                                        <p><b><?=$intro?></b></p>
                                        <?=$content?>
        							</div>
        						</div>
                                
                                
							</div>
                            <div class="span4">
                                <div class="portlet box blue">
        							<div class="portlet-title">
        								<div class="caption"><i class="icon-cogs"></i> Công cụ</div>
        							</div>
        							<div class="portlet-body">
                                        <div class="box_content">
                                            <?php if (isset($msg)) {
    echo $msg;
} ?>
                                            
                                            <p style="text-align: center;"><a id="btn_insert_content" class="btn green big">Thêm nội dung <i class="m-icon-big-swapright m-icon-white"></i></a></p>
                                            <div class="alert alert-info">
            									<p><i class="icon-caret-right"></i> <a href="/news/live_sort?id=<?=$news_id?>">Sắp xếp theo thời gian tăng dần</a></p>
                                                <p><i class="icon-caret-right"></i> <a href="/news/live_sort?type=desc&id=<?=$news_id?>">Sắp xếp theo thời gian giảm dần</a></p>
                                            </div>
                                            
                                        </div>
                                        <div class="box_insert_content hide">
                                            <div class="alert alert-block alert-success">
            									<p><label><input type="radio" name="insert_top" value="1" checked="checked" /> Chèn vào trước nội dung</label></p>
                                                <p><label><input type="radio" name="insert_top" value="0" /> Chèn vào cuối nội dung</label></p>
                                            </div>
                                            <div class="control-group">
                                                <span>Giờ xuất bản: </span>
                                                <a href="#" id="btn_push_date">Ngay lập tức</a>
                                                <div>
                                                    <input value="<?=date('h:i A')?>" id="f_push_hour" type="text" class="clockface m-wrap" autocomplete="OFF" spellcheck="OFF" style="width: 100px; background: #FFF; display: none;" />
                                                    <input value="<?=date('d/m/Y')?>" id="f_push_date" type="text" value="" class="datepicker m-wrap" autocomplete="OFF" spellcheck="OFF" style="width: 180px; background: #FFF; text-align: center; display: none;" />
                                                </div>
            								</div>
                                            <div class="control-group row-fluid">
                                                <a href="#" class="btn red" id="btn_cancel">Hủy bỏ</a>
                                                <button type="submit" class="btn green" style="float: right;">Chèn vào nội dung <i class="icon-ok"></i></button>
            								</div>
                                        </div>
        							</div>
        						</div>
                                
							</div>
							<!--/span-->
						</div>
					</form>
                    <br /><br />
                    <br /><br />
				</div>
			</div>
			<!-- END PAGE CONTENT-->
		</div>
		<!-- END PAGE CONTAINER-->
	</div>
	<!-- END PAGE -->    
</div>
<?php getBlock('tinymce'); ?>
<script type="text/javascript">
$(document).ready(function(){
    $('#btn_insert_content').click(function(){
        $('.box_insert_content').removeClass('hide');
        $('.box_content').addClass('hide');
        tinymce.execCommand('mceFocus',false,'f_content');
        return false;
    });
    $('#btn_cancel').click(function(){
        $('.box_insert_content').addClass('hide');
        $('.box_content').removeClass('hide');
        return false;
    });
    $('#btn_push_date').click(function(){
        $(this).hide();
        $('#f_push_date').show().attr('name', 'push_date');
        $('#f_push_hour').show().attr('name', 'push_hour');
        return false;
    });
});
</script>