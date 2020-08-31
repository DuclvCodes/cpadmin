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
			
            <?php if (isset($msg)) {
    echo $msg;
} ?>
            
			<div class="row-fluid" style="font-family: Arial;">
				
                <div class="span12">
    				<div class="span3">
    					<ul class="ver-inline-menu tabbable margin-bottom-10">
    						<li class="<?php if ($tab_active==1) {
    echo 'active';
} ?>">
    							<a data-toggle="tab" href="#tab_1-1">
    							<i class="icon-cog"></i> Cài đặt SEO</a> 
    							<span class="after"></span>                                    
    						</li>
    						<li class="<?php if ($tab_active==2) {
    echo 'active';
} ?>"><a data-toggle="tab" href="#tab_2-2"><i class="icon-picture"></i> Đổi LOGO</a></li>
    						<!--<li class="<?php if ($tab_active==3) {
    echo 'active';
} ?>"><a data-toggle="tab" href="#tab_3-3"><i class="icon-book"></i> Thông tin chung</a></li>-->
                            <li class="<?php if ($tab_active==4) {
    echo 'active';
} ?>"><a data-toggle="tab" href="#tab_4-4"><i class="icon-book"></i> Textlink</a></li>
                            <!--<li class="<?php if ($tab_active==5) {
    echo 'active';
} ?>"><a data-toggle="tab" href="#tab_5-5"><i class="icon-book"></i> Thông tin tòa soạn</a></li>-->
                            <li class="<?php if ($tab_active==6) {
    echo 'active';
} ?>"><a data-toggle="tab" href="#tab_6-6"><i class="icon-book"></i> Chân trang</a></li>
    					</ul>
    				</div>
    				<div class="span9">
    					<div class="tab-content">
    						<div id="tab_1-1" class="tab-pane <?php if ($tab_active==1) {
    echo 'active';
} ?>">
    							<div style="height: auto;" id="accordion1-1" class="accordion collapse">
    								<form action="" method="post">
    									<label class="control-label">Name Page</label>
    									<input name="name_page" type="text" placeholder="" class="m-wrap span8" value="<?php echo $name_page ?>" />
                                        
                                        <label class="control-label">Title (Home Page)</label>
    									<input name="title" type="text" placeholder="" class="m-wrap span8" value="<?php echo $title ?>" />
                                        
                                        <label class="control-label">Email tòa soạn</label>
    									<input name="email" type="text" placeholder="" class="m-wrap span8" value="<?php echo $email ?>" />
    									
                                        <label class="control-label">Keyword (Home Page)</label>
    									<textarea name="keyword" class="span8 m-wrap" rows="3"><?php echo $keyword ?></textarea>
    									
                                        <label class="control-label">Description (Home Page)</label>
    									<textarea name="description" class="span8 m-wrap" rows="3"><?php echo $description ?></textarea>
                                        
                                        <label class="control-label">Code Google Analytics</label>
    									<textarea name="analytics" class="span8 m-wrap" rows="12" style="font-family: Monaco,Menlo,Consolas,'Courier New',monospace;font-size: 11px;line-height: 14px;"><?php echo $analytics ?></textarea>
                                        
                                        <!--<label class="control-label">Comming Datetime (Now: <?php echo date('Y-m-d H:i:s') ?>)</label>
                                        <div class="input-append date datetimepickerz" data-date="<?php echo date('Y-m-d', strtotime($comming_date)) ?>T<?php echo date('H:i:00', strtotime($comming_date)) ?>Z">
											<input name="comming_date" size="16" type="text" value="<?php if ($comming_date) {
    echo date('Y-m-d H:i:00', strtotime($comming_date));
} ?>" class="m-wrap" />
											<span class="add-on"><i class="icon-remove"></i></span>
											<span class="add-on"><i class="icon-calendar"></i></span>
										</div>-->
                                        
                                        <br /><br /><br />
    									<div class="submit-btn">
    										<button type="submit" class="btn green">Save Changes</button>
    										<a href="#" class="btn">Cancel</a>
    									</div>
                                        <input type="hidden" name="action" value="seo" />
    								</form>
    							</div>
    						</div>
    						<div id="tab_2-2" class="tab-pane <?php if ($tab_active==2) {
    echo 'active';
} ?>">
    							<div style="height: auto;" id="accordion2-2" class="accordion collapse">
    								<form action="" method="post" enctype="multipart/form-data">
    									<p>Thay đổi LOGO theo sự kiện, ngày tháng nổi bật trong năm. Nếu ngoài trang giao diện chưa thay đổi, bạn vui lòng nhấn Ctrl + R để xóa cache của trình duyệt</p>
    									<br />
    									<div class="controls">
    										<div class="thumbnail" style="width: 291px; height: 170px;">
    											<img src="http://<?=DOMAIN?><?php  echo $clsClassTable->getLogo(); ?>?v=<?php echo time() ?>" alt="" />
    										</div>
    									</div>
    									<div class="space10"></div>
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
    										</div>
    									</div>
    									<div class="clearfix"></div>
    									<div class="controls">
    										<span class="label label-important">WARNING !</span>
    										<span>Hành động này có thể làm mất vĩnh viễn logo cũ. Bạn nên backup lại trước khi thay đổi ..</span>
    									</div>
    									<div class="space10"></div>
    									<div class="submit-btn">
    										<button type="submit" class="btn green">Submit</button>
    										<a href="#" class="btn">Cancel</a>
    									</div>
                                        <input type="hidden" name="action" value="logo" />
    								</form>
    							</div>
    						</div>
    						<div id="tab_4-4" class="tab-pane <?php if ($tab_active==4) {
    echo 'active';
} ?>">
    							<div style="height: auto;" id="accordion4-4" class="accordion collapse">
    								<form action="" method="post">
                                        <div class="row-fluid">
                                            <div class="span12">
                                                <div class="open_edit">
                                                    <label class="control-label">Textlink</label>
                                                </div>
            									<textarea name="textlink" class="tinymce_link_ul m-wrap" rows="3"><?php echo $textlink ?></textarea>
                                            </div>
                                        </div>
                                        
                                        <br /><br /><br />
    									<div class="submit-btn">
    										<button type="submit" class="btn green">Save Changes</button>
    										<a href="#" class="btn">Cancel</a>
    									</div>
                                        <input type="hidden" name="action" value="textlink" />
    								</form>
    							</div>
    						</div>
                            <!--<div id="tab_5-5" class="tab-pane <?php if ($tab_active==5) {
    echo 'active';
} ?>">
    							<div style="height: auto;" id="accordion5-5" class="accordion collapse">
    								<form action="" method="post">
                                        <div class="row-fluid">
                                            <div class="span9">
                                                <div class="open_edit">
                                                    <label class="control-label">About</label>
                                                </div>
            									<textarea name="about" class="tinymce m-wrap" rows="3"><?php echo $about ?></textarea>
                                            </div>
                                        </div>
                                        
                                        <br /><br /><br />
    									<div class="submit-btn">
    										<button type="submit" class="btn green">Save Changes</button>
    										<a href="#" class="btn">Cancel</a>
    									</div>
                                        <input type="hidden" name="action" value="about" />
    								</form>
    							</div>
    						</div>-->
                            <div id="tab_6-6" class="tab-pane <?php if ($tab_active==6) {
    echo 'active';
} ?>">
    							<div style="height: auto;" id="accordion6-6" class="accordion collapse">
    								<form action="" method="post">
                                        <div class="row-fluid">
                                            <div class="span9">
                                                <div class="open_edit">
                                                    <label class="control-label">Chân trang desktop</label>
                                                </div>
            									<textarea name="footer_desktop" class="tinymce m-wrap" rows="3"><?php echo $footer_desktop ?></textarea>
                                            </div>
                                        </div>
                                        <br /><br />
                                        <div class="row-fluid">
                                            <div class="span9">
                                                <div class="open_edit">
                                                    <label class="control-label">Chân trang mobile</label>
                                                </div>
            									<textarea name="footer_mobile" class="tinymce m-wrap" rows="3"><?php echo $footer_mobile ?></textarea>
                                            </div>
                                        </div>
                                        <br />
    									<div class="submit-btn">
    										<button type="submit" class="btn green">Save Changes</button>
    										<a href="#" class="btn">Cancel</a>
    									</div>
                                        <input type="hidden" name="action" value="contact" />
    								</form>
    							</div>
    						</div>
    					</div>
    				</div>
    				<!--end span9-->                                   
    			</div>
                <?php getBlock('tinymce');?>
                
			</div>
			<!-- END PAGE CONTENT-->
		</div>
		<!-- END PAGE CONTAINER-->
	</div>
	<!-- END PAGE -->    
</div>
<script type="text/javascript">
$(document).ready(function(){
    $('.open_edit .btn_open').click(function(){
        $(this).parents('label').addClass('hide');
        $(this).parents('.open_edit').find('.wrap_inp').removeClass('hide');
        return false;
    });
    $('.open_edit .btn_ok').click(function(){
        $(this).parents('.wrap_inp').addClass('hide');
        var val = $(this).parents('.wrap_inp').find('input').val();
        $(this).parents('.open_edit').find('label').removeClass('hide').find('span').text(val);
        return false;
    });
});
</script>