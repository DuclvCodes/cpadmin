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
					<h3 class="page-title" style="margin-top: 0;">
						<?php echo $title ?>
                        <a href="/<?php echo $mod ?>/add" class="btn green pull-right"><i class="icon-plus"></i> Thêm mới</a>
					</h3>
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
                                
                                
                                <div class="portlet box blue tabbable">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-stackexchange"></i>
                                            <span class="hidden-480">Codes</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body form" style="padding: 8px;">
                                        <textarea name="content" maxlength="5000" class="m-wrap span12 js_upload" rows="20" ><?php echo $content ?></textarea>
                                    </div>
                                </div>
                                
                                <p>+ <a href="#field_intro" class="open_div">Thêm ghi chú</a></p>
                                <div class="control-group" id="field_intro" style="display: none;">
									<label class="control-label" for="f_intro">Note</label>
									<div class="controls">
                                        <textarea name="intro" maxlength="1000" id="f_intro" class="m-wrap span12" rows="20" ><?php echo $intro ?></textarea>
									</div>
								</div>
                                
							</div>
							<!--/span-->
							<div class="span4">
								<div class="portlet box blue">
        							<div class="portlet-title">
        								<div class="caption"><i class="icon-share"></i> Thông tin chung</div>
        							</div>
        							<div class="portlet-body">
                                        <table class="table table-bordered table-striped">
        									<tbody>
        										<tr>
        											<td>
        												<div class="toggle_button">
                                                            <input type="hidden" name="is_show" value="0" />
            												<input name="is_show" value="1" type="checkbox" class="toggle" <?php if ($is_show) {
    echo 'checked="checked"';
} ?> />
            											</div>
        											</td>
        											<td>Hiển thị/ Ẩn</td>
        										</tr>
        									</tbody>
        								</table>
                                        <div class="control-group">
                                            <label class="control-label" for="f_title">Tên đối tác</label>
        									<div class="controls">
        										<input name="title" maxlength="255" type="text" id="f_title" class="m-wrap span12 required" value="<?php echo $title ?>" />
        									</div>
        								</div>
                                        <div class="control-group">
                                            <label class="control-label" for="f_todate">Thời hạn</label>
        									<div class="controls">
        										<input name="todate" type="text" id="f_todate" class="m-wrap span12 datepicker" value="<?=$todate?date('d/m/Y', strtotime($todate)):date('d/m/Y', time()+60*60*24*30*3)?>" />
        									</div>
        								</div>
                                        <div class="row-fluid">
                                            <div class="span6">
                                                <div class="control-group">
                                                    <label class="control-label" for="f_width">Chiều rộng</label>
                									<div class="controls">
                										<input name="width" maxlength="4" type="text" id="f_width" class="m-wrap span12" value="<?php echo $width ?>" />
                									</div>
                								</div>
                                            </div>
                                            <div class="span6">
                                                <div class="control-group">
                                                    <label class="control-label" for="f_height">Chiều cao</label>
                									<div class="controls">
                										<input name="height" maxlength="3" type="text" id="f_height" class="m-wrap span12" value="<?php echo $height ?>" />
                									</div>
                								</div>
                                            </div>
                                        </div>
                                        
                                        <div class="alert alert-info">
                                        <?php if (!$allArea && !$allAds) {
    ?>
                                            <p class="help-block">Hiện tại, quảng cáo này chưa được chạy trên website</p>
                                        <?php
} else {
        ?>
                                            <p class="help-block">Vùng quảng cáo đang chạy: 
                                                <?php if ($allAds) {
            foreach ($allAds as $id) {
                ?><a class="btn mini blue" href="/ads/edit?id=<?=$id?>"><?=$clsAds->getTitle($id)?></a> <?php
            }
        } ?>
                                                <?php if ($allArea) {
            foreach ($allArea as $id) {
                $one = $clsArea->getOne($id); ?><a class="btn mini blue" href="/ads/editcat?id=<?=$id?>"><?=$clsAds->getTitle($one['ads_id'])?> [<?=$one['title']?>]</a> <?php
            }
        } ?>
                                            </p>
                                        <?php
    } ?>
                                        </div>
                                        <div class="alert alert-info">
                                            <span class="help-block">Sửa bởi: <b><?php echo $clsUser->getLashname($user_edit) ?></b> lúc <b><?=date('H:i d/m/Y', $last_edit)?></b></span>
                                        </div>
                                        
                                        <div class="controls controls-row">
                                            <button type="submit" class="btn green pull-right"><i class="icon-ok"></i> Cập nhật</button>
                                        </div>                                                                                                                                                       
        							</div>
        						</div>
                                
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
					<form class="form-horizontal" action="/code/generator" method="post">
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
					<form class="form-horizontal" action="/code/generator" method="post">
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