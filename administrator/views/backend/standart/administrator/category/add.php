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
					<h3 class="page-title" style="margin-top: 0;">
						Thêm chuyên mục mới
					</h3>
					<ul class="breadcrumb">
						<li>
							<i class="icon-home"></i>
							<a href="/">Dashboard</a> 
							<i class="icon-angle-right"></i>
						</li>
						<li>
							<a href="/<?php echo $mod ?>">Chuyên mục</a>
							<i class="icon-angle-right"></i>
						</li>
						<li><a href="#">Thêm</a></li>
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
                                
                                <div class="span6" style="margin-left: 0;">
                                    <div class="control-group">
    									<label class="control-label" for="f_title">Tiêu đề</label>
    									<div class="controls">
    										<input name="title" type="text" id="f_title" class="m-wrap span12 required" placeholder="tiêu đề ..." value="" />
    									</div>
    								</div>
                                </div>
                                <div class="span6">
                                    <div class="control-group">
        								<label class="control-label" for="f_title">Danh mục cha</label>
        								<div class="controls" style="display: inline-block; width: 100%;">
                                            <?php echo $clsCategory->getSelect('parent_id', isset($parent_id) ? $parent_id : '', 'span12', false, ' --- Danh mục gốc --- ') ?>
        								</div>
        							</div>
                                </div>
                                <div style="clear: both;"></div>
                                <div class="span6" style="margin-left: 0;">
                                    <div class="control-group">
                                        <label class="control-label" for="f_title">Cho phép hiển thị trên <?=DOMAIN_NAME?></label>
                                        <div class="toggle_button">
                                            <input type="hidden" name="mainsite" value="0" />
                                            <input name="mainsite" value="1" type="checkbox" class="toggle" <?php if (isset($mainsite)) {
    echo 'checked="checked"';
} ?> />
                                        </div>
                                    </div>
                                </div>
                                <div style="clear: both;"></div>
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
        								<div class="caption"><i class="icon-share"></i> Push Layouts</div>
        							</div>
        							<div class="portlet-body">
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