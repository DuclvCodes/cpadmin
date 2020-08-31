<div class="page-container row-fluid">
	<?php getBlock('menu') ?>
	<div class="page-content">
		<div class="container-fluid">
            <br />
            <?php getBlock('tab_setting') ?>
            <form action="" method="post" enctype="multipart/form-data" class="horizontal-form" id="form_default">
    			<div class="row-fluid">
    				<div class="span12">
    					<h3 class="page-title">
    						Thêm trang
    					</h3>
    				</div>
    			</div>
                
    			<div class="row-fluid" style="font-family: Arial;">
    				<div class="span12">
					
						<div class="row-fluid">
							<div class="span10">
                                <?php if (isset($msg)) {
    echo $msg;
} ?>
                                
								<div class="control-group">
                                    <label class="control-label" for="f_title">Tiêu đề</label>
									<div class="controls">
										<input name="title" type="text" id="f_title" class="m-wrap span12 required" value="" />
									</div>
								</div>
                                <div class="control-group">
									<label class="control-label" for="f_content">Nội dung</label>
									<div class="controls">
										<textarea name="content" id="f_content" class="tinymce m-wrap span12" rows="3"></textarea>
									</div>
								</div>
                                <div class="portlet box blue" style="margin-top: 18px;">
        							<div class="portlet-title">
        								<div class="caption"><i class="icon-globe"></i> Thiết lập SEO</div>
        							</div>
        							<div class="portlet-body">
                                        <div class="control-group">
        									<label class="control-label" for="f_meta_title">Tiêu đề Google</label>
        									<div class="controls">
        										<input name="meta_title" type="text" id="f_meta_title" class="m-wrap span12" value="" />
        									</div>
        								</div>
                                        <div class="control-group">
        									<label class="control-label" for="f_meta_keyword">Từ khóa Google</label>
        									<div class="controls">
                                                <textarea name="meta_keyword" id="f_meta_keyword" class="m-wrap span12" rows="3" ></textarea>
        									</div>
        								</div>
                                        <div class="control-group">
        									<label class="control-label" for="f_meta_description">Mô tả Google</label>
        									<div class="controls">
                                                <textarea name="meta_description" id="f_meta_description" class="m-wrap span12" rows="3" ></textarea>
        									</div>
        								</div>
        							</div>
        						</div>
                                
                                <div style="text-align: center;"><button type="submit" class="btn green"><i class="icon-ok"></i> Thêm mới</button></div>
                                
							</div>
							<!--/span-->
						</div>
                        
    				</div>
    			</div>
            </form>
			<!-- END PAGE CONTENT-->
		</div>
		<!-- END PAGE CONTAINER-->
	</div>
	<!-- END PAGE -->    
</div>