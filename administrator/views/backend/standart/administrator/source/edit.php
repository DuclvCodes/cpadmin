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
						Chỉnh sửa nguồn tin <small><?php echo $title ?></small>
                        <a href="/source/add" class="btn green pull-right">Thêm mới <i class="icon-plus"></i></a>
					</h3>
					<ul class="breadcrumb">
						<li>
							<i class="icon-home"></i>
							<a href="/">Bảng điều khiển</a> 
							<i class="icon-angle-right"></i>
						</li>
						<li>
							<a href="/<?php echo $mod ?>">Nguồn tin</a>
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
                                    <label class="control-label" for="f_title">Tiêu đề</label>
									<div class="controls">
										<input name="title" type="text" id="f_title" class="m-wrap span12 required" placeholder="tiêu đề ..." value="<?php echo $title ?>" />
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
        										<input name="meta_title" type="text" id="f_meta_title" class="m-wrap span12 required" placeholder="nội dung thẻ <title>" value="<?php echo $meta_title ?>" />
        									</div>
        								</div>
                                        <div class="control-group">
        									<label class="control-label" for="f_meta_keyword">Meta Keywords</label>
        									<div class="controls">
                                                <textarea name="meta_keyword" id="f_meta_keyword" class="m-wrap span12" rows="3" placeholder="nội dung thẻ meta keywords" ><?php echo $meta_keyword ?></textarea>
        									</div>
        								</div>
                                        <div class="control-group">
        									<label class="control-label" for="f_meta_description">Meta Description</label>
        									<div class="controls">
                                                <textarea name="meta_description" id="f_meta_description" class="m-wrap span12" rows="3" placeholder="nội dung thẻ meta description" ><?php echo $meta_description ?></textarea>
        									</div>
        								</div>
        							</div>
        						</div>
                                <div class="portlet box blue" style="margin-top: 18px;">
                                    <div class="portlet-title">
                                        <div class="caption"><i class="icon-globe"></i> Cấu hình bóc tin</div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="control-group">
                                            <label class="control-label" for="f_meta_title">Tên miền</label>
                                            <div class="controls">
                                                <input name="domain" type="text" id="f_meta_title" class="m-wrap span12 required" placeholder="Tên miền. Ví dụ : tuoitre.vn" value="<?php echo $domain ?>" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="f_meta_keyword">Thẻ lấy tiêu đề</label>
                                            <div class="controls">
                                                <input name="tag_title" type="text" id="f_meta_title" class="m-wrap span12" placeholder="Tên thẻ lấy tiêu đề. Ví dụ : h1[class=article-title]" value="<?php echo $tag_title ?>" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="f_meta_keyword">Thẻ lấy Sapo</label>
                                            <div class="controls">
                                                <input name="tag_sapo" type="text" id="f_meta_title" class="m-wrap span12" placeholder="Tên thẻ lấy sapo. Ví dụ : h2[class=sapo]" value="<?php echo $tag_sapo ?>" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="f_meta_keyword">Thẻ lấy nội dung</label>
                                            <div class="controls">
                                                <input name="tag_content" type="text" id="f_meta_title" class="m-wrap span12 required" placeholder="Tên thẻ lấy nội dung. Ví dụ : div[id=main-detail-body]" value="<?php echo $tag_content ?>" />
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
                                            <a href="/<?php echo $mod ?>/trash?id=<?php echo $_GET['id'] ?>" title="" class="btn_trash">Bỏ vào thùng rác</a>
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
                                            <a href="/source/delete?id=<?php echo $_GET['id'] ?>" title="" class="btn_trash">Xóa vĩnh viễn</a>
                                            <a href="/source/restore?id=<?php echo $_GET['id'] ?>" class="btn green pull-right"><i class="icon-undo"></i> Phục hồi</a>
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