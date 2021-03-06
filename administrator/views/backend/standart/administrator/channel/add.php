<style>
.btn_trash {line-height: 16px; margin-top: 7px; text-decoration: none; border-bottom: 1px solid #d84a38; color: #d84a38; display: inline-block; font-size: 12px; padding: 0 3px;}
.btn_trash:hover {background: #d84a38; color: #FFF !important;}
.tbl_vertical_center td {vertical-align: middle !important;}
#form_default label.lv2 {margin-left: 20px;}
</style>
<?php $mod = current_method()['mod']; ?>
<div class="page-container row-fluid">
	<?php getBlock('menu') ?>
	<div class="page-content">
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
					<h3 class="page-title">
						Thêm sự kiện
					</h3>
					<ul class="breadcrumb">
						<li>
							<i class="icon-home"></i>
							<a href="/">Bảng điều khiển</a> 
							<i class="icon-angle-right"></i>
						</li>
						<li>
							<a href="/<?php echo $mod ?>">Dòng sự kiện</a>
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
							<div class="span8">
                                <?php if (isset($msg)) {
    echo $msg;
} ?>
                                
								<div class="control-group">
                                    <label class="control-label" for="f_title">Tiêu đề</label>
									<div class="controls">
										<input name="title" type="text" id="f_title" class="m-wrap span12 required" placeholder="tiêu đề ..." value="" />
									</div>
								</div>
                                
                                <div class="portlet box blue" style="margin-top: 18px;">
        							<div class="portlet-title">
        								<div class="caption"><i class="icon-globe"></i> SEO</div>
        							</div>
        							<div class="portlet-body">
                                        <div class="control-group">
        									<label class="control-label" for="f_meta_title">Title</label>
        									<div class="controls">
        										<input name="meta_title" type="text" id="f_meta_title" class="m-wrap span12" placeholder="nội dung thẻ <title>" value="" />
        									</div>
        								</div>
                                        <div class="control-group">
        									<label class="control-label" for="f_meta_keyword">Meta Keywords</label>
        									<div class="controls">
                                                <textarea name="meta_keyword" id="f_meta_keyword" class="m-wrap span12" rows="3" placeholder="nội dung thẻ meta keywords" ></textarea>
        									</div>
        								</div>
                                        <div class="control-group">
        									<label class="control-label" for="f_meta_description">Meta Description</label>
        									<div class="controls">
                                                <textarea name="meta_description" id="f_meta_description" class="m-wrap span12" rows="3" placeholder="nội dung thẻ meta description" ></textarea>
        									</div>
        								</div>
        							</div>
        						</div>
                                
                                
                                
							</div>
							<!--/span-->
							<div class="span4">
								<div class="portlet box blue">
        							<div class="portlet-title">
        								<div class="caption"><i class="icon-share"></i> Cài đặt</div>
        							</div>
        							<div class="portlet-body">
                                        
                                        <table class="table table-bordered table-striped">
        									<tbody>
        										<tr>
        											<td>
        												<div class="toggle_button">
                                                            <input type="hidden" name="is_hot" value="0" />
            												<input name="is_hot" value="1" type="checkbox" class="toggle"/>
            											</div>
        											</td>
        											<td>Chuyên đề đang nóng</td>
        										</tr>
        									</tbody>
        								</table>
                                        
                                        <div class="controls controls-row">
                                            <button type="submit" class="btn green pull-right"><i class="icon-ok"></i> Thêm mới</button>
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
													<img src="<?php echo BASE_ASSET.'images/no-photo.jpg' ?>" alt="" />
												</div>
												<div class="fileupload-preview fileupload-exists thumbnail" style="line-height: 20px;"></div>
												<div>
													<span class="btn btn-file"><span class="fileupload-new">Tải lên</span>
													<span class="fileupload-exists">Thay đổi</span>
													<input type="file" class="default" name="image" /></span>
													<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Hủy</a>
												</div>
											</div>
											
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