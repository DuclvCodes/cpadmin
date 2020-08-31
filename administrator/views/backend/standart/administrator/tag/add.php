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
						Thêm từ khóa
					</h3>
					<ul class="breadcrumb">
						<li>
							<i class="icon-home"></i>
							<a href="/">Bảng điều khiển</a> 
							<i class="icon-angle-right"></i>
						</li>
						<li>
							<a href="/<?php echo $mod ?>">Từ khóa</a>
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
                                
								<div class="control-group">
                                    <label class="control-label" for="f_title">Từ khóa</label>
									<div class="controls">
										<input name="title" type="text" id="f_title" class="m-wrap span12 required" value="" />
									</div>
								</div>
                                
                                <div class="portlet box blue" style="margin-top: 18px;">
        							<div class="portlet-title">
        								<div class="caption"><i class="icon-globe"></i> Hỗ trợ SEO</div>
        							</div>
        							<div class="portlet-body">
                                        <div class="control-group">
        									<label class="control-label" for="f_meta_title">Tiêu đề Google</label>
        									<div class="controls">
        										<input maxlength="70" name="meta_title" type="text" id="f_meta_title" class="m-wrap span12 maxlength" value="" />
        									</div>
        								</div>
                                        <div class="control-group">
        									<label class="control-label" for="f_meta_keyword">Từ khóa Google</label>
        									<div class="controls">
                                                <textarea maxlength="255" name="meta_keyword" id="f_meta_keyword" class="m-wrap span12 maxlength" rows="3" ></textarea>
        									</div>
        								</div>
                                        <div class="control-group">
        									<label class="control-label" for="f_meta_description">Mô tả Google</label>
        									<div class="controls">
                                                <textarea maxlength="160" name="meta_description" id="f_meta_description" class="m-wrap span12 maxlength" rows="3" ></textarea>
        									</div>
        								</div>
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
                                                            <input type="hidden" name="is_pick" value="0" />
            												<input name="is_pick" value="1" type="checkbox" class="toggle" <?php if (isset($is_pick)) {
    echo 'checked="checked"';
} ?> />
            											</div>
        											</td>
        											<td>Từ khóa bản sắc</td>
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