<?php $mod = current_method()['mod']; ?>
<style>
textarea {font-family: Courier New !important; font-size: 12px !important; line-height: 14px !important;}
</style>
<div class="page-container row-fluid">
	<?php getBlock('menu') ?>
	<div class="page-content">
		<div class="container-fluid">
            <br />
            <?php getBlock('tab_ads') ?>
            
			<div class="row-fluid">
				<div class="span12">
					<h3 class="page-title">
						Thêm mới quảng cáo
					</h3>
					<ul class="breadcrumb">
						<li>
							<i class="icon-home"></i>
							<a href="/">Bảng điều khiển</a> 
							<i class="icon-angle-right"></i>
						</li>
						<li>
							<a href="/<?php echo $mod ?>">Quảng cáo</a>
							<i class="icon-angle-right"></i>
						</li>
						<li><a href="#">Thêm mới</a></li>
					</ul>
				</div>
			</div>
            
			<div class="row-fluid" style="font-family: Arial;">
				<div class="span12">
					
                    <form action="" method="post" enctype="multipart/form-data" class="horizontal-form" id="form_default">
						<div class="row-fluid">
							<div class="span4">
                                <div class="control-group">
                                    <label class="control-label" for="f_title">Tên vị trí</label>
    								<div class="controls">
    									<input name="title" type="text" id="f_title" class="m-wrap span12 required" value="" />
    								</div>
    							</div>
                            </div>
                            <div class="span4">
                                <label class="control-label">&nbsp;</label>
                                <div class="controls"><button class="btn blue"><i class="icon-ok"></i> Thêm</button></div>
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
    $('.open_div').click(function(){
        $($(this).attr('href')).show();
        $(this).parents('p').remove();
        return false;
    });
});
</script>

<div id="modal_qc_upload" class="modal hide fade" data-backdrop="static" data-width="705">
    <div class="modal-header">
    	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    	<h3>Upload Ads</h3>
    </div>
    <div class="modal-body">
    	<div class="tabbable tabbable-custom">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#tab_1_1" data-toggle="tab">Hình ảnh</a></li>
				<li><a href="#tab_1_2" data-toggle="tab">Flash</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab_1_1">
					<form class="form-horizontal" action="/ads/generator" method="post">
                        <div class="control-group">
							<label class="control-label">Địa chỉ liên kết</label>
							<div class="controls">
								<input name="link" type="text" class="m-wrap" placeholder="http://" />
							</div>
						</div>
                        <div class="control-group">
    						<label class="control-label">File upload</label>
    						<div class="controls">
    							<div class="fileupload fileupload-new" data-provides="fileupload">
    								<span class="btn mini btn-file">
    								<span class="fileupload-new">Select file</span>
    								<span class="fileupload-exists">Change</span>
    								<input name="file" type="file" class="default" />
    								</span>
    								<span class="fileupload-preview"></span>
    								<a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none"></a>
    							</div>
                                <span>(Filetype: .jpg, .png, .gif)</span>
    						</div>
    					</div>
                        <div class="control-group">
							<label class="control-label"></label>
							<div class="controls">
								<a href="#" class="btn_submit">Tạo mã quảng cáo</a>
							</div>
						</div>
                        <input type="hidden" name="type" value="1" />
                    </form>
				</div>
				<div class="tab-pane" id="tab_1_2">
					<form class="form-horizontal" action="/ads/generator" method="post">
                        <div class="control-group">
    						<label class="control-label">File upload</label>
    						<div class="controls">
    							<div class="fileupload fileupload-new" data-provides="fileupload">
    								<span class="btn mini btn-file">
    								<span class="fileupload-new">Select file</span>
    								<span class="fileupload-exists">Change</span>
    								<input name="file" type="file" class="default" />
    								</span>
    								<span class="fileupload-preview"></span>
    								<a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none"></a>
    							</div>
                                <span>(Filetype: .swf)</span>
    						</div>
    					</div>
                        <div class="control-group">
							<label class="control-label"></label>
							<div class="controls">
								<a href="#" class="btn_submit">Tạo mã quảng cáo</a>
							</div>
						</div>
                        <input type="hidden" name="type" value="2" />
                    </form>
				</div>
			</div>
		</div>
        <div class="control-group">
            <label class="control-label" for="f_title">Code</label>
			<div class="controls">
				<textarea name="code_generator" class="m-wrap span12" rows="5" style="width: calc(100% - 14px);"></textarea>
			</div>
		</div>
    </div>
    <div class="modal-footer">
    	<button type="button" data-dismiss="modal" class="btn btn_close">Cancel</button>
    	<button type="button" class="btn green" id="btn_add_box_save">Update</button>
    </div>
</div>
<script src="<?php echo BASE_ASSET ?>js/jquery.form.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('.open_div').click(function(){
        $($(this).attr('href')).show();
        $(this).parents('p').remove();
        return false;
    });
    $('#modal_qc_upload .btn_submit').click(function(){
        $('#modal_qc_upload textarea[name=code_generator]').val('Loading ...');
        $(this).parents('form').ajaxSubmit({
            success: function(msg) {
                $('#modal_qc_upload textarea[name=code_generator]').val(msg);
            }
        });
        return false;
    });
    $('#btn_add_box_save').unbind().click(function(){
        if(!$textareaz) return false;
        var val = $textareaz.val();
        if(val!='') val += "\n\n";
        val += $('textarea[name=code_generator]').val();
        $textareaz.val(val);
        $('textarea[name=code_generator]').val('');
        $('#modal_qc_upload .btn_close').click();
        return false;
    });
    $('textarea.js_upload').each(function(){
        $(this).removeClass('js_upload');
        $(this).before('<p><a href="#modal_qc_upload" data-toggle="modal" class="js_upload btn mini red"><i class="icon-upload-alt"></i> Upload</a></p>');
        var _this = $(this);
        $('a.js_upload').removeClass('js_upload').click(function(){
            $textareaz = _this;
        });
    });
});
</script>