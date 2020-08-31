<style>
#wrap_images .control-group {width: 180px; float: left; margin-right: 8px;}
#wrap_images .fileupload .btn {padding: 4px 10px !important;}
#wrap_images .thumbnail {line-height: 20px; height: 107px;}
.frm_image {display: inline-block; width: 188px; height: 190px; overflow: hidden;}
</style>
<div class="page-container row-fluid">
	<?php getBlock('menu') ?>
	<div class="page-content">
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
					<h3 class="page-title">
						Chỉnh sửa bài viết <small><?=$title?></small>
                        <a href="/<?php echo $mod ?>/add" class="btn green pull-right">Thêm mới <i class="icon-plus"></i></a>
					</h3>
					<ul class="breadcrumb">
						<li>
							<i class="icon-home"></i>
							<a href="/admin">Bảng điều khiển</a> 
							<i class="icon-angle-right"></i>
						</li>
						<li>
							<a href="/<?php echo $mod ?>">Báo giấy</a>
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
							<div class="span12">
                                <?php if ($msg) {
    echo $msg;
} ?>
                                <div>
    								<div class="control-group">
                                        <div class="span3">
                                            <label class="control-label" for="f_title">Tờ Báo</label>
        									<div class="controls">
        										<select name="category_id" class="m-wrap span12">
                                                    <?php $allCate = $clsClassTable->getAllCate(); if ($allCate) {
    foreach ($allCate as $key=>$oneCate) {
        ?>
                                                    <option <?php if ($key==$category_id) {
            echo 'selected="selected"';
        } ?> value="<?=$key?>"><?=$oneCate?></option>
                                                    <?php
    }
} ?>
                                                </select>
        									</div>
                                        </div>
                                        <div class="span1">
                                            <label class="control-label" for="f_title">Số báo</label>
        									<div class="controls">
        										<input name="title" type="text" id="f_title" class="m-wrap span12 required" value="<?php echo $title ?>" />
        									</div>
                                        </div>
                                        <div class="span2">
                                            <label class="control-label" for="f_num_page">Ngày phát hành</label>
        									<div class="controls">
        										<input name="reg_date" value="<?=date('d/m/Y', strtotime($reg_date))?>" type="text" value="" class="datepicker m-wrap span12" autocomplete="OFF" spellcheck="OFF" />
        									</div>
                                        </div>
                                        <div class="span1">
                                            <label class="control-label" for="f_num_page">Số trang</label>
        									<div class="controls">
        										<input name="num_page" type="text" id="f_num_page" class="m-wrap span12 required" value="<?=$num_page?>" />
        									</div>
                                        </div>
                                        <div class="span5">
                                            <label class="control-label">&nbsp;</label>
                                            <div class="controls">
                                                <?php if ($is_trash) {
    ?>
                                                    <a href="/<?=$mod?>/restore?id=<?=$library_id?>" class="btn blue"><i class="icon-undo"></i> Phục hồi</a>
                                                    <a href="/<?=$mod?>/delete?id=<?=$library_id?>" class="btn red"><i class="icon-remove"></i> Xóa vĩnh viễn</a>
                                                <?php
} else {
        ?>
                                                    <button type="submit" class="btn red"><i class="icon-ok"></i> <?=$is_draf?'Xuất bản':'Cập nhật'?></button>
                                                    <?php if (!$is_draf) {
            ?><a href="<?=str_replace('cms.', 'www.', $clsClassTable->getLink($library_id))?>" class="btn" target="_blank">Xem nhanh</a><?php
        } ?>
                                                    <a href="/<?=$mod?>/trash?id=<?=$library_id?>" style="margin-left: 8px;"><?=$is_draf?'Hủy bỏ':'Xóa bản ghi này'?></a>
                                                <?php
    } ?>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
    								</div>
                                    <div class="control-group">
                                        <input type="hidden" name="is_cover" value="0" />
                                        <input type="hidden" name="is_pl" value="0" />
                                        <label class="checkbox"><input name="is_cover" <?php if ($is_cover) {
        echo 'checked="checked"';
    } ?> type="checkbox" value="1" /> Có ảnh bìa</label>
                                        <label class="checkbox"><input name="is_pl" <?php if ($is_pl) {
        echo 'checked="checked"';
    } ?> type="checkbox" value="1" /> Có trang phụ lục</label>
                                    </div>
                                </div>
                                
							</div>
							<!--/span-->
						</div>
                        <input type="hidden" name="is_draf" value="0" />
					</form>
                    
                    <div class="tabbable tabbable-custom">
    					<ul class="nav nav-tabs">
    						<li class="active"><a href="#tab_1_2" data-toggle="tab">Upload file tiêu chuẩn</a></li>
                            <li><a href="#tab_1_1" data-toggle="tab">Upload từng trang</a></li>
                            <li><a href="#tab_1_3" data-toggle="tab">Chèn thêm</a></li>
    					</ul>
    					<div class="tab-content">
    						<div class="tab-pane" id="tab_1_1">
    							<div id="wrap_images">
                                    <?php for ($i=1; $i<=$NUM_PAPER; $i++) {
        ?>
                                    <form class="frm_image" action="/<?=$mod?>/updateImage?id=<?=$_GET['id']?>" method="post" enctype="multipart/form-data">
                                        <div class="control-group">
                                            <label class="control-label" for="f_title">Trang <?=$i?></label>
                                            <div class="controls">
                    							<div class="fileupload fileupload-new" data-provides="fileupload">
                    								<div class="fileupload-new thumbnail">
                    									<img src="<?=$images[$i-1]?MEDIA_DOMAIN.'/resize/170x106'.$images[$i-1]: BASE_ASSET .'images/no-photo.jpg'?>" alt="" />
                    								</div>
                    								<div class="fileupload-preview fileupload-exists thumbnail js_thumbnail"></div>
                    								<div>
                    									<span class="btn mini btn-file"><span class="fileupload-new">Tải lên PDF</span>
                    									<span class="fileupload-exists">Thay đổi</span>
                    									<input type="file" class="default inp_image" name="image_<?=$i?>" /></span>
                                                        <?php if ($i==1) {
            ?><a href="/<?=$mod?>/del_cover?id=<?=$library_id?>" onclick="return confirm('Bạn có chắc chắn muốn xóa trang này?')" class="btn mini">Xóa</a><?php
        } ?>
                                                        <a href="#" class="btn mini fileupload-exists" data-dismiss="fileupload">Hủy</a>
                    								</div>
                    							</div>
                    						</div>
                                        </div>
                                    </form>
                                    <?php
    } ?>
                                    <div style="clear: both;"></div>
                                </div>
    						</div>
    						<div class="tab-pane active" id="tab_1_2">
                                <form action="/<?=$mod?>/upload?id=<?=$_GET['id']?>" method="post" enctype="multipart/form-data" class="horizontal-form" id="frm_upload_all">
        							<div class="control-group">
    									<label class="control-label">Chọn file PDF</label>
    									<div class="controls">
    										<div class="fileupload fileupload-new" data-provides="fileupload">
    											<div class="input-append">
    												<div class="uneditable-input">
    													<i class="icon-file fileupload-exists"></i> 
    													<span class="fileupload-preview"></span>
    												</div>
    												<span class="btn btn-file">
        												<span class="fileupload-new">Select file</span>
        												<span class="fileupload-exists">Change</span>
        												<input name="pdf" type="file" class="default" />
    												</span>
    												<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                    <button type="submit" class="btn green"><i class="icon-upload-alt"></i> Upload</button>
    											</div>
    										</div>
    									</div>
    								</div>
                                </form>
    						</div>
                            <div class="tab-pane" id="tab_1_3">
                                <form action="" method="post" enctype="multipart/form-data" class="horizontal-form">
        							<div class="control-group">
    									<label class="control-label">Chọn file (JPG/PNG)</label>
    									<div class="controls">
    										<div class="fileupload fileupload-new" data-provides="fileupload">
    											<div class="input-append">
    												<div class="uneditable-input">
    													<i class="icon-file fileupload-exists"></i> 
    													<span class="fileupload-preview"></span>
    												</div>
    												<span class="btn btn-file">
        												<span class="fileupload-new">Select file</span>
        												<span class="fileupload-exists">Change</span>
        												<input name="file" type="file" class="default" />
    												</span>
    												<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                    <button type="submit" class="btn green"><i class="icon-upload-alt"></i> Upload</button>
    											</div>
    										</div>
    									</div>
    								</div>
                                    <div class="control-group">
										<div class="controls">
											<label class="radio line">
    											<input type="radio" name="type" value="begin" checked="checked" />
    											Chèn vào trang đầu
											</label>
											<label class="radio line">
    											<input type="radio" name="type" value="end" />
                                                Chèn vào trang cuối
											</label>  
										</div>
									</div>
                                    <input type="hidden" name="action" value="insert" />
                                </form>
                            </div>
    					</div>
    				</div>
                    
                    
				</div>
			</div>
			<!-- END PAGE CONTENT-->
		</div>
		<!-- END PAGE CONTAINER-->
	</div>
	<!-- END PAGE -->    
</div>
<script src="<?=URL_JS?>/jquery.form.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('.frm_image').ajaxForm({
        success: function(responseText, statusText, xhr, $form){
            $form.find('.js_thumbnail').html('<img src="'+responseText+'">');
        }
    });
    $('#wrap_images .inp_image').change(function(){
        if($(this).val()) {
            $(this).parents('form').submit();
        }
    });
    $('#frm_upload_all').ajaxForm({
        dataType: 'json',
        beforeSend: function() {
            $('#btn_open_upload').click();
            $('#statusss').text('Trạng thái: đang tải lên máy chủ');
        },
        uploadProgress: function(event, position, total, percentComplete) {
            $('#bar_upload').width(percentComplete+'%');
        },
        success: function() {
            $('#bar_upload').parents('.progress').removeClass('progress-striped').addClass('progress-success');
        },
        complete: function(xhr) {
    		var res = xhr.responseText;
            if(res=='0') {
                setTimeout(function(){
                    alert('Vui lòng chọn file cần upload');
                }, 2000);
                $('#modal_upload .btn_close').click();
                return false;
            }
            var obj = jQuery.parseJSON(res);
            var total_page = obj.length;
            var percent = 0;
            $('#bar_progress').parents('.progress').addClass('progress-striped');
            $('#btn_open_upload').html('');
            $.each(obj, function(page, pdf) {
                percent = ((page+1)/total_page)*100;
                $('#btn_open_upload').append('<span data-percent="'+percent+'" data-page="'+(page+1)+'">'+pdf+'</span>');
            });
            updatePDF();
    	}
    });
    var request_vc;
    function updatePDF() {
        var obj = $('#btn_open_upload span:eq(0)');
        if(obj.length) {
            var page = obj.attr('data-page');
            var percent = obj.attr('data-percent');
            var pdf = obj.text();
            $('#statusss').text('Trạng thái: đang xử lý trang '+page+' ...');
            request_vc = $.ajax({
        		type: "POST",
        		url: "/<?=$mod?>/pdf2jpg",
        		data:  {slug: '<?=$slug?>', page: page, pdf: pdf},
        		dataType: "html",
        		success: function(msg){
                    $('#bar_progress').width(percent+'%');
                    $('#pdf2jpg_success').append('|'+msg);
                    obj.remove();
                    updatePDF();
        		},
                error: function(request,error) {
                    alert("Can't do because: "+error);
                    return false;
                }
        	});
        }
        else {
            if($('#btn_open_upload').html()=='cancel') {
                $('#btn_open_upload').html('');
                return false;
            }
            $('#bar_progress').parents('.progress').removeClass('progress-striped').addClass('progress-success');
            $('#statusss').text('Vui lòng chờ trong giây lát ...');
            var images = $('#pdf2jpg_success').html();
            $('#pdf2jpg_success').html('');
            request_vc = $.ajax({
        		type: "POST",
        		url: "/<?=$mod?>/update_images",
        		data:  {id: <?=$_GET['id']?>, images: images},
        		dataType: "html",
        		success: function(msg){
                    $('#bar_upload').width('0%');
                    $('#bar_progress').width('0%');
                    $('#bar_upload').parents('.progress').addClass('progress-striped').removeClass('progress-success');
                    $('#bar_progress').parents('.progress').addClass('progress-striped').removeClass('progress-success');
                    $('#modal_upload .btn_cancel').addClass('hide');
                    $('#modal_upload .btn_done').removeClass('hide');
                    $('#statusss').text('Đã xong! Hãy tải lại trang');
        		},
                error: function(request,error) {
                    alert("Can't do because: "+error);
                    return false;
                }
        	});
            return false;
        }
    }
    $('#modal_upload .btn_cancel').click(function(){
        $('#bar_upload').width('0%');
        $('#bar_progress').width('0%');
        $('#bar_upload').parents('.progress').addClass('progress-striped').removeClass('progress-success');
        $('#bar_progress').parents('.progress').addClass('progress-striped').removeClass('progress-success');
        $('#modal_upload .btn_close').click();
        $('#pdf2jpg_success').html('');
        $('#btn_open_upload').html('cancel');
        request_vc.abort();
        return false;
    });
});
</script>
<a href="#modal_upload" class="hide" data-toggle="modal" id="btn_open_upload"></a>
<div class="hide" id="pdf2jpg_success"></div>
<div id="modal_upload" class="modal hide fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
	<div class="modal-body">
		<h3>Tải lên</h3>
        <div class="progress progress-striped active">
			<div id="bar_upload" style="width: 0%;" class="bar"></div>
		</div>
        <h3>Xử lý</h3>
        <div class="progress progress-striped active">
			<div id="bar_progress" style="width: 0%;" class="bar"></div>
		</div>
        <div id="statusss"></div>
	</div>
	<div class="modal-footer">
		<button type="button" data-dismiss="modal" class="btn btn_cancel">Hủy</button>
        <button type="button" data-dismiss="modal" class="btn btn_close hide">Đóng</button>
        <a href="/library/edit?id=<?=$_GET['id']?>" class="btn green hide btn_done">Đã xong, tải lại trang</a>
	</div>
</div>