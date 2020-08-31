<div class="page-container row-fluid">
	<?php getBlock('menu') ?>
	<div class="page-content">
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
					<h3 class="page-title">
						Chỉnh sửa bài viết <small><?=$title?></small>
                        <a href="/<?php echo $mod ?>/add" class="btn green pull-right">Thêm mới <i class="icon-plus"></i></a>
                        <?php if ($me['is_push']) {
    ?><a id="btn_open_box_news" href="#" class="btn red pull-right"><i class="icon-plus"></i> Hộp tin</a><?php
} ?>
					</h3>
					<ul class="breadcrumb">
						<li>
							<i class="icon-home"></i>
							<a href="/admin">Bảng điều khiển</a> 
							<i class="icon-angle-right"></i>
						</li>
						<li>
							<a href="/<?php echo $mod ?>">Bài viết</a>
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
                                <?php if ($msg) {
        echo $msg;
    } ?>
                                
                                <div class="well" style="padding: 8px 0; border-left: 0; border-right: 0;">
        							<div class="controls">
										<div>
                                            <button type="submit" class="btn_status btn blue"><i class="icon-ok"></i> Cập nhật</button>
                                        </div>
									</div>
        						</div>
                                
								<div class="row-fluid">
                                    <label class="control-label" for="f_title">Tiêu đề bài viết</label>
									<div class="controls">
										<input name="title" type="text" id="f_title" class="m-wrap span12 required" placeholder="tiêu đề ..." value="<?php echo htmlspecialchars($title) ?>" />
									</div>
								</div>
                                <div class="control-group">
									<label class="control-label" for="f_intro">Mô tả ngắn</label>
									<div class="controls">
                                        <textarea name="intro" id="f_intro" class="m-wrap span12" rows="3" style="margin-bottom: 0;" ><?php echo $intro ?></textarea>
									</div>
								</div>
                                <?php if ($title_detail||$intro_detail) {
    } else {
        ?><div style="text-align: right;" class="root ">+ <a href="#filed_detail" class="btn_open_hide">Tùy chỉnh trang chi tiết</a></div><?php
    } ?>
                                
                                <div class="portlet box blue <?=($title_detail||$intro_detail)?'':'hide'?>" style="margin-top: 18px;" id="filed_detail">
        							<div class="portlet-title">
        								<div class="caption"><i class="icon-pushpin"></i> Tùy chỉnh trang chi tiết</div>
        							</div>
        							<div class="portlet-body">
                                        <div class="control-group">
        									<label class="control-label" for="f_title_detail">Tiêu đề dài</label>
        									<div class="controls">
        										<input name="title_detail" type="text" id="f_title_detail" class="m-wrap span12" value="<?php echo htmlspecialchars($title_detail) ?>" />
        									</div>
        								</div>
                                        <div class="control-group">
        									<label class="control-label" for="f_intro_detail">Mô tả dài</label>
        									<div class="controls">
                                                <textarea name="intro_detail" id="f_intro_detail" class="m-wrap span12" rows="3" ><?php echo $intro_detail ?></textarea>
        									</div>
        								</div>
        							</div>
        						</div>
                                
                                <div class="control-group">
									<label class="control-label" for="f_news_path">Tin liên quan</label>
                                    <div class="js_field_path" data-limit="10" data-class="news" data-name="news_path" data-value="<?php echo $news_path ?>" data-placeholder="Danh sách tin liên quan" ></div>
								</div>
                                <div class="control-group">
									<label style="float: left;" class="control-label" for="f_content">Nội dung</label>
                                    <label style="float: right; font-size: 12px;"><input type="checkbox" name="is_fix_tag" value="1" /> Kiểm tra từ khóa bản sắc</label>
                                    <div class="clearfix"></div>
									<div class="controls">
										<textarea name="content" id="f_content" class="tinymce m-wrap span12" rows="3"><?php echo $content ?></textarea>
									</div>
								</div>
                                <div style="text-align: right;" class="root">+ <a onclick="$('#f_slide').attr('name', 'slide');" href="#field_slide" class="btn_open_hide" id="btn_open_slide">Thêm slide vào đầu bài viết</a></div>
                                
                                <div class="control-group hide" id="field_slide">
									<label class="control-label" for="f_slide">Slide</label>
									<div class="controls">
										<textarea name="" id="f_slide" class="tinymce_gallery m-wrap span12" rows="3">
                                        <?php
                                        if ($slide) {
                                            $oneIMG = explode('[n]', $slide);
                                            if ($oneIMG) {
                                                foreach ($oneIMG as $info) {
                                                    $info = explode('[v]', $info);
                                                    echo '<table class="figure"><tbody><tr><td><img src="'.$info[0].'"></td></tr><tr class="figcaption"><td>'.$info[1].'</td></tr></tbody></table><p> </p>';
                                                }
                                            }
                                        }
                                        ?>
                                        </textarea>
									</div>
								</div>
                                
                                <div class="portlet box blue" style="margin-top: 18px;">
        							<div class="portlet-title">
        								<div class="caption"><i class="icon-globe"></i> Hỗ trợ SEO</div>
        							</div>
        							<div class="portlet-body">
                                        <div class="control-group">
        									<label class="control-label" for="f_slug">Chuỗi ký tự trên thanh URL <small class="label label-success">edit</small></label>
        									<div class="controls">
        										<input disabled="disabled" maxlength="255" name="slug" type="text" id="f_slug" class="m-wrap span12 maxlength required" placeholder="slug" value="<?php echo $slug ?>" />
        									</div>
        								</div>
                                        <div class="control-group">
        									<label class="control-label" for="f_meta_title">Tiêu đề Google</label>
        									<div class="controls">
        										<input maxlength="70" name="meta_title" type="text" id="f_meta_title" class="m-wrap span12 maxlength" value="<?php echo htmlspecialchars($meta_title) ?>" />
        									</div>
        								</div>
                                        <div class="control-group" style="position: relative;">
        									<label class="control-label" for="f_meta_keyword">Từ khóa Google</label>
        									<div class="controls">
                                                <textarea maxlength="255" name="meta_keyword" id="f_meta_keyword" class="m-wrap span12 maxlength" rows="3" ><?php echo $meta_keyword ?></textarea>
        									</div>
                                            <div style="position: absolute;bottom: -13px;right: 0;">+ <a id="btn_copy_keyword" href="#">Sao chép xuống ô dưới</a></div>
        								</div>
                                        <div class="control-group">
                                            <label class="control-label" for="f_tags">Từ khóa CMS</label>
        									<div class="controls" style="display: inline-block; width: 100%;">
        										<input name="tags" type="text" id="f_tags" class="tags m-wrap span12" value="<?php echo $tags ?>" />
        									</div>
                                        </div>
                                        <div class="control-group">
        									<label class="control-label" for="f_meta_description">Mô tả Google</label>
        									<div class="controls">
                                                <textarea maxlength="160" name="meta_description" id="f_meta_description" class="m-wrap span12 maxlength" rows="3" ><?php echo $meta_description ?></textarea>
        									</div>
        								</div>
        							</div>
        						</div>
                                
                                <p>
									<span class="label label-success">NOTE:</span>&nbsp;
									Nhấn <code>Ctrl+S</code> để lưu bài.
								</p>
                                
							</div>
							<!--/span-->
							<div class="span4">
                                <?php getBlock('message'); ?>
                                
                                <div class="portlet box blue">
        							<div class="portlet-title">
        								<div class="caption"><i class="icon-bookmark"></i> Thông tin chung</div>
        							</div>
        							<div class="portlet-body">
                                        <div class="control-group">
                                            
                                            <div class="alert alert-info">
                                                <span class="help-block">Tác giả: <b><?php echo $clsUser->getLashName($user_id) ?></b> viết lúc <b><?php echo date('H:i d/m/y', strtotime($reg_date)) ?></b></span>
                                                <?php if ($last_edit_user) {
                                            ?>
                                                <span class="help-block">Sửa lần cuối: <b><?php echo $clsUser->getLashName($last_edit_user) ?></b> lúc <b><?php echo date('H:i d/m/y', $last_edit) ?></b></span>
                                                <?php
                                        } ?>
                                            </div>
                                            
                                            <?php if ($is_trash==0) {
                                            ?>
                                            <?php if ($status==4) {
                                                ?>
                                                <div class="alert alert-block alert-success fade in">
                									<button type="button" class="close" data-dismiss="alert"></button>
                									<p><i class="icon-caret-right"></i> <a target="_blank" href="https://developers.facebook.com/tools/debug/og/object?q=<?=rawurlencode($clsClassTable->getLink($news_id))?>">Sửa lỗi share Facebook</a></p>
                                                    <p><i class="icon-caret-right"></i> <a href="/history?news_id=<?=$news_id?>" target="_blank">Lịch sử chỉnh sửa bài</a></p>
                								</div>
                                            <?php
                                            } ?>
                                            <div class="controls controls-row">
                                                <a href="/<?php echo $mod ?>/delete?id=<?php echo $_GET['id'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa bài này?');" class="btn_trash">Xóa vĩnh viễn</a>
                                                <?php if ($status==4) {
                                                ?><a href="#" class="btn green pull-right modal_box_news"><i class="icon-plus"></i> Thêm vào Hộp tin</a><?php
                                            } ?>
                                            </div>
                                            <?php
                                        } else {
                                            ?>
                                            <div class="controls controls-row">
                                                <a href="/<?php echo $mod ?>/delete?id=<?php echo $_GET['id'] ?>" title="" class="btn_trash">Xóa vĩnh viễn</a>
                                                <a href="/<?php echo $mod ?>/restore?id=<?php echo $_GET['id'] ?>" class="btn green pull-right"><i class="icon-undo"></i> Phục hồi</a>
                                            </div>
                                            <?php
                                        } ?>
        								</div>
                                        
        							</div>
        						</div>
                                
                                <div class="portlet box blue">
        							<div class="portlet-title">
        								<div class="caption"><i class="icon-picture"></i> Ảnh đại diện</div>
        							</div>
        							<div class="portlet-body">
                                        <div class="controls">
											<div class="fileupload fileupload-new" data-provides="fileupload">
												<div class="fileupload-new thumbnail">
													<img id="img_image_preview" src="<?php if ($image) {
                                            echo MEDIA_DOMAIN.$image;
                                        } else {
                                            echo BASE_ASSET.'images/no-photo.jpg';
                                        } ?>" alt="" />
												</div>
												<div class="fileupload-preview fileupload-exists thumbnail" style="line-height: 20px;"></div>
												<div>
													<span class="btn btn-file"><span class="fileupload-new">Tải lên</span>
													<span class="fileupload-exists">Thay đổi</span>
													<input id="file_image" type="file" class="default" name="image" /></span>
                                                    <input id="txt_image" type="hidden" name="image" disabled="disabled" />
                                                    <a id="btn_get_image_content_next" href="#" class="btn" style="float: right; display: none;"><i class="icon-chevron-right"></i></a>
                                                    <a id="btn_get_image_content" href="#" class="btn green" style="float: right;">Nội dung <span></span></a>
													<a id="btn_get_image_content_prev" href="#" class="btn" style="float: right; display: none;"><i class="icon-chevron-left"></i></a>
                                                    <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Hủy</a>
												</div>
											</div>
											
										</div>

                                        
        							</div>
        						</div>
                                
                                
                                
								<div class="portlet box blue">
        							<div class="portlet-title">
        								<div class="caption"><i class="icon-cogs"></i> Cài đặt</div>
        							</div>
        							<div class="portlet-body">
                                        <table class="table table-bordered table-striped">
        									<tbody>
        										<tr>
        											<td>
        												<div class="toggle_button">
                                                            <input type="hidden" name="is_photo" value="0" />
            												<input name="is_photo" value="1" type="checkbox" class="toggle" <?php if ($is_photo) {
                                            echo 'checked="checked"';
                                        } ?> />
            											</div>
        											</td>
        											<td>Tin ảnh</td>
        										</tr>
                                                <tr>
        											<td>
        												<div class="toggle_button">
                                                            <input type="hidden" name="is_video" value="0" />
            												<input name="is_video" value="1" type="checkbox" class="toggle" <?php if ($is_video) {
                                            echo 'checked="checked"';
                                        } ?> />
            											</div>
        											</td>
        											<td>Tin video</td>
        										</tr>
                                                <tr>
        											<td>
        												<div class="toggle_button">
                                                            <input type="hidden" name="is_full" value="0" />
            												<input name="is_full" value="1" type="checkbox" class="toggle" <?php if ($is_full) {
                                            echo 'checked="checked"';
                                        } ?> />
            											</div>
        											</td>
        											<td>Nội dung rộng</td>
        										</tr>
                                                <tr>
        											<td>
        												<div class="toggle_button">
                                                            <input type="hidden" name="is_ads" value="0" />
            												<input name="is_ads" value="1" type="checkbox" class="toggle" <?php if ($is_ads) {
                                            echo 'checked="checked"';
                                        } ?> />
            											</div>
        											</td>
        											<td>Quảng cáo Google</td>
        										</tr>
                                                <tr>
        											<td>
        												<div class="toggle_button">
                                                            <input type="hidden" name="is_comment" value="0" />
            												<input name="is_comment" value="1" type="checkbox" class="toggle" <?php if ($is_comment) {
                                            echo 'checked="checked"';
                                        } ?> />
            											</div>
        											</td>
        											<td>Bình luận</td>
        										</tr>
                                                <tr>
        											<td>
        												<div class="toggle_button">
                                                            <input type="hidden" name="is_index" value="0" />
            												<input name="is_index" value="1" type="checkbox" class="toggle" <?php if ($is_index) {
                                            echo 'checked="checked"';
                                        } ?> />
            											</div>
        											</td>
        											<td>Google truy vấn</td>
        										</tr>
        									</tbody>
        								</table>
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
<div id="mnu_box_news" class="modal hide fade" data-backdropz="static" data-width="705"></div>
<script type="text/javascript">
$(document).ready(function(){
    $('.fileupload.fileupload-new .thumbnail').on('click',function(){
        return false;
    }).on('mousedown',function(){
        return false;
    }).on('mouseup',function(){
        return false;
    }).on('mousemove',function(){
        return false;
    });
    
    
    /* SAVE CTRL S */
    $(document).keydown(function(event) {
        var currKey=0,e=e||event; 
        currKey=e.keyCode||e.which||e.charCode;  //do this handle FF and IE
        if (!( String.fromCharCode(event.which).toLowerCase() == 's' && event.ctrlKey) && !(event.which == 19)) return true;
        event.preventDefault();
        $('form#form_default').submit();
        return false;
    });
    
    var $modal_box_news = $('#mnu_box_news');
    $('a.modal_box_news').click(function(){
        $('body').modalmanager('loading');
        $modal_box_news.load('/ajax/getListBox?news_id=<?php echo $news_id ?>', '', function(){
            $modal_box_news.modal().on("hidden", function() {
                $modal_box_news.empty();
            });
        });
        return false;
    });
    
    $('label[for=f_slug]').click(function(){
        $(this).unbind('click').find('small').remove();
        $('input[name=slug]').removeAttr('disabled');
    });
    $('#btn_open_box_news').click(function(){
        $('body').click();
        $('body').modalmanager('loading');
        $modal_box_news.load('/ajax/getListBox?news_id=0', '', function(){
            $modal_box_news.modal().on("hidden", function() {
                $modal_box_news.empty();
            });
        });
        return false;
    });
});
</script>
<div id="wrap_js_image_content" class="hide"></div>
<script type="text/javascript">
$(document).ready(function(){
    $("#f_action_path").select2({
        tags: [<?php if ($allUser) {
                                            foreach ($allUser as $key=>$user_id) {
                                                if ($key) {
                                                    echo ',';
                                                }
                                                echo "{id: ".$user_id.", text: '".$clsUser->getFullName($user_id)."'}";
                                            }
                                        } ?>],
        separator: '|'
    });
    $('#btn_copy_keyword').click(function(){
        var str = $('#f_meta_keyword').val();
        $('input[name=tags]').importTags(str);
        return false;
    });
    
    var index_image_content = 1;
    function getImageContent(index) {
        $('.btn.fileupload-exists').click();
        var data = $('#f_content').val();
        $('#wrap_js_image_content').html(data);
        var img = $('#wrap_js_image_content').find('img:eq('+(index_image_content-1)+')').attr('src');
        $('#img_image_preview').attr('src', img);
        var count_img = $('#wrap_js_image_content').find('img').size();
        if(index<=1) $('#btn_get_image_content_prev').hide();
        else if(index<count_img) $('#btn_get_image_content_prev').show();
        if(index>=count_img) $('#btn_get_image_content_next').hide();
        else if(index>0) $('#btn_get_image_content_next').show();
        $('#btn_get_image_content span').html('('+index+'/'+count_img+')');
        $('#txt_image').removeAttr('disabled').val(img);
    }
    $('#btn_get_image_content').click(function(){
        index_image_content = 1;
        getImageContent(index_image_content);
        return false;
    });
    $('#btn_get_image_content_prev').click(function(){
        index_image_content--;
        getImageContent(index_image_content);
        return false;
    });
    $('#btn_get_image_content_next').click(function(){
        index_image_content++;
        getImageContent(index_image_content);
        return false;
    });
    $('#file_image').change(function(){
        if($(this).val()!='') {
            $('#txt_image').attr('disabled', 'disabled');
            index_image_content = 1;
            $('#btn_get_image_content span').html('');
            $('#btn_get_image_content_prev').hide();
            $('#btn_get_image_content_next').hide();
        }
    });
    
    $('.btn_status').click(function(){
        var val = $(this).attr('data-key');
        $('#form_default input[name=status]').val(val);
        $('#form_default').submit();
        return false;
    });
    $('#btn_push_date').click(function(){
        $(this).hide();
        $('input[name=push_date]').show();
        $('input[name=push_hour]').show();
        return false;
    });
});
</script>