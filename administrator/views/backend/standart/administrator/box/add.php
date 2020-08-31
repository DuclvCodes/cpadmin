<?php $mod = current_method()['mod']; ?>
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
            <br />
            <?php getBlock('tab_setting') ?>
			<div class="row-fluid">
				<div class="span12">
					<h3 class="page-title">
						Thêm Hộp tin
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
                                
								<div class="control-group">
									<div class="span6">
                                        <label class="control-label" for="f_title">Tiêu đề</label>
    									<div class="controls">
    										<input name="title" type="text" id="f_title" class="m-wrap span12 required" value="" />
    									</div>
                                    </div>
                                    <div class="span6">
                                        <label class="control-label" for="f_title_show">Tiêu đề hiển thị ngoài giao diện</label>
    									<div class="controls">
    										<input name="title_show" type="text" id="f_title_show" class="m-wrap span12" value="" />
    									</div>
                                    </div>
                                    <div style="clear: both;"></div>
								</div>
                                <div class="row-fluid">
                                    <div class="span4">
                                        <div class="control-group">
        									<label class="control-label" for="f_slug">Mã Hộp tin</label>
        									<div class="controls">
        										<input name="slug" type="text" id="f_slug" class="m-wrap span12" placeholder="viết liền không dấu ..." value="" />
        									</div>
        								</div>
                                    </div>
                                    <div class="span4">
                                        <div class="control-group">
            								<label class="control-label" for="f_title">Chuyên mục</label>
            								<div class="controls" style="display: inline-block; width: 100%;">
                                                <?php echo $clsCategory->getSelect('category_id', 0, 'span12', false, ' --- Trang chủ --- ') ?>
            								</div>
            							</div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span4">
                                        <div class="control-group">
        									<label class="control-label" for="f_count_item">Số lượng tin trang chủ</label>
        									<div class="controls">
        										<input name="count_item" type="text" id="f_count_item" class="m-wrap span12" value="" maxlength="2" />
        									</div>
        								</div>
                                    </div>
                                    <div class="span4">
                                        <div class="control-group">
        									<label class="control-label" for="f_count_item_2">Số lượng tin trang chuyên mục</label>
        									<div class="controls">
        										<input name="count_item_2" type="text" id="f_count_item_2" class="m-wrap span12" value="" maxlength="2" />
        									</div>
        								</div>
                                    </div>
                                </div>
							</div>
							<!--/span-->
							<div class="span4">
								<div class="portlet box blue">
        							<div class="portlet-title">
        								<div class="caption"><i class="icon-share"></i> Thông tin khác</div>
        							</div>
        							<div class="portlet-body">
                                        
                                        <table class="table table-bordered table-striped">
        									<tbody>
        										<tr>
        											<td>
        												<div class="toggle_button">
                                                            <input type="hidden" name="is_lock" value="0" />
            												<input name="is_lock" value="1" type="checkbox" class="toggle" <?php if (1) {
    echo 'checked="checked"';
} ?> />
            											</div>
        											</td>
        											<td>Khóa chuyên mục</td>
        										</tr>
        									</tbody>
        								</table>
                                        
                                        <div class="controls controls-row">
                                            <button type="submit" class="btn green pull-right"><i class="icon-ok"></i> Thêm mới</button>
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